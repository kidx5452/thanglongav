<?php
namespace Webapp\Backend\Models;
class AlbumTag extends BaseModel
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
    public $albumid;

    /**
     * Initialize method for model.
     */
    public function initialize()
    {
        $this->belongsTo('albumid', '\Webapp\Backend\Models\Albummedia', 'id', array('alias' => 'Albummedia'));
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
        return 'album_tag';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return AlbumTag[]
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return AlbumTag
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }

}
