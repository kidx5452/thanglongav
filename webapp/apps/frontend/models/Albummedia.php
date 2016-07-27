<?php
namespace Webapp\Frontend\Models;
class Albummedia extends \Phalcon\Mvc\Model
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
     * @var string
     */
    public $type;

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
    public $coveravatar;

    /**
     *
     * @var string
     */
    public $content;

    public function getlink(){
        return '/'.Helper::Cleanurl(Helper::khongdau($this->name)).'_album'.$this->id.'.html';
        //return "/article/detail?id=".$this->id;
    }

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'albummedia';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return Albummedia[]
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return Albummedia
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }

}
