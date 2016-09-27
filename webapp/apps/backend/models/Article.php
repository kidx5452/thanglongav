<?php
namespace Webapp\Backend\Models;
use Webapp\Backend\Utility\Helper;
class Article extends BaseModel
{

    /**
     *
     * @var integer
     */
    public $id;

    /**
     *
     * @var string
     */
    public $name;

    /**
     *
     * @var string
     */
    public $captions;

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
    public $avatar;

    /**
     *
     * @var string
     */
    public $content;

    /**
     *
     * @var string
     */
    public $lang;

    /**
     *
     * @var string
     */
    public $coveravatar;

    /**
     *
     * @var string
     */
    public $coverphoto;

    /**
     *
     * @var string
     */
    public $cover_video;

    /**
     *
     * @var string
     */
    public $types;


    /**
     *
     * @var string
     */
    public $date_publish;

    /**
     *
     * @var string
     */
    public $duration;

    /**
     *
     * @var string
     */
    public $countmedia;

    /**
     *
     * @var string
     */
    public $manufacture;

    /**
     *
     * @var string
     */
    public $price;

    /**
     * @var int
     */
    public $view_count;

    /**
     * Initialize method for model.
     */
    public function initialize()
    {
        $this->hasMany('id', '\Webapp\Backend\Models\AtCat', 'atid', array('alias' => 'AtCat'));
        $this->belongsTo('usercreate', '\Webapp\Backend\Models\User', 'id', array('alias' => 'User'));
    }

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'article';
    }
    public function getlink(){
        return '/'.Helper::Cleanurl(Helper::khongdau($this->name)).'_a'.$this->id.'.html';
        //return "/article/detail?id=".$this->id;
    }
    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return Article[]
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return Article
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }
    public static function position(){
        return array(
                array('key'=>'slideshow','name'=>'Slideshow - Bài viết slideshow'),
                //array('key'=>'leftslideshow','name'=>'Left in slideshow'),
                //array('key'=>'rightslideshow','name'=>'Right in slideshow').
                //array('key'=>'pinslideshow','name'=>'Pin in slideshow - Tin tức trong slideshow')
        );
    }
}
