<?php
namespace Webapp\Frontend\Models;
use Webapp\Frontend\Utility\Helper;
class Configs extends BaseModel
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
    public $keys;

    /**
     *
     * @var string
     */
    public $name;

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
        return 'configs';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return Configs[]
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return Configs
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }

}
