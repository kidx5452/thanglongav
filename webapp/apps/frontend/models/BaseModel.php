<?php
namespace Webapp\Frontend\Models;
/**
 * Created by PhpStorm.
 * User: SPCOM
 * Date: 3/28/2016
 * Time: 9:49 PM
 */
class BaseModel extends \Phalcon\Mvc\Model
{
    /***
     * HÃ m map array vÃ o object model cá»§a phalcon
     * @param $arr
     */
    public function map_object($arr){
        foreach($arr as $key=>$val) $this->{$key} = $val;
        return $this;
    }
}