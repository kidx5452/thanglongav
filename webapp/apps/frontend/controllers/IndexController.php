<?php

namespace Webapp\Frontend\Controllers;

use Webapp\Frontend\Utility\Helper;
use Webapp\Frontend\Models\CategoryView;
use Webapp\Frontend\Models\Contact;

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

    public function contactAction(){
        if($this->request->isPost()){
            try {
                $datapost = Helper::post_to_array("name,phone,email,contents");
                $datapost['status'] = 1;
                $datapost['create_at'] = time();
                $contact = new Contact();
                $contact->map_object($datapost);
                $contact->save();
                $this->flash->success("Thông tin của bạn đã được gửi thành công");
            } catch (Exception $e) {
                print_r($e);die;
                $this->flash->success("Thông tin của bạn đã được gửi thành công");
            }
        }

        /** Header */
        $this->view->header = array(
            "title"=>"Liên hệ - Thăng Long AV",
            "desc"=>"Liên hệ - Thăng Long AV",
            "keyword"=>"Liên hệ - Thăng Long AV",
            "canonial"=>$this->config->application->baseUrl."index/contact",
            "image"=>$this->config->media->host.'uploads/default-image/fb-thumb.jpg'
        );
    }
}

