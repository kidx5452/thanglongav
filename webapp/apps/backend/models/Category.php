<?php
namespace Webapp\Backend\Models;
use Webapp\Backend\Utility\Helper;

class Category extends BaseModel
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
    public $caption;

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
    public $parentid;

    /**
     *
     * @var string
     */
    public $descriptions;

    /**
     *
     * @var integer
     */
    public $status;

    /**
     *
     * @var string
     */
    public $lang;

    /**
     *
     * @var string
     */
    public $type;

    /**
     *
     * @var string
     */
    public $view_type;

    /**
     *
     * @var string
     */
    public $layout;

    /**
     *
     * @var string
     */
    public $content;

    /**
     *
     * @var string
     */
    public $rightcolcontent;

    /**
     *
     * @var string
     */
    public $coverphoto;

    /**
     *
     * @var string
     */
    public $avatar;

    /**
     *
     * @var int
     */
    public $pintop_atid;

    /**
     *
     * @var int
     */
    public $left_atid;

    /**
     *
     * @var int
     */
    public $center_atid;

    /**
     *
     * @var int
     */
    public $right_atid;

    /**
     *
     * @var string
     */
    public $cover_video;

    /**
     * Initialize method for model.
     */
    public function initialize()
    {
        $this->useDynamicUpdate(true);
        $this->hasMany('id', '\Webapp\Backend\Models\AtCat', 'catid', array('alias' => 'AtCat'));
        $this->hasMany('id', '\Webapp\Backend\Models\Category', 'parentid', array('alias' => 'Category'));
        $this->belongsTo('usercreate', '\Webapp\Backend\Models\User', 'id', array('alias' => 'User'));
        $this->belongsTo('parentid', '\Webapp\Backend\Models\Category', 'id', array('alias' => 'Category'));
        $this->belongsTo('pintop_atid', '\Webapp\Backend\Models\Article', 'id', array('alias' => 'PinArticle'));
        $this->belongsTo('left_atid', '\Webapp\Backend\Models\Article', 'id', array('alias' => 'LeftArticle'));
        $this->belongsTo('center_atid', '\Webapp\Backend\Models\Article', 'id', array('alias' => 'CenterArticle'));
        $this->belongsTo('right_atid', '\Webapp\Backend\Models\Article', 'id', array('alias' => 'RightArticle'));
    }
    public function getlink(){
        return '/'.Helper::Cleanurl(Helper::khongdau($this->name)).'_c'.$this->id.'.html';
        //return "/category/view?id=".$this->id;
    }

    public function get_article_link(){
        return "/backend/article/index?catid={$this->id}";
        //return "/category/view?id=".$this->id;
    }

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'category';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return Category[]
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return Category
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }
    public static function position(){
        return array(
                //array('key'=>'topmenu','name'=>'Top Menu'),
                //array('key'=>'leftcatmenu','name'=>'Left Menu (Category)'),
                array('key'=>'menublockhome','name'=>'Menu Block (Home)')
        );
    }
}
