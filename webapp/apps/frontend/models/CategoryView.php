<?php
namespace Webapp\Frontend\Models;
class CategoryView extends BaseModel
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
     * @var string
     */
    public $poskey;

    /**
     *
     * @var integer
     */
    public $sorts;

    /**
     *
     * @var string
     */
    public $lang;

    /**
     * Initialize method for model.
     */
    public function initialize()
    {
        $this->belongsTo('catid', 'Category', 'id', array('alias' => 'Category'));
    }

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'category_view';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return CategoryView[]
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return CategoryView
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }

}
