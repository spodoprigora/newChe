<ul class="pgwSlideshow">

    <?php foreach ($images as $image) : ?>
        
        <li><img src="<?= '/' . $basePath . '/' . $image->img_url ;?>" alt="<?= $image->alt; ?>"></li>
    
    <?php endforeach ; ?>

</ul>