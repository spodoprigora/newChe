<?php
    use yii\helpers\Url;

    $language ='ua';
    $session = Yii::$app->session;
    $session->open();
    if ($session->has('lang') && $session['lang'] == 'ru' ){
        $language ='ru';
    }

    $have = 'have-';
    $str_menu ='-menu';
    $sub = 'sub';

function print_hamburger_menu($menus, $have, $str_menu, &$sub, $language, $On_programs=0, $Off_programs=0){
    foreach ($menus  as $menu){
        if(count($menu['submenu']) == 0 && $menu['full_uri'] != '/programs/in_efir' && $menu['full_uri']!='/programs/in_arhiv'){
            echo "<li><a href='". Url::to($menu['full_uri']) . "'>" . $menu['header_'. $language]. '</a></li>';
            $sub = 'sub';
        }
        else{
            if($menu['full_uri'] == '/programs/in_efir'){
                $liClass = $have . $sub . $str_menu;
                $ulClass = $sub . $str_menu;
                echo "<li class='{$liClass}'>
                             <a href='" . Url::to($menu['full_uri']) . "'>{$menu['header_' . $language]}</a>
                                <ul class='{$ulClass}'>";
                $sub .='-sub';
                foreach ($On_programs as $program){
                    echo "<li><a href='". Url::to(['/'.$menu['full_uri'], 'id'=> $program->id]) . "'>" . $program['name_' . $language]. '</a></li>';
                }
                echo "  </ul>
                </li>";
            }
            else{
                if($menu['full_uri'] == '/programs/in_arhiv'){
                    $liClass = $have . $sub . $str_menu;
                    $ulClass = $sub . $str_menu;
                    echo "<li class='{$liClass}'>
                             <a href='" . Url::to($menu['full_uri']) . "'>{$menu['header_' . $language]}</a>
                                <ul class='{$ulClass}'>";
                    $sub .='-sub';
                    foreach ($Off_programs as $program){
                        echo "<li><a href='". Url::to(['/'.$menu['full_uri'], 'id'=> $program->id]) . "'>" . $program['name_' . $language]. '</a></li>';
                    }
                    echo "  </ul>
                </li>";
                }
                else{
                    $liClass = $have . $sub . $str_menu;
                    $ulClass = $sub . $str_menu;
                    echo "<li class='{$liClass}'>
                         <a href='" . Url::to($menu['full_uri']) . "'>{$menu['header_'. $language]}</a>
                                <ul class='{$ulClass}'>";
                    $sub .='-sub';
                    print_menu($menu['submenu'], $have, $str_menu, $sub, $language, $On_programs, $Off_programs);
                    echo "  </ul>
                </li>";
                }
            }



        }
    }
}
?>
<div class="ham-conteainer">
    <div class="ham-header">
        <button class="hamburger">&#9776;</button>
        <button class="cross">&#735;</button>
    </div> <!-- end ham-header -->
    <nav class="menu">
        <ul>
            <?php  print_hamburger_menu($menus, $have, $str_menu, $sub, $language, $On_programs, $Off_programs); ?>
        </ul>
    </nav>
</div> <!-- end ham-conteainer -->




