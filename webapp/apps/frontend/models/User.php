<?php
namespace Webapp\Frontend\Models;
use Phalcon\Mvc\Model\Validator\Email as Email;

class User extends BaseModel
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
    public $username;

    /**
     *
     * @var string
     */
    public $password;

    /**
     *
     * @var string
     */
    public $firstname;

    /**
     *
     * @var string
     */
    public $lastname;

    /**
     *
     * @var integer
     */
    public $type;

    /**
     *
     * @var string
     */
    public $avatar;

    /**
     *
     * @var integer
     */
    public $dob;

    /**
     *
     * @var string
     */
    public $email;

    /**
     *
     * @var string
     */
    public $address;

    /**
     *
     * @var string
     */
    public $phone;

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
    public $gender;

    /**
     *
     * @var string
     */
    public $private_permission;

    /**
     *
     * @var string
     */
    public $flags;

    /**
     *
     * @var integer
     */
    public $classid;

    /**
     *
     * @var string
     */
    public $activekey;

    /**
     *
     * @var string
     */
    public $fbid;

    /**
     *
     * @var string
     */
    public $fbemail;

    /**
     *
     * @var string
     */
    public $status;

    /**
     *
     * @var string
     */
    public $active_register;

    /**
     *
     * @var string
     */
    public $phone2;

    /**
     *
     * @var string
     */
    public $father_name;

    /**
     *
     * @var string
     */
    public $mother_name;

    /**
     *
     * @var string
     */
    public $captions;

    /**
     * Validations and business logic
     *
     * @return boolean
     */
    public function validation()
    {
        $this->validate(
            new Email(
                array(
                    'field'    => 'email',
                    'required' => true,
                )
            )
        );

        if ($this->validationHasFailed() == true) {
            return false;
        }

        return true;
    }

    /**
     * Initialize method for model.
     */
    public function initialize()
    {
        $this->hasMany('id', 'Webapp\Frontend\Models\Category', 'usercreate', array('alias' => 'Category'));
        $this->hasMany('id', 'Rolegroup', 'usercreate', array('alias' => 'Rolegroup'));
        $this->hasMany('id', 'Webapp\Frontend\Models\User', 'usercreate', array('alias' => 'User'));
        $this->hasMany('id', 'Webapp\Frontend\Models\UserRole', 'userid', array('alias' => 'UserRole'));
        $this->belongsTo('usercreate', 'Webapp\Frontend\Models\User', 'id', array('alias' => 'User'));
    }

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'user';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return User[]
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return User
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }

}
