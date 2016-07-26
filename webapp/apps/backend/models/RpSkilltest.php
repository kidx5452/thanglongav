<?php
namespace Webapp\Backend\Models;
class RpSkilltest extends BaseModel
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
    public $reading;

    /**
     *
     * @var double
     */
    public $listening;

    /**
     *
     * @var double
     */
    public $writing;

    /**
     *
     * @var double
     */
    public $grammar;

    /**
     *
     * @var string
     */
    public $note_listening;

    /**
     *
     * @var string
     */
    public $note_reading;

    /**
     *
     * @var string
     */
    public $note_writing;

    /**
     *
     * @var string
     */
    public $note_grammar;

    /**
     *
     * @var integer
     */
    public $status;

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
    public $sorts;

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
        return 'rp_skilltest';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return RpSkilltest[]
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return RpSkilltest
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }

}
