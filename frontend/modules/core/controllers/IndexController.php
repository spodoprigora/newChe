<?php
    namespace frontend\modules\core\controllers;

    use yii;
    use yii\helpers\ArrayHelper;
    use common\models\core\Pages;
    use common\models\program\Program;
    use frontend\modules\news\models\News;
    use frontend\controllers\FrontController;

/**
 * Site controller
 */
class IndexController extends FrontController
{
     
    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],

        ];
    }

    /**
     * Displays homepage.
     *
     * @return mixed
     */
    public function actionIndex()
    {
        $language = Yii::$app->language;
        $main_page = Pages::find()->where(['route' => 'core/index/index'])->one();

        $this->setTitle($main_page->{'meta_title_' . $language});
        $this->setMetaDescription($main_page->{'meta_description_' . $language});
        $this->setMetaKeywords($main_page->{'meta_keywords_' . $language});

        return $this->render('index');
    }

    //переключение языков
    public function actionLang($lang)
    {
        $ref = Yii::$app->request->referrer;

        switch ($lang) {
            case 'ru':
                $lang = 'ru';
                break;
            default:
                $lang = 'ua';
                break;
        }

        $session = Yii::$app->session;
        Yii::$app->language = $lang;
        
        $session->open();
        $session['lang'] = $lang;

        if (!$ref) {
            return $this->goHome();
        }
        return $this->redirect($ref);
    }

    //вывод статических страниц
    public function actionPages(){
        $page     = Yii::$app->params[ 'page' ];
        $language = Yii::$app->language;

        $this->setTitle($page->{'meta_title_' . $language});
        $this->setMetaDescription($page->{'meta_description_' . $language});
        $this->setMetaKeywords($page->{'meta_keywords_' . $language});

        return $this->render('page', [
            'page' => $page,
            'lang' => $language,
        ]);

   }

    //вывод sitemap
    public function actionSitemap(){
        $site = 'http://' . Yii::$app->request->hostName;
        //новости
        $news = News::find()
            ->where(['show' => '1'])
            ->andWhere(['<', 'date_news', time()])
            ->orderBy(['date_news' => SORT_DESC])
            ->all();
        
        //программы
        $programs = Program::find()
            ->where(['active' => 1])
            ->all();
        //страницы
        $pages = Pages::find()
            //->where(['route' => 'core/index/pages'])
            ->andWhere(['active' => 1])
            ->andWhere(['!=', 'full_uri', '/'])
            ->andWhere(['!=', 'full_uri', '/programs'])
            ->andWhere(['!=' , 'full_uri', 'search'])
            ->all();

        $pages = ArrayHelper::toArray($pages, [
            'common\models\core\Pages' => [
                'id',
                'parent_id',
                'full_uri',
            ],
        ]);
        $pages = ArrayHelper::index($pages, 'id');
        foreach ($pages as $item){
            if($item['parent_id'] != 0){
                unset($pages[$item['parent_id']]);
            }
        }

        //динамические ленты
        $programs_ids = ArrayHelper::getColumn($programs, 'id');
        $programs_count =count($programs_ids);
        $news_ids = ArrayHelper::getColumn($news, 'id');
        $news_count=count($news_ids);
        $arhiv_page_count = ceil($news_count/Yii::$app->params['pageSize']);

        $fact_count = News::find()
            ->where(['program_id' => null])
            ->count();
        $fact_page_count = ceil($fact_count/Yii::$app->params['pageSize']);

        $announcement_count = News::find()
            ->where(['is_announcement' => 1])
            ->count();
        $announcement_page_count = ceil($announcement_count/Yii::$app->params['pageSize']);

        return $this->renderPartial('sitemap', [
            'site'          => $site,
            'news'          => $news,
            'programs'      => $programs,
            'pages'         => $pages,
            'news_ids'      => $news_ids,
            'news_count'    => $news_count,
            'programs_ids'  => $programs_ids,
            'programs_count'=> $programs_count,
            'arhiv_page_count'=> $arhiv_page_count,
            'fact_page_count'=> $fact_page_count,
            'announcement_page_count' => $announcement_page_count,
        ]);
    }

    //вывод страницы ошибки
    public function actionError(){
        return $this->render('error');
    }
}