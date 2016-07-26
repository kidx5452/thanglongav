<?php
namespace Webapp\Backend\Models;
class RpGeneral extends BaseModel
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
    public $datecreate;

    /**
     *
     * @var double
     */
    public $point;

    /**
     *
     * @var string
     */
    public $contents;

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'rp_general';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return RpGeneral[]
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return RpGeneral
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }

}
