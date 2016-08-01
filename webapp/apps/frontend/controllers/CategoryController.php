<?php
/**
 * Created by PhpStorm.
 * User: ViviPro
 * Date: 7/29/2016
 * Time: 10:09 PM
 */

namespace Webapp\Frontend\Controllers;


use Webapp\Frontend\Models\Category;

class CategoryController extends ControllerBase
{
    public function indexAction(){
        $id = $this->dispatcher->getParam("id","int");
        $category = Category::findFirst($id);
        $htmlx = "";
        $htmlx = $this->render_template("category/template",$category->type,$category);
        $this->view->htmlx = $htmlx;
        /** Header */
        $this->view->header = array(
            "title"=>$category->name,
            "desc"=>$category->descriptions,
            "keyword"=>$category->descriptions,
            "canonial"=>str_replace('http:/','http://',str_replace("//","/",$this->config->application->baseUrl.$category->getlink())),
            "image"=>$this->view->coverphoto
        );
    }
}