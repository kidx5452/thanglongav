<?php
namespace Webapp\Backend\Models;
class Classobj extends BaseModel
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
    public $usercreate;

    /**
     *
     * @var integer
     */
    public $datecreate;

    /**
     *
     * @var string
     */
    public $keycode;

    /**
     *
     * @var int
     */
    public $classboxid;

    /**
     * Initialize method for model.
     */
    public function initialize()
    {
        $this->belongsTo('usercreate', '\Webapp\Backend\Models\User', 'id', array('alias' => 'User'));
        $this->hasMany('id', '\Webapp\Backend\Models\User', 'classid', array('alias' => 'Pupil'));
    }

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'classobj';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return Classobj[]
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return Classobj
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }

}
