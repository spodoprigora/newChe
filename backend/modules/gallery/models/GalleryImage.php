<?php

namespace backend\modules\gallery\models;

use common\models\galery\GalleryImage as BaseGalleryImage;

class GalleryImage extends BaseGalleryImage
{

   public function transliterate($st) {
       $converter = array(
           'а' => 'a',   'б' => 'b',   'в' => 'v',
           'г' => 'g',   'д' => 'd',   'е' => 'e',
           'ё' => 'e',   'ж' => 'zh',  'з' => 'z',
           'и' => 'i',   'й' => 'y',   'к' => 'k',
           'л' => 'l',   'м' => 'm',   'н' => 'n',
           'о' => 'o',   'п' => 'p',   'р' => 'r',
           'с' => 's',   'т' => 't',   'у' => 'u',
           'ф' => 'f',   'х' => 'h',   'ц' => 'c',
           'ч' => 'ch',  'ш' => 'sh',  'щ' => 'sch',
           'ь' => '\'',  'ы' => 'y',   'ъ' => '\'',
           'э' => 'e',   'ю' => 'yu',  'я' => 'ya',
           'і' => 'i',   'ї' => 'yi',  "'" => '',
           "`" => '',

           'А' => 'A',   'Б' => 'B',   'В' => 'V',
           'Г' => 'G',   'Д' => 'D',   'Е' => 'E',
           'Ё' => 'E',   'Ж' => 'Zh',  'З' => 'Z',
           'И' => 'I',   'Й' => 'Y',   'К' => 'K',
           'Л' => 'L',   'М' => 'M',   'Н' => 'N',
           'О' => 'O',   'П' => 'P',   'Р' => 'R',
           'С' => 'S',   'Т' => 'T',   'У' => 'U',
           'Ф' => 'F',   'Х' => 'H',   'Ц' => 'C',
           'Ч' => 'Ch',  'Ш' => 'Sh',  'Щ' => 'Sch',
           'Ь' => '\'',  'Ы' => 'Y',   'Ъ' => '\'',
           'Э' => 'E',   'Ю' => 'Yu',  'Я' => 'Ya',
           'І' => 'I',   'Ї' => 'YI',
       );
       return $str=iconv("UTF-8","UTF-8//IGNORE",strtr($st, $converter));
    }

}