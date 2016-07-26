<?php
namespace Webapp\Backend\Models;
class RpPresentation extends BaseModel
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
    public $visual_aids;

    /**
     *
     * @var double
     */
    public $body_language;

    /**
     *
     * @var double
     */
    public $voice;

    /**
     *
     * @var double
     */
    public $interaction;

    /**
     *
     * @var double
     */
    public $pronunciation;

    /**
     *
     * @var double
     */
    public $language_use;

    /**
     *
     * @var double
     */
    public $organization;

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
     * @var string
     */
    public $comment;

    /**
     *
     * @var string
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
        return 'rp_presentation';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return RpPresentation[]
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return RpPresentation
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }

}
