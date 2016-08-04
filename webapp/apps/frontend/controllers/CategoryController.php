<?php
/**
 * Created by PhpStorm.
 * User: ViviPro
 * Date: 7/29/2016
 * Time: 10:09 PM
 */

namespace Webapp\Frontend\Controllers;


use Webapp\Frontend\Models\Article;
use Webapp\Frontend\Models\AtCat;
use Webapp\Frontend\Models\Category;
use Webapp\Frontend\Utility\Helper;

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
                    ->where('Webapp\Frontend\Models\AtCat.catid = :catid: and  Webapp\Frontend\Models\Article.status = 1', array('catid' => $child['id']))
                    ->orderBy('Webapp\Frontend\Models\Article.datecreate DESC')
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
    public function detailAction($id){
        $limit = 9;
        $p = $this->request->get("p","int");
        if ($p <= 1) $p = 1;
        $cp = ($p - 1) * $limit;

        $category = Category::findFirst($id);
        $category = $category->toArray();
        $article = Article::query()
            ->leftJoin('Webapp\Frontend\Models\AtCat', 'Webapp\Frontend\Models\AtCat.atid = Webapp\Frontend\Models\Article.id')
            ->where('Webapp\Frontend\Models\AtCat.catid = :catid: and  Webapp\Frontend\Models\Article.status = 1', array('catid' => $id))
            ->orderBy('Webapp\Frontend\Models\Article.datecreate DESC')
            ->limit($limit,$cp)
            ->execute();
        $count =  AtCat::count(array("conditions"=>"catid=:catid:","bind"=>array("catid"=>$id)));
        $htmlx = "";
        if($category['type']=="product"){
            $category['articles']= $article;
            $htmlx = $this->render_template("category/detail","product",$category);
            $this->view->painginfo = Helper::paginginfo($count, $limit, $p);
        }
        $this->view->htmlx = $htmlx;


    }
}