<?php
namespace Webapp\Backend\Models;
class ArticleView extends BaseModel
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
    public $atid;

    /**
     *
     * @var string
     */
    public $avatar;

    /**
     *
     * @var integer
     */
    public $sorts;

    /**
     *
     * @var integer
     */
    public $captions;

    /**
     *
     * @var String
     */
    public $url;

    /**
     *
     * @var String
     */
    public $catid;

    /**
     *
     * @var String
     */
    public $linkyoutube;
    /**
     * Initialize method for model.
     */
    public function initialize()
    {
        $this->belongsTo('atid', '\Webapp\Backend\Models\Article', 'id', array('alias' => 'Article'));
    }

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'article_view';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return ArticleView[]
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return ArticleView
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }

}
