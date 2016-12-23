<?php
namespace frontend\modules\pages\controllers;


use common\models\core\UsersEmail;
use common\models\news\NewsTag;
use common\models\news\Tags;
use yii;
use yii\data\Pagination;
use common\models\program\Program;
use frontend\modules\news\models\News;
use frontend\controllers\FrontController;


/**
 * Index controller
 */
class IndexController extends  FrontController
{
    //факт новости
    public function actionFakt(){
        return $this->redirect(['type']);
    }

    //вывод  ленты программ
    public function actionType($id=null, $date=null){

        if(Yii::$app->request->isAjax) {
            $id = Yii::$app->request->post('id');
            //Thu Dec 01 2016 00:00:00 GMT+0200 (Финляндия (зима)) -chrom
            //Thu Dec 01 2016 00:00:00 GMT+0200 - firefox
            $date_str =Yii::$app->request->post('date');
            $temp = explode('(',$date_str); //обрезаем русский текст для хрома
            $date = strtotime($temp[0]);
            $ref = Yii::$app->request->referrer;
            //$ref = explode('?', $ref);
            //$ref = $ref[0]. '?id=' . $id .'&date=' . $date;
            $ref = '/pages/index/type';
            $ref .=  '?id=' . $id .'&date=' . $date;
            return $this->redirect($ref);
        }


        $language ='ua';
        $session = Yii::$app->session;
        $session->open();
        if ($session->has('lang') && $session['lang'] == 'ru' ){
            $language ='ru';
        }

        $query = News::find()
            ->where(['is_advertising'=>'0'])
            ->andWhere(['is_announcement'=>'0'])
            ->andWhere(['show' => '1'])
            ->andWhere(['<', 'date_news', time()]);

        if(is_null($id) || $id == ''){//обрабатываем факт новости
            if(!is_null($date)){ //архив
                $endday = $date+ 60*60*24;
                $query->andWhere(['program_id' => null])
                    ->andWhere(['and', "date_news >= $date", "date_news < $endday"])
                    ->orderBy(['date_news' => SORT_DESC]);
            }else{
                $query->andWhere(['program_id' => null])
                    ->orderBy(['date_news' => SORT_DESC]);
            }
            $program = null;

            $this->setTitle('Факт новини');
            //$this->setMetaDescription();
            //$this->setMetaKeywords();
        }
        else{ //обрабатываем программы
            $program_id = (int)$id;
            $program= Program::find()
                ->where(['id' => $program_id])
                ->andWhere(['active' => '1'])
                ->one();
            if(!$program){
                throw new \yii\web\NotFoundHttpException();
            }

            $this->setTitle($program->{'meta_title_' . $language});
            $this->setMetaDescription($program->{'meta_description_' . $language});
            $this->setMetaKeywords($program->{'meta_keywords_' . $language});


            //проверяем на главные новости
            if($program->is_main == 1){
                if(!is_null($date)){ //архив
                    $endday = $date+ 60*60*24;

                    $query->andWhere(['is_main' => '1'])
                          ->andWhere(['and', "date_news >= $date", "date_news < $endday"])
                          ->orderBy(['date_news' => SORT_DESC]);
                }else{
                    $query->andWhere(['is_main' => '1'])
                          ->orderBy(['date_news' => SORT_DESC]);
                }
            }
            else{ //остальные программы
                if(!is_null($date)){ //архив программ
                    $endday = $date+ 60*60*24;
                    $query->andWhere(['and', "date_news >= $date", "date_news < $endday"])
                        ->andWhere(['program_id' => $program_id])
                        ->orderBy(['date_news'=> SORT_DESC]);
                }else{
                    $query->orderBy(['date_news'=> SORT_DESC])
                        ->andWhere(['program_id' => $program_id]);
                }
            }
        }

        $countQuery = clone $query;

        $pages = new Pagination(['totalCount' => $countQuery->count(), 'pageSize' => Yii::$app->params['pageSize']]);
        $pages->pageSizeParam = false;

        $news = $query->offset($pages->offset)
            ->limit($pages->limit)
            ->all();

        $today = strtotime('today');
        $yesterday = strtotime('yesterday');
        $first_day_of_mounth = strtotime(date("Y-M-01"));

        $sortNews = [];
        foreach ($news as $item){
            if($item['date_news'] > $today){
                $sortNews['today'][] = $item;
            }
            elseif ($item['date_news'] >= $yesterday && $item['date_news'] < $today){
                $sortNews['yesterday'][] = $item;
            }elseif ($item['date_news'] >= $first_day_of_mounth && $item['date_news'] < $yesterday){
                $sortNews['in_mounth'][] = $item;
            }else{
                $sortNews['earlier'][] = $item;
            }
        }

        if(is_null($date)){
            $setCalendarDate = date('d,m,Y', time());
            $showCalendar =false;
        }
        else{
            $setCalendarDate = date('d,m,Y', $date);
            $showCalendar =true;
        }
        return $this->render('index', [
            'setCalendarDate'     => $setCalendarDate,
            'showCalendar'        => $showCalendar,
            'today'               => $this->format_date($today, $language),
            'yesterday'           => $this->format_date($yesterday, $language),
            'first_day_of_moubth' => $this->format_date($first_day_of_mounth, $language),
            'language'            => $language,
            'program'             => $program,
            'news'                => $sortNews,
            'pages'               => $pages,

        ]);
    }

    private function format_date($time, $language){
        $mounth = date('m', $time);
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
        return  date('d', $time).'&nbsp;'. $m.'&nbsp;'. date('Y', $time);
    }

    //архивная лента новостей
    public function actionArhiv($date=null, $anons=false){

        if(Yii::$app->request->isAjax) {
            $id = Yii::$app->request->post('id');
            $date_str =Yii::$app->request->post('date');
            $temp = explode('(',$date_str); //обрезаем русский текст для хрома
            $date = strtotime($temp[0]);
            $ref = Yii::$app->request->referrer;
            $ref = explode('?', $ref);
            $ref = $ref[0]. '?id=' . $id .'&date=' . $date;
            return $this->redirect($ref);
        }

        $language ='ua';
        $session = Yii::$app->session;
        $session->open();
        if ($session->has('lang') && $session['lang'] == 'ru' ){
            $language ='ru';
        }

        $query = News::find()
            ->where(['is_advertising'=>'0'])
            ->andWhere(['is_announcement'=>'0'])
            ->andWhere(['show' => '1'])
            ->andWhere(['<', 'date_news', time()]);

        if(!is_null($date)){
            $endday = $date+ 60*60*24;
            $query->andWhere(['and', "date_news >= $date", "date_news < $endday"])
                ->orderBy(['date_news'=> SORT_DESC]);
        }else{
            $query ->orderBy(['date_news'=> SORT_DESC]);
        }
        $countQuery = clone $query;

        $pages = new Pagination(['totalCount' => $countQuery->count(), 'pageSize' => Yii::$app->params['pageSize']]);
        $pages->pageSizeParam = false;

        $news = $query->offset($pages->offset)
            ->limit($pages->limit)
            ->all();

        $today = strtotime('today');
        $yesterday = strtotime('yesterday');
        $first_day_of_mounth = strtotime(date("Y-M-01"));

        $sortNews = [];
        foreach ($news as $item){
            if($item['date_news'] > $today){
                $sortNews['today'][] = $item;
            }
            elseif ($item['date_news'] >= $yesterday && $item['date_news'] < $today){
                $sortNews['yesterday'][] = $item;
            }elseif ($item['date_news'] >= $first_day_of_mounth && $item['date_news'] < $yesterday){
                $sortNews['in_mounth'][] = $item;
            }else{
                $sortNews['earlier'][] = $item;
            }
        }

        if(is_null($date)){
            $setCalendarDate = date('d,m,Y', time());
            $showCalendar =false;
        }
        else{
            $setCalendarDate = date('d,m,Y', $date);
            $showCalendar =true;
        }

        return $this->render('index', [
            'setCalendarDate'     => $setCalendarDate,
            'showCalendar'        => $showCalendar,
            'today'               => $this->format_date($today, $language),
            'yesterday'           => $this->format_date($yesterday, $language),
            'first_day_of_moubth' => $this->format_date($first_day_of_mounth, $language),
            'language'            => $language,
            'news'                => $sortNews,
            'pages'               => $pages,
            'arhiv'               => true
        ]);

    }

    //лента с анонсами
    public function actionAnons($date = null){
        if(Yii::$app->request->isAjax) {
            $id = Yii::$app->request->post('id');
            $date_str =Yii::$app->request->post('date');
            $temp = explode('(',$date_str); //обрезаем русский текст для хрома
            $date = strtotime($temp[0]);
            $ref = Yii::$app->request->referrer;
            $ref = explode('?', $ref);
            $ref = $ref[0]. '?id=' . $id .'&date=' . $date;
            return $this->redirect($ref);
        }

        $language ='ua';
        $session = Yii::$app->session;
        $session->open();
        if ($session->has('lang') && $session['lang'] == 'ru' ){
            $language ='ru';
        }

       
        $query = News::find()
            ->where(['is_advertising'=>'0'])
            ->andWhere(['is_announcement'=>'1'])
            ->andWhere(['show' => '1'])
            ->andWhere(['<', 'date_news', time()]);
        

        if(!is_null($date)){
            $endday = $date+ 60*60*24;
            $query->andWhere(['and', "date_news >= $date", "date_news < $endday"])
                ->orderBy(['date_news'=> SORT_DESC]);
        }else{
            $query ->orderBy(['date_news'=> SORT_DESC]);
        }
        $countQuery = clone $query;

        $pages = new Pagination(['totalCount' => $countQuery->count(), 'pageSize' => Yii::$app->params['pageSize']]);
        $pages->pageSizeParam = false;

        $news = $query->offset($pages->offset)
            ->limit($pages->limit)
            ->all();

        $today = strtotime('today');
        $yesterday = strtotime('yesterday');
        $first_day_of_mounth = strtotime(date("Y-M-01"));

        $sortNews = [];
        foreach ($news as $item){
            if($item['date_news'] > $today){
                $sortNews['today'][] = $item;
            }
            elseif ($item['date_news'] >= $yesterday && $item['date_news'] < $today){
                $sortNews['yesterday'][] = $item;
            }elseif ($item['date_news'] >= $first_day_of_mounth && $item['date_news'] < $yesterday){
                $sortNews['in_mounth'][] = $item;
            }else{
                $sortNews['earlier'][] = $item;
            }
        }

        if(is_null($date)){
            $setCalendarDate = date('d,m,Y', time());
            $showCalendar =false;
        }
        else{
            $setCalendarDate = date('d,m,Y', $date);
            $showCalendar =true;
        }

        return $this->render('index', [
            'setCalendarDate'     => $setCalendarDate,
            'showCalendar'        => $showCalendar,
            'today'               => $this->format_date($today, $language),
            'yesterday'           => $this->format_date($yesterday, $language),
            'first_day_of_moubth' => $this->format_date($first_day_of_mounth, $language),
            'language'            => $language,
            'news'                => $sortNews,
            'pages'               => $pages,
            'anons'               => true  
        ]);
      
    }

    //вывод страницы с программой
    public function actionPrograms($id){
        $language ='ua';
        $session = Yii::$app->session;
        $session->open();
        if ($session->has('lang') && $session['lang'] == 'ru' ){
            $language ='ru';
        }

        $id = (int)$id;
        $program = Program::findOne($id);

        $this->setTitle($program->{'meta_title_' . $language});
        $this->setMetaDescription($program->{'meta_description_' . $language});
        $this->setMetaKeywords($program->{'meta_keywords_' . $language});

        //для отображения дат на календаре
        $now =time();
        $news = News::find()
            ->where(['program_id' => $program->id])
            ->andWhere(['<', 'date_news', $now])
            ->andWhere(['is_announcement'=>'0'])
            ->andWhere(['is_advertising'=>'0'])
            ->limit(50)
            ->all();
       
        $setCalendarDate ='';
        foreach ($news as $item){
            $setCalendarDate .=date('d,m,Y', $item->date_news) ."| " ;
        }
        $now = date('d,m,Y', time());


        return $this->render('program', ['program'=> $program, 'language' => $language, 'setCalendarDate' =>$setCalendarDate, 'now' => $now ]);
    }

    //вывод страницы программы телепередач
    public function actionTvProgram(){
        $language ='ua';
        $session = Yii::$app->session;
        $session->open();
        if ($session->has('lang') && $session['lang'] == 'ru' ){
            $language ='ru';
        }
        $this->setTitle('Программа телепередач');
       //$this->setMetaDescription();
       //$this->setMetaKeywords();

        $curentDay =  date("w", time()) == 0 ? 7: date("w", time()) ;
        $monday =  strtotime("Monday this week");
        
        
        return $this->render('tvProgram', ['language' => $language, 'curentDay' => $curentDay, 'monday' => $monday]);
        
    }

    //поиск
    public function actionSearch($query_string = null){
        if($query_string == null || $query_string =='')
            return $this->redirect(['/']);

        $language ='ua';
        $session = Yii::$app->session;
        $session->open();
        if ($session->has('lang') && $session['lang'] == 'ru' ){
            $language ='ru';
        }


        $query = News::find()
            ->leftJoin('news_tag', 'news.id = news_tag.news_id')
            ->leftJoin('tags', 'news_tag.tag_id = tags.id')
            ->where(['like', 'news.title_ua', $query_string])
            ->orWhere(['like', 'news.title_ru', $query_string])
            ->orWhere(['like', 'news.short_description_ua', $query_string])
            ->orWhere(['like', 'news.short_description_ru', $query_string])
            //->orWhere(['like','news.description_ua',$query_string])
            //->orWhere(['like','news.description_ru',$query_string])
            ->orWhere(['like', 'tags.name', $query_string])
            ->andWhere(['<', 'news.date_news', time()])
            ->orderBy(['news.date_news' => SORT_DESC])
            ->distinct();

        $countQuery = clone $query;
        $pages = new Pagination(['totalCount' => $countQuery->count(), 'pageSize' => Yii::$app->params['pageSize']]);
        $pages->pageSizeParam = false;


        $news = $query->offset($pages->offset)
            ->limit($pages->limit)
            ->all();
        $today = strtotime('today');
        $yesterday = strtotime('yesterday');
        $first_day_of_mounth = strtotime(date("Y-M-01"));

        $sortNews = [];
        foreach ($news as $item){
            if($item['date_news'] > $today){
                $sortNews['today'][] = $item;
            }
            elseif ($item['date_news'] >= $yesterday && $item['date_news'] < $today){
                $sortNews['yesterday'][] = $item;
            }elseif ($item['date_news'] >= $first_day_of_mounth && $item['date_news'] < $yesterday){
                $sortNews['in_mounth'][] = $item;
            }else{
                $sortNews['earlier'][] = $item;
            }
        }


        return $this->render('search', [

            'today'               => $this->format_date($today, $language),
            'yesterday'           => $this->format_date($yesterday, $language),
            'first_day_of_moubth' => $this->format_date($first_day_of_mounth, $language),
            'language'            => $language,
            'news'                => $sortNews,
            'pages'               => $pages,

        ]);
    }

    //сохраняем email пользователя
    public function actionDelivery($id){
        $model = new UsersEmail();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            $model->save();
        }
        
        if(Yii::$app->request->referrer){
            return $this->redirect(Yii::$app->request->referrer);
        }else{
            return $this->goHome();
        }


    }

    //поиск по тегу
    public function actionTagSearch($id){
        $language ='ua';
        $session = Yii::$app->session;
        $session->open();
        if ($session->has('lang') && $session['lang'] == 'ru' ){
            $language ='ru';
        }

        $tag_id = (int)$id;

        $query = News::find()
            ->leftJoin('news_tag', 'news.id = news_tag.news_id')
            ->where(['news_tag.tag_id' => $tag_id])
            ->andWhere(['<', 'news.date_news', time()])
            ->orderBy(['news.date_news' => SORT_DESC])
            ;

        $countQuery = clone $query;
        $pages = new Pagination(['totalCount' => $countQuery->count(), 'pageSize' => Yii::$app->params['pageSize']]);
        $pages->pageSizeParam = false;


        $news = $query->offset($pages->offset)
            ->limit($pages->limit)
            ->all();
        $today = strtotime('today');
        $yesterday = strtotime('yesterday');
        $first_day_of_mounth = strtotime(date("Y-M-01"));

        $sortNews = [];
        foreach ($news as $item){
            if($item['date_news'] > $today){
                $sortNews['today'][] = $item;
            }
            elseif ($item['date_news'] >= $yesterday && $item['date_news'] < $today){
                $sortNews['yesterday'][] = $item;
            }elseif ($item['date_news'] >= $first_day_of_mounth && $item['date_news'] < $yesterday){
                $sortNews['in_mounth'][] = $item;
            }else{
                $sortNews['earlier'][] = $item;
            }
        }

        return $this->render('search', [
            'today'               => $this->format_date($today, $language),
            'yesterday'           => $this->format_date($yesterday, $language),
            'first_day_of_moubth' => $this->format_date($first_day_of_mounth, $language),
            'language'            => $language,
            'news'                => $sortNews,
            'pages'               => $pages,

        ]);



    }

}
