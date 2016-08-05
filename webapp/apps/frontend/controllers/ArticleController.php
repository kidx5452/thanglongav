<?php
namespace Webapp\Frontend\Controllers;
use Webapp\Frontend\Models\Article;
use Webapp\Frontend\Models\AtCat;
class ArticleController extends ControllerBase
{

    public function initialize()
    {
        $this->modulename = "article";
        parent::initialize();
    }

    public function detailAction(){
        //if(!$this->ismobile) $this->view->setMainView("article");
        $id = $this->dispatcher->getParam("id") ? $this->dispatcher->getParam("id") : $this->request->get("id");
        $data = Article::findFirst($id);
        if(!$data) { $this->response->redirect("/error/e404"); return false; }

        $query = "atid={$data->id}";
        $listcat = AtCat::find(array('conditions' => $query));

        $query = $listcat->toArray() ? 'atid != '.$data->id.' AND catid = '.$listcat->toArray()[0]['catid'] : 0;
        $relatedpost = AtCat::find(
            array(
                'conditions' => $query,
                'order' => 'atid DESC',
                'limit' => 5
            )
        );
        $viewdata = new \stdClass();

        $viewdata->coverphoto = $data->coverphoto ? $data->coverphoto : $this->config->media->host.'uploads/default-image/article-cover.jpg';
        //$viewdata->listcat = $listcat;
        $viewdata->data = $data;
        $viewdata->relatedpost = $relatedpost;
        $this->view->htmlx = $this->render_template("article/detail","detail",$viewdata);
        /** Header */
        $this->view->header = array(
                "title"=>$data->name,
                "desc"=>$data->captions,
                "keyword"=>$data->captions,
                "canonial"=>str_replace('http:/','http://',str_replace("//","/",$this->config->application->baseUrl.$data->getlink())),
                "image"=>$this->config->media->host.$data->avatar
        );
    }

}