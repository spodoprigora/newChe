<?php


namespace frontend\modules\news\models\rss;


use DateTime;
use DOMDocument;
use DOMElement;
use Exception;

class Feed extends DOMDocument
{
    const VERSION = '2.1.1';
    /** @var DomElement $rss */
    private $rss;
    /** @var DomElement $channel */
    private $channel;
    private $title;
    /** @var DomElement $item */
    private $item;

    public function __construct()
    {
        parent::__construct();
        $this->formatOutput = true;
        $this->encoding = 'utf-8';
        $rssElement = $this->createElement('rss');
        $rssElement->setAttribute('version', '2.0');
        $rssElement->setAttribute('xmlns:yandex', 'http://news.yandex.ru');
        $rssElement->setAttribute('xmlns', 'http://backend.userland.com/rss2');
        $rssElement->setAttribute('xmlns:media', 'http://search.yahoo.com/mrss/');
       // $rssElement->setAttribute('xmlns:atom', 'http://www.w3.org/2005/Atom');
        $this->rss = $this->appendChild($rssElement);
    }

    public function addChannel($href = null)
    {
        $channelElement = $this->createElement('channel');
        $this->channel = $this->rss->appendChild($channelElement);

//        $this->addChannelElement('atom:link', '', [
//            'href' => $href
//                ? $href
//                : $_SERVER['REQUEST_SCHEME'] . '://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'],
//            'rel' => 'self',
//            'type' => 'application/rss+xml'
//        ]);
        $this->addChannelGenerator();
        $this->addChannelDocs();
        return $this;
    }

    public function addChannelElement($element, $value, $attr = array())
    {
        if (is_array($value)) {
            if (isset($value['CDATA'])) {
                $element = $this->createElement($element);
                $cdata = $this->createCDATASection($value['CDATA']);
                $element->appendChild($cdata);
            }elseif (isset($value['DOM'])) {
                $this->channel->appendChild($value['DOM']);
                return $this;
            }
            elseif (isset($value['attribute'])){
                if (is_null($value['content'])) return $this;
                $element = $this->createElement($element, $this->normalizeString($value['content']));
                foreach ($value['attribute'] as $key=>$val)
                    $element->setAttribute($key,$val);
            }
        }
        else
            $element = $this->createElement($element, $this->normalizeString($value));

        foreach ($attr as $key => $value) {
            $element->setAttribute($key, $this->normalizeString($value));
        }
        $this->channel->appendChild($element);
        return $this;
    }

    public function addChannelElementWithSub($element, $sub)
    {
        $element = $this->createElement($element);
        foreach ($sub as $key => $value) {
            $subElement = $this->createElement($key, $this->normalizeString($value));
            $element->appendChild($subElement);
        }
        $this->channel->appendChild($element);
        return $this;
    }

    public function addChannelElementWithIdentSub($element, $child, $sub)
    {
        $element = $this->createElement($element);
        foreach ($sub as $value) {
            $subElement = $this->createElement($child, $this->normalizeString($value));
            $element->appendChild($subElement);
        }
        $this->channel->appendChild($element);
        return $this;
    }

    public function addChannelTitle($value)
    {
        $this->title = $value;
        return $this->addChannelElement('title', $this->title);
    }

    public function addChannelLink($value)
    {
        return $this->addChannelElement('link', $value);
    }

    public function addChannelDescription($value)
    {
        return $this->addChannelElement('description', $value);
    }

    public function addChannelLanguage($value)
    {
        return $this->addChannelElement('language', $value);
    }

    public function addChannelCopyright($value)
    {
        return $this->addChannelElement('copyright', $value);
    }

    public function addChannelManagingEditor($value)
    {
        return $this->addChannelElement('managingEditor', $value);
    }

    public function addChannelWebMaster($value)
    {
        return $this->addChannelElement('webMaster', $value);
    }

    public function addChannelPubDate($value)
    {
        return $this->addChannelElement('pubDate', $this->normalizeDateTime($value));
    }

    public function addChannelLastBuildDate($value)
    {
        return $this->addChannelElement('lastBuildDate', $this->normalizeDateTime($value));
    }

    public function addChannelCategory($value, $domain = null)
    {
        return $domain
            ? $this->addChannelElement('category', $value, ['domain' => $domain])
            : $this->addChannelElement('category', $value);
    }

    public function addChannelGenerator()
    {
        return $this->addChannelElement('generator', 'RSS Generator ' . static::VERSION);
    }

    public function addChannelDocs()
    {
        return $this->addChannelElement('docs', 'http://www.rssboard.org/rss-specification');
    }

    public function addChannelCloud($domain, $port, $path, $registerProcedure, $protocol)
    {
        return $this->addChannelElement('cloud', '', [
            'domain' => $domain,
            'port' => $port,
            'path' => $path,
            'registerProcedure' => $registerProcedure,
            'protocol' => $protocol
        ]);
    }

    public function addChannelTtl($value)
    {
        return $this->addChannelElement('ttl', $value);
    }

    public function addChannelImage($url, $link, $width = 88, $height = 31, $description)
    {
        if ($width < 1 || $width > 400) {
            throw new Exception('Width of the image must be in the range of 1 to 400 pixels. Current value is ' . $width);
        }
        if ($height < 1 || $height > 144) {
            throw new Exception('Height of the image must be in the range of 1 to 144 pixels. Current value is ' . $height);
        }
        return $this->addChannelElementWithSub('image', [
            'url' => $url,
            'title' => $this->title,
            'link' => $link,
            'width' => $width,
            'height' => $height,
            'description' => $description
        ]);
    }

    public function addChannelRating($value)
    {
        return $this->addChannelElement('rating', $value);
    }

    public function addChannelTextInput($title, $description, $name, $link)
    {
        return $this->addChannelElementWithSub('textInput', [
            'title' => $title,
            'description' => $description,
            'name' => $name,
            'link' => $link
        ]);
    }

    public function addChannelSkipHours($value)
    {
        return $this->addChannelElementWithIdentSub('skipHours', 'hour', $value);
    }

    public function addChannelSkipDays($value)
    {
        return $this->addChannelElementWithIdentSub('skipDays', 'day', $value);
    }

    public function addItem()
    {
        $item = $this->createElement('item');
        $this->item = $this->channel->appendChild($item);
        return $this;
    }

    public function addItemElement($element, $value, $attr = array())
    {
        if (is_array($value)) {
            if (isset($value['CDATA'])) {
                $element = $this->createElement($element);
                $cdata = $this->createCDATASection($value['CDATA']);
                $element->appendChild($cdata);
            }elseif (isset($value['attribute'])){
                if (is_null($value['content'])) return $this;
                $element = $this->createElement($element, $this->normalizeString($value['content']));
                foreach ($value['attribute'] as $key=>$val)
                    $element->setAttribute($key,$val);
            }
        }
        else
            $element = $this->createElement($element, $this->normalizeString($value));

        foreach ($attr as $key => $value) {
            $element->setAttribute($key, $this->normalizeString($value));
        }
        $this->item->appendChild($element);
        return $this;
    }

    public function addItemTitle($value)
    {
        return $this->addItemElement('title', $value);
    }

    public function addItemLink($value)
    {
        return $this->addItemElement('link', $value);
    }

    public function addItemDescription($value)
    {
        return $this->addItemElement('description', $value);
    }

    public function addItemAuthor($value)
    {
        return $this->addItemElement('author', $value);
    }

    public function addItemCategory($value, $domain = null)
    {
        return $domain
            ? $this->addItemElement('category', $value, ['domain' => $domain])
            : $this->addItemElement('category', $value);
    }

    public function addItemComments($value)
    {
        return $this->addItemElement('comments', $value);
    }

    public function addItemEnclosure($url, $length, $type)
    {
        return $this->addItemElement('enclosure', '', [
            'url' => $url,
            'length' => $length,
            'type' => $type
        ]);
    }

    public function addItemGuid($value, $isPermaLink = true)
    {
        return $this->addItemElement('guid', $value, ['isPermaLink' => $isPermaLink === false ? 'false' : 'true']);
    }

    public function addItemPubDate($value)
    {
        return $this->addItemElement('pubDate', $this->normalizeDateTime($value));
    }

    public function addItemSource($value, $url)
    {
        return $this->addItemElement('source', $value, ['url' => $url]);
    }

    public function __toString()
    {
        header('Content-Type: application/rss+xml; charset=utf-8');
        return $this->saveXML();
    }

    private function normalizeDateTime($value)
    {
        if ($value instanceof DateTime) {
            $datetime = $value;
        } else {
            if (is_numeric($value)) {
                $datetime = new DateTime();
                $datetime->setTimestamp($value);
            } else {
                try {
                    $datetime = new DateTime($value);
                } catch (Exception $e) {
                    echo $e->getMessage();
                    exit(1);
                }
            }
        }
        return $datetime->format(DATE_RSS);
    }

    private function normalizeString($string)
    {
        $string = html_entity_decode($string, ENT_HTML5, $this->encoding);
        $string = htmlspecialchars($string, ENT_QUOTES, $this->encoding, false);
        return $string;
    }

    public static function strip_tags_content($text, $tags = '', $invert = FALSE) {

        preg_match_all('/<(.+?)[\s]*\/?[\s]*>/si', trim($tags), $tags);
        $tags = array_unique($tags[1]);

        if(is_array($tags) AND count($tags) > 0) {
            if($invert == FALSE) {
                return preg_replace('@<(?!(?:'. implode('|', $tags) .')\b)(\w+)\b.*?>.*?</\1>@si', '', $text);
            }
            else {
                return preg_replace('@<('. implode('|', $tags) .')\b.*?>.*?</\1>@si', '', $text);
            }
        }
        elseif($invert == FALSE) {
            return preg_replace('@<(\w+)\b.*?>.*?</\1>@si', '', $text);
        }
        return $text;
    }

    public function getItem() {
        return $this->item;
    }
}