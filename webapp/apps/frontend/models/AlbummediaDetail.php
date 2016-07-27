<?php
namespace Webapp\Frontend\Models;
class AlbummediaDetail extends \Phalcon\Mvc\Model
{

    /**
     *
     * @var integer
     */
    public $id;

    /**
     *
     * @var integer
     */
    public $albumid;

    /**
     *
     * @var string
     */
    public $name;

    /**
     *
     * @var string
     */
    public $content;

    /**
     *
     * @var string
     */
    public $avatar;

    /**
     *
     * @var integer
     */
    public $datecreate;

    /**
     *
     * @var integer
     */
    public $usercreate;

    /**
     *
     * @var integer
     */
    public $status;

    /**
     *
     * @var string
     */
    public $descriptions;

    public function getlink(){
        //return '/'.Helper::Cleanurl(Helper::khongdau($this->name)).'_album'.$this->id.'.html';
        return "/albummedia/single?id=".$this->id;
    }

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'albummedia_detail';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return AlbummediaDetail[]
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return AlbummediaDetail
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }

    public function youtube_vimeo_thumb(){
        $url = $this->content;
        $image_url = parse_url($url);
        if($image_url['host'] == 'www.youtube.com' ||
            $image_url['host'] == 'youtube.com'){
            $array = explode("&", $image_url['query']);
            return "http://img.youtube.com/vi/".substr($array[0], 2)."/mqdefault.jpg";
        }else if($image_url['host'] == 'www.youtu.be' ||
            $image_url['host'] == 'youtu.be'){
            $array = explode("/", $image_url['path']);
            return "http://img.youtube.com/vi/".$array[1]."/mqdefault.jpg";
        }else if($image_url['host'] == 'www.vimeo.com' ||
            $image_url['host'] == 'vimeo.com'){
            $hash = unserialize(file_get_contents("http://vimeo.com/api/v2/video/".
                substr($image_url['path'], 1).".php"));
            return $hash[0]["thumbnail_medium"];
        }
    }

    public function youtube_vimeo_embed(){
        $url = $this->content;
        $image_url = parse_url($url);
        if($image_url['host'] == 'www.youtube.com' ||
            $image_url['host'] == 'youtube.com'){
            $array = explode("&", $image_url['query']);
            return '<div class="embed-responsive embed-responsive-16by9"><iframe class="embed-responsive-item" src="http://www.youtube.com/embed/'.substr($array[0], 2).'?rel=0&showinfo=0&iv_load_policy=3&modestbranding=1&nologo=1&vq=large&autoplay=1&ps=docs"></iframe></div>';
            //return "http://img.youtube.com/vi/".substr($array[0], 2)."/mqdefault.jpg";
        }else if($image_url['host'] == 'www.youtu.be' ||
            $image_url['host'] == 'youtu.be'){
            $array = explode("/", $image_url['path']);
            return '<div class="embed-responsive embed-responsive-16by9"><iframe class="embed-responsive-item" src="http://www.youtube.com/embed/'.$array[1].'?rel=0&showinfo=0&iv_load_policy=3&modestbranding=1&nologo=1&vq=large&autoplay=1&ps=docs"></iframe></div>';
            //return "http://img.youtube.com/vi/".$array[1]."/mqdefault.jpg";
        }else if($image_url['host'] == 'www.vimeo.com' ||
            $image_url['host'] == 'vimeo.com'){
            $explodeUrl = explode('/',$this->content);
            return '<div class="embed-responsive embed-responsive-16by9"><iframe class="embed-responsive-item" src="https://player.vimeo.com/video/'.$explodeUrl[3].'" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe></div>';
            //return $hash[0]["thumbnail_medium"];
        }
    }

}
