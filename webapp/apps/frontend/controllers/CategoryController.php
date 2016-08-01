<?php
/**
 * Created by PhpStorm.
 * User: ViviPro
 * Date: 7/29/2016
 * Time: 10:09 PM
 */

namespace Webapp\Frontend\Controllers;


use Webapp\Frontend\Models\Article;
use Webapp\Frontend\Models\Category;

class CategoryController extends ControllerBase
{
    public function indexAction(){
        $id = $this->dispatcher->getParam("id","int");
        $category = Category::findFirst($id);
        $categoyObject = $category;
        $category = $category->toArray();
        $htmlx = "";
        if($category['type']=="product"){
            $listchild = Category::find(array("conditions"=>"parentid=:parentid:","bind"=>array("parentid"=>$id)))->toArray();
            foreach($listchild as $key => $child){
                $listchild[$key]['listarticle'] = Article::query()
                    ->leftJoin('Webapp\Frontend\Models\AtCat', 'Webapp\Frontend\Models\AtCat.atid = Webapp\Frontend\Models\Article.id')
                    ->where('Webapp\Frontend\Models\AtCat.catid = :catid:', array('catid' => $child['id']))
                    ->orderBy('Webapp\Frontend\Models\Article.id DESC')
                    ->limit(3,0)
                    ->execute()->toArray();
            }
            $category['listchild'] = $listchild;
        }
        $htmlx = $this->render_template("category/template",$category['type'],$category);
        $this->view->htmlx = $htmlx;
        /** Header */
        $this->view->header = array(
            "title"=>$category['name'],
            "desc"=>$category['descriptions'],
            "keyword"=>$category['descriptions'],
            "canonial"=>str_replace('http:/','http://',str_replace("//","/",$this->config->application->baseUrl.$categoyObject->getlink())),
            "image"=>$this->view->coverphoto
        );
    }
}