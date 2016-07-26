<?php
namespace Webapp\Backend\Models;
class Albummedia extends BaseModel
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

    /**
     * Initialize method for model.
     */
    public function initialize()
    {
        $this->hasMany('id', '\Webapp\Backend\Models\AlbummediaDetail', 'albumid', array('alias' => 'AlbumDetail'));
        $this->belongsTo('usercreate', '\Webapp\Backend\Models\User', 'id', array('alias' => 'User'));
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
