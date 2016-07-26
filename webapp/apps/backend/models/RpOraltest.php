<?php
namespace Webapp\Backend\Models;
class RpOraltest extends BaseModel
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
    public $comprehension;

    /**
     *
     * @var double
     */
    public $fluency;

    /**
     *
     * @var double
     */
    public $grammar;

    /**
     *
     * @var double
     */
    public $vocabular;

    /**
     *
     * @var double
     */
    public $pronunciation;

    /**
     *
     * @var string
     */
    public $note_comprehension;

    /**
     *
     * @var string
     */
    public $note_fluency;

    /**
     *
     * @var string
     */
    public $note_grammar;

    /**
     *
     * @var string
     */
    public $note_vocabulary;

    /**
     *
     * @var string
     */
    public $note_pronunciation;

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
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return RpOraltest[]
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return RpOraltest
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'rp_oraltest';
    }

}
