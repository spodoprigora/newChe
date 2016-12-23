<?php
    namespace frontend\modules\news\controllers;

    use yii;
    use yii\helpers\Url;
    use yii\helpers\ArrayHelper;
    use common\models\news\Video;
    use yii\helpers\StringHelper;
    use yii\data\ArrayDataProvider;
    use yii\web\NotFoundHttpException;
    use common\models\program\Program;
    use frontend\modules\news\models\News;
    use frontend\modules\core\models\Preview;
    use frontend\controllers\FrontController;
    use frontend\modules\news\models\rss\Feed;
    use frontend\modules\news\models\rss\RssView;

class NewsController extends FrontController
{
    //вывод страницы с новостью
    public function actionItem($id)
    {
        $language = Yii::$app->language;

        $model = News::find()
                          ->where(['id' => $id])
                          ->andWhere(['show' => '1'])
                          ->andWhere(['<', 'date_news', time()])
                          ->one();

        if (!$model) {
            throw new \yii\web\NotFoundHttpException();
        }
        $model->rating =  (int)$model->rating +1;
        $model->save();

        $this->setTitle($model->{'meta_title_' . $language});
        $this->setMetaDescription($model->{'meta_description_' . $language});
        $this->setMetaKeywords($model->{'meta_keywords_' . $language});

        return $this->render('item', [
            'model'     => $model,
            'language'  => $language,
        ]);
    }

    //форматирование даты
    private function format_date($date, $language){
        $mounth = date('m', $date);
        if($language =='ru'){
            switch ($mounth){
                case 1: $m='января'; break;
                case 2: $m='февраля'; break;
                case 3: $m='марта'; break;
                case 4: $m='апреля'; break;
                case 5: $m='мая'; break;
                case 6: $m='июня'; break;
                case 7: $m='июля'; break;
                case 8: $m='августа'; break;
                case 9: $m='сентября'; break;
                case 10: $m='октября'; break;
                case 11: $m='ноября'; break;
                case 12: $m='декабря'; break;
            }
        }
        else{
            switch ($mounth){
                case 1: $m='січня'; break;
                case 2: $m='лютого'; break;
                case 3: $m='березня'; break;
                case 4: $m='квітня'; break;
                case 5: $m='травня'; break;
                case 6: $m='червня'; break;
                case 7: $m='липня'; break;
                case 8: $m='серпня'; break;
                case 9: $m='вересня'; break;
                case 10: $m='жовтня'; break;
                case 11: $m='листопада'; break;
                case 12: $m='грудня'; break;
            }
        }
        return date('d', $date).'&nbsp;'.$m.'&nbsp;'. date('Y', $date);
    }

    //вывод видео новости в модальном окне
    public function actionPlay(){
        $language = Yii::$app->language;

        $id = (int)Yii::$app->request->post('id');

        if($id){
            $news = News::find()
                ->where(['id' => $id])
                ->andWhere(['show' => '1'])
                ->andWhere(['<', 'date_news', time()])
                ->one();
            if($news && $news->type =='video'){
                return $this->renderAjax('view', ['model' => $news, 'language' => $language]);
            }
        }
        throw new NotFoundHttpException('News not found');
    }

    //вывод rss
    public function actionRss($lang='ua') {
        $query1 = News::find()
            ->join('LEFT JOIN', 'program', 'news.program_id = program.id')
            ->where(['news.is_public_rss'=>'1','news.show' => '1'])
            ->andWhere(['program.is_public_rss' => '1'])
            ->andWhere(['<', 'date_news', time()])
            ->limit(10)
            ->asArray()
            ->all();

        $query2 = News::find()
            ->where(['program_id' => null])
            ->andWhere(['news.is_public_rss'=>'1','news.show' => '1'])
            ->andWhere(['<', 'date_news', time()])
            ->limit(10)
            ->asArray()
            ->all();

        $result =ArrayHelper::merge($query1, $query2);
        ArrayHelper::multisort($result, ['date_news'], [SORT_DESC]);
        $result = array_slice($result, 0, 10);

        $provider = new ArrayDataProvider([
            'allModels' => $result,
            'pagination' => [
                'pageSize' => 10,
            ],

        ]);

        $response = Yii::$app->getResponse();
        $headers = $response->getHeaders();

        $headers->set('Content-Type', 'application/rss+xml; charset=utf-8');

        $listlang=['ua'=>'uk-UA','ru'=>'ru-RU'];

        $response->content = RssView::widget([
            'dataProvider' => $provider,
            'channel' => [
                'title' => 'Новый Чернигов',
                'link' => Url::toRoute('/', true),
                'description' => 'Актуальные новости',
                'language' => $listlang[$lang],
                'image'=>function ($widget) {
                    $image=$widget->feed->createElement('image');
                    $url=$widget->feed->createElement('url',Url::toRoute('/img/logo-yandex.png', true));
                    $title=$widget->feed->createElement('title','Новый Чернигов');
                    $link=$widget->feed->createElement('link',Url::toRoute('/', true));
                    $image->appendChild($url);
                    $image->appendChild($title);
                    $image->appendChild($link);
                    return ['DOM'=>$image];
                },
                'yandex:logo'=>[
                    Url::toRoute('/img/logo-yandex.png', true),
                    [
                        'content'=>Url::toRoute('/img/logo-yandex-square.png', true),
                        'attribute'=>[
                            'type'=>'square'
                        ]
                    ],
                ],
            ],
            'items' => [
                'title' => function ($model, $widget) use ($lang) {
                    return $model['title_'.$lang];
                },
                'description' => function ($model, $widget) use ($lang) {
                    return StringHelper::truncateWords(strip_tags($model['short_description_'.$lang]), 50);
                },
                'link' => function ($model, $widget) {
                    return Url::toRoute(['/news/news/item', 'id' => $model['id']], true);
                },
                'guid' => function ($model, $widget) {
                    return Url::toRoute(['/news/news/item', 'id' => $model['id'], 'slug' => $model['date_news']], true);
                },
                'pubDate' => function ($model, $widget) {
                    $date = new \DateTime();
                    $date->setTimestamp($model['date_news']);
                    return $date->format(DATE_RSS);
                },
                'yandex:full-text'=>function  ($model, $widget) use ($lang) {
                    $description=Feed::strip_tags_content(
                        $model['description_'.$lang],
                        '<audio><canvas><source><track><video><iframe><object>',
                        true);
                    return ['CDATA'=>$description];
                },
                'yandex:genre'=>'message',
                'category'=>function ($model, $widget) use ($lang) {
                    if(!is_null($model['program_id'])){
                        $program = Program::findOne($model['program_id']);
                        return $program['name_'.$lang];
                    }else{
                        if($lang == 'ru'){
                            return 'Факт новости';
                        }
                        return 'Факт новини';
                    }
                },
                'enclosure'=>function ($model, $widget) {
                    if($model['type'] == 'text'){
                        $preview = Preview::find()->where(['news_id' => $model['id']])->one();

                        $pathPrev=$preview->bigUrl;
                        $file=new \SplFileInfo(Yii::getAlias('@frontend/web').$pathPrev);
                        $size=0;
                        $type='image/jpeg';
                        if ($file->isFile())
                        {
                            $size=$file->getSize();
                            $type=mime_content_type(Yii::getAlias('@frontend/web').$pathPrev);
                        }
                        return [
                            'content'=>$pathPrev?'':null,
                            'attribute'=>[
                                'url'=>Url::toRoute($pathPrev,true),
                                'length'=>$size,
                                'type'=>$type,
                            ],
                        ];
                    }
                    else{
                        $video = Video::find()->where(['news_id' => $model['id']])->one();
                        if($video->youtube_link !=''){
                            $pathVideoPrev=$video->getYoutubePreviewUrl();
                            $type='image/jpeg';
                            return [
                                'content'=>$pathVideoPrev?'':null,
                                'attribute'=>[
                                    'url'=>$pathVideoPrev,
                                    'video' => 'true',
                                    'type'=>$type,
                                ],
                            ];
                        }
                        else{
                            $pathVideo=$video->getUrl();
                            $file=new \SplFileInfo(Yii::getAlias('@frontend/web').$pathVideo);
                            $size=0;
                            $type = 'video/mp4';
                            if ($file->isFile())
                            {
                                $size=$file->getSize();
                                $type=mime_content_type(Yii::getAlias('@frontend/web').$pathVideo);
                            }
                            return [
                                'content'=>$pathVideo?'':null,
                                'attribute'=>[
                                    'url'=>Url::toRoute($pathVideo,true),
                                    'video' => 'true',
                                    'length'=>$size,
                                    'type'=>$type,
                                ],
                            ];
                        }
                    }
                }
            ]
        ]);
    }
}