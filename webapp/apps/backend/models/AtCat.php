<?php
namespace Webapp\Backend\Models;
class AtCat extends BaseModel
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
    public $catid;

    /**
     *
     * @var integer
     */
    public $atid;

    /**
     * Initialize method for model.
     */
    public function initialize()
    {
        $this->belongsTo('atid', '\Webapp\Backend\Models\Article', 'id', array('alias' => 'Article'));
        $this->belongsTo('catid', '\Webapp\Backend\Models\Category', 'id', array('alias' => 'Category'));
    }

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'at_cat';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return AtCat[]
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return AtCat
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }

}
