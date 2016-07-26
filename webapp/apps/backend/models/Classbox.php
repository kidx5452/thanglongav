<?php
namespace Webapp\Backend\Models;
class Classbox extends BaseModel
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
     * @var int
     */
    public $sorts;

    /**
     *
     * @var int
     */
    public $keycode;

    /**
     * Initialize method for model.
     */
    public function initialize()
    {
        $this->hasMany('id', '\Webapp\Backend\Models\Classobj', 'classboxid', array('alias' => 'Classobj'));
    }

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'classbox';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return Classbox[]
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return Classbox
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }

}
