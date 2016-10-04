<?php
namespace Webapp\Frontend\Models;
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
     * Initialize method for model.
     */
    public function initialize()
    {
        $this->belongsTo('atid', 'Webapp\Frontend\Models\Article', 'id', array('alias' => 'Article'));
    }
    public function slidemedia(){
        $url = $this->avatar;
        $parsed 	= parse_url($url);
        $hostname 	= $parsed['host'];  // www.youtube.com
        if(in_array($hostname,array("www.youtube.com","youtube.com","youto.be","youtu.be"))) {
            list($v,$id) = explode("=",$parsed['query']);
            return '<iframe width="100%" src="https://www.youtube.com/embed/'.$id.'" frameborder="0" allowfullscreen></iframe>';
        }
        else return '<img src="/'.$this->avatar.'" class="rsImg"/>';
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
