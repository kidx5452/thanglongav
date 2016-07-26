<?php
namespace Webapp\Backend\Models;
/**
 * Created by PhpStorm.
 * User: SPCOM
 * Date: 3/16/2016
 * Time: 9:43 PM
 */
class BaseModel extends \Phalcon\Mvc\Model
{
    /***
     * Hàm map array vào object model của phalcon
     * @param $arr
     */
    public function map_object($arr){
        foreach($arr as $key=>$val) $this->{$key} = $val;
        return $this;
    }
}