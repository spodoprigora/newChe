<?php
use frontend\modules\news\models\News;
use yii\helpers\Html;

$langs          = ['ru', 'ua'];
$priority       = 0.5;
$changefreq     = 'weekly';
header('Content-Type: application/xml');
?>
<?php echo '<?xml version="1.0" encoding="UTF-8"?>' ?>

<urlset
        xmlns="http://www.sitemaps.org/schemas/sitemap/0.9"
        xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
        xsi:schemaLocation="http://www.sitemaps.org/schemas/sitemap/0.9
                http://www.sitemaps.org/schemas/sitemap/0.9/sitemap.xsd">

    <url>
        <loc><?= $site .'/';?></loc>
    </url>
    

    <?php foreach($news as $model): ?>
        <url>
            <loc><?= $site .'/'. 'news/news/item?id=' . $model->id ; ?></loc>
                <changefreq><?=$changefreq;?></changefreq>
                <priority><?=$priority;?></priority>
        </url>
    <?php endforeach; ?>

    <?php foreach($programs as $model): ?>
        <url>
            <loc><?= $site .'/'. 'programs?id=' . $model->id; ?></loc>
            <changefreq><?=$changefreq;?></changefreq>
            <priority><?=$priority;?></priority>
        </url>
        <url>
            <loc><?= $site .'/type?id='. $model->id; ?></loc>
            <changefreq><?=$changefreq;?></changefreq>
            <priority><?=$priority;?></priority>
        </url>
    <?php endforeach; ?>

    <?php foreach($pages as $model): ?>
        <url>
            <loc><?= $site . $model['full_uri']; ?></loc>
            <changefreq><?=$changefreq;?></changefreq>
            <priority><?=$priority;?></priority>
        </url>
    <?php endforeach; ?>


    <?php foreach($programs as $model): ?>
        <?php
            $count = News::find()
                ->where(['program_id' => $model->id])
                ->count();
            $page = ceil($count/Yii::$app->params['pageSize']);
        ?>
        <?php for($i=1; $i<=$page; $i++): ?>
            <url>
                <loc><?= $site .'/pages/index/type?id='. $model->id . '&page=' . $i; ?></loc>
                <changefreq><?=$changefreq;?></changefreq>
                <priority><?=$priority;?></priority>
               <aa>!!!</aa>
            </url>
        <?php endfor;?>
    <?php endforeach; ?>

    <?php for($i=1; $i<=$fact_page_count; $i++): ?>
        <url>
            <loc><?= $site .'/pages/index/type?page=' . $i; ?></loc>
            <changefreq><?=$changefreq;?></changefreq>
            <priority><?=$priority;?></priority>
        </url>
    <?php endfor;?>

    <?php for($i=1; $i<=$arhiv_page_count; $i++): ?>
        <url>
            <loc><?= $site .'/pages/index/arhiv?page=' . $i; ?></loc>
            <changefreq><?=$changefreq;?></changefreq>
            <priority><?=$priority;?></priority>
        </url>
    <?php endfor;?>

    <?php for($i=1; $i<=$announcement_page_count; $i++): ?>
        <url>
            <loc><?= $site .'/pages/index/anons?page=' . $i; ?></loc>
            <changefreq><?=$changefreq;?></changefreq>
            <priority><?=$priority;?></priority>
        </url>
    <?php endfor;?>


</urlset>