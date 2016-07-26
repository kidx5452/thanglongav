<?php
namespace Webapp\Backend\Models;
class EventTag extends BaseModel
{

    /**
     *
     * @var integer
     */
    public $id;

    /**
     *
     * @var integer
     */
    public $userid;

    /**
     *
     * @var integer
     */
    public $classid;

    /**
     *
     * @var integer
     */
    public $eventid;

    /**
     * Initialize method for model.
     */
    public function initialize()
    {
        $this->belongsTo('eventid', '\Webapp\Backend\Models\Event', 'id', array('alias' => 'Event'));
        $this->belongsTo('classid', '\Webapp\Backend\Models\Classobj', 'id', array('alias' => 'Classobj'));
        $this->belongsTo('userid', '\Webapp\Backend\Models\User', 'id', array('alias' => 'User'));
    }

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'event_tag';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return EventTag[]
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return EventTag
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }

}
