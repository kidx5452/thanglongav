<?php
namespace Webapp\Backend\Models;
class RpAttitude extends BaseModel
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
     * @var double
     */
    public $attendance;

    /**
     *
     * @var double
     */
    public $participation;

    /**
     *
     * @var double
     */
    public $behavior;

    /**
     *
     * @var double
     */
    public $diligence;

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
    public $datetest;

    /**
     *
     * @var integer
     */
    public $userid;

    /**
     *
     * @var string
     */
    public $type;

    /**
     *
     * @var int
     */
    public $quarterid;

    /**
     * Initialize method for model.
     */
    public function initialize()
    {
        $this->belongsTo('userid', '\Webapp\Backend\Models\User', 'id', array('alias' => 'User'));
    }

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'rp_attitude';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return RpAttitude[]
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return RpAttitude
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }

}
