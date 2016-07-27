<?php
namespace Webapp\Frontend\Models;
use Webapp\Frontend\Utility\Helper;

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
        $this->hasMany('id', 'Webapp\Frontend\Models\AtCat', 'catid', array('alias' => 'AtCat'));
        $this->hasMany('id', 'Webapp\Frontend\Models\Category', 'parentid', array('alias' => 'Category'));
        $this->hasMany('id', 'Webapp\Frontend\Models\CategoryView', 'catid', array('alias' => 'CategoryView'));
        $this->belongsTo('usercreate', 'Webapp\Frontend\Models\User', 'id', array('alias' => 'User'));
        $this->belongsTo('parentid', 'Webapp\Frontend\Models\Category', 'id', array('alias' => 'Category'));
        $this->belongsTo('pintop_atid', 'Webapp\Frontend\Models\Article', 'id', array('alias' => 'PinArticle'));
        $this->belongsTo('left_atid', 'Webapp\Frontend\Models\Article', 'id', array('alias' => 'LeftArticle'));
        $this->belongsTo('center_atid', 'Webapp\Frontend\Models\Article', 'id', array('alias' => 'CenterArticle'));
        $this->belongsTo('right_atid', 'Webapp\Frontend\Models\Article', 'id', array('alias' => 'RightArticle'));
    }

    public function getlink(){
        return '/'.Helper::Cleanurl(Helper::khongdau($this->name)).'_c'.$this->id.'.html';
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

}
