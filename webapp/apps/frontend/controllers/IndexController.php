<?php

namespace Webapp\Frontend\Controllers;

use Webapp\Frontend\Models\CategoryView;

class IndexController extends ControllerBase
{

    public function indexAction()
    {
        $listcategory = CategoryView::find(array(
            "conditions"=>"poskey='menublockhome'",
            "order"=>"sorts asc"
        ));
        $htmlx ="";
        foreach($listcategory as $categoryview){
            $category = $categoryview->Category;
            $htmlx .= $this->swithCategoryView($category);
        }
        $this->view->htmlx = $htmlx;
        /** Header */
        $this->view->header = array(
            "title"=>"Thanglong Av",
            "desc"=>"Thanglong Av",
            "keyword"=>"Thanglong Av",
            "canonial"=>$this->config->application->baseUrl,
            "image"=>$this->config->media->host.'uploads/default-image/fb-thumb.jpg'
        );
    }
    private function swithCategoryView($category){
        return $this->render_template("index/template",$category->type,$category);
    }
}

