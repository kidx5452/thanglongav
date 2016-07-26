<?php
namespace Webapp\Backend\Models;
class UserRole extends BaseModel
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
    public $roleid;

    /**
     * Initialize method for model.
     */
    public function initialize()
    {
        $this->belongsTo('roleid', '\Webapp\Backend\Models\Rolegroup', 'id', array('alias' => 'Rolegroup'));
        $this->belongsTo('userid', '\Webapp\Backend\Models\User', 'id', array('alias' => 'User'));
    }

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */ 
    public function getSource()
    {
        return 'user_role';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return UserRole[]
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return UserRole
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }

}
