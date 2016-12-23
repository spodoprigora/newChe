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

    function print_menu($menus, $have, $str_menu, &$sub, $language, $On_programs=0, $Off_programs=0){
        foreach ($menus  as $menu){
            if(count($menu['submenu']) == 0 && $menu['full_uri'] != '/programs/in_efir' && $menu['full_uri']!='/programs/in_arhiv'){
                echo "<li><a href='". Url::to($menu['full_uri']) . "'>" . $menu['header_' . $language]. '</a></li>';
            }
            else{
                if($menu['full_uri'] == '/programs/in_efir'){
                    echo "<li class='have-sub-sub-menu right'>
                             <a href='" . Url::to($menu['full_uri']) . "'>{$menu['header_' . $language]}</a>";
                    $leftUl = "<ul class='sub-sub-menu menu-right'>";
                    $rightUl = "<ul class='sub-sub-menu-right '>";
                    $count_in_column = round((count($On_programs)/2), 0, PHP_ROUND_HALF_UP); ;
                    $program_count =0;
                    foreach ($On_programs as $program){
                        if($count_in_column > 3){
                            if($program_count < $count_in_column){
                                $leftUl .= "<li><a href='". Url::to(['/'.$menu['full_uri'], 'id'=> $program->id]) . "'>" . $program['name_' . $language]. '</a></li>';
                                $program_count++;
                            }
                            else{
                                $rightUl .= "<li><a href='". Url::to(['/'.$menu['full_uri'], 'id'=> $program->id]) . "'>" . $program['name_' . $language]. '</a></li>';
                            }
                        }
                        else{
                            $leftUl .= "<li><a href='". Url::to(['/'.$menu['full_uri'], 'id'=> $program->id]) . "'>" . $program['name_' . $language]. '</a></li>';
                        }
                    }
                    if($count_in_column > 3){
                        echo $leftUl ;
                        echo "<li class='right'>";
                        echo $rightUl . '</ul>' . '</li>';
                        echo '</ul>';
                    }
                    else{
                        echo $leftUl . '</ul>';
                    }
                    echo "</li>";
                }else{
                    if($menu['full_uri'] == '/programs/in_arhiv'){
                        echo "<li class='have-sub-sub-menu right'>
                             <a href='" . Url::to($menu['full_uri']) . "'>{$menu['header_' . $language]}</a>";
                        $leftUl = "<ul class='sub-sub-menu menu-right'>";
                        $rightUl = "<ul class='sub-sub-menu-right '>";
                        $count_in_column = round((count($Off_programs)/2), 0, PHP_ROUND_HALF_UP); ;
                        $program_count =0;
                        foreach ($Off_programs as $program){
                            if($count_in_column > 3){
                                if($program_count < $count_in_column){
                                    $leftUl .= "<li><a href='". Url::to(['/'.$menu['full_uri'], 'id'=> $program->id]) . "'>" . $program['name_' . $language]. '</a></li>';
                                    $program_count++;
                                }
                                else{
                                    $rightUl .= "<li><a href='". Url::to(['/'.$menu['full_uri'], 'id'=> $program->id]) . "'>" . $program['name_' . $language]. '</a></li>';
                                }
                            }
                            else{
                                $leftUl .= "<li><a href='". Url::to(['/'.$menu['full_uri'], 'id'=> $program->id]) . "'>" . $program['name_' . $language]. '</a></li>';
                            }
                        }
                        if($count_in_column > 3){
                            echo $leftUl ;
                            echo "<li class='right'>";
                            echo $rightUl . '</ul>' . '</li>';
                            echo '</ul>';
                        }
                        else{
                            echo $leftUl . '</ul>';
                        }
                        echo "</li>";
                    }else{
                        $liClass = $have . $sub . $str_menu;
                        $ulClass = $sub . $str_menu;
                        echo "<li class='{$liClass}'>
                             <a href='" . Url::to($menu['full_uri']) . "'>{$menu['header_' . $language]}</a>
                                <ul class='{$ulClass}'>";
                        $sub .='-sub';
                        print_menu($menu['submenu'], $have, $str_menu, $sub, $language, $On_programs, $Off_programs);
                        $sub = substr($sub, 0, -4);
                        echo "  </ul>
                    </li>";
                    }
                }
            }
        }
    }

?>


<ul>
    <?php  print_menu($menus, $have, $str_menu, $sub, $language, $On_programs, $Off_programs); ?>
</ul>