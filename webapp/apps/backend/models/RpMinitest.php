<?php
namespace Webapp\Backend\Models;
class RpMinitest extends BaseModel
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
     * @var string
     */
    public $note_name;

    /**
     *
     * @var integer
     */
    public $point;

    /**
     *
     * @var integer
     */
    public $usercreate;

    /**
     *
     * @var integer
     */
    public $datetest;

    /**
     *
     * @var integer
     */
    public $userid;

    /**
     *
     * @var integer
     */
    public $status;

    /**
     *
     * @var string
     */
    public $type;

    /**
     *
     * @var integer
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
        return 'rp_minitest';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return RpMinitest[]
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return RpMinitest
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }

}
