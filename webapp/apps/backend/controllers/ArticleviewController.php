<?php
namespace Webapp\Backend\Controllers;

use Webapp\Backend\Locale\Culture;
use Webapp\Backend\Models\Article;
use Webapp\Backend\Models\ArticleView;
use Webapp\Backend\Utility\Helper;

class ArticleviewController extends ControllerBase
{
    public function initialize()
    {
        global $config;
        $this->modulename = "articleview";
        $this->view->activesidebar = $config->application->baseUri . "articleview/index";
        parent::initialize();
    }

    public function indexAction()
    {
        if (!$this->checkpermission("articleview_view")) return false;
        $lang = $this->langkey;
        $catid = $this->request->get("catid");
        $query = "1=1";
        if (!empty($catid)) $query .=" and catid = $catid" ;
        $listdata = ArticleView::find(
            array(
                'conditions' => $query,
                'order' => 'poskey DESC, sorts ASC'
            )
        );
        $this->view->listdata = $listdata;
        $this->view->catid= $catid;
    }

    public function formAction()
    {
        $this->view->articlepos = Article::position();
        $this->view->langlist = Culture::lang();
        $catid = $this->request->get("catid");
        $q = $this->request->getQuery("pos", "string") ? $this->request->getQuery("pos", "string") : $this->articlepos[0]['key'];
        $l = $this->request->getQuery('lang', 'string') ? $this->request->getQuery('lang', 'string') : Culture::lang(0)['key'];
        $id = $this->request->getQuery('id', 'string');
        if (!empty($id)) {
            if (!$this->checkpermission("articleview_update")) return false;
        } else {
            if (!$this->checkpermission("articleview_add")) return false;
        }
        if ($this->request->isPost()) {
            try {
                $datapost = Helper::post_to_array("lang,poskey,atid,sorts,captions,url,linkyoutube");
                if(!empty($catid)) $datapost['catid'] =$catid;
                $avatar = $this->post_file_key("avatar");
                if ($avatar != null) $datapost['avatar'] = $avatar;
                // <editor-fold desc="Validate">
                if ($id > 0) { // Update
                    $o = ArticleView::findFirst($id);
                } else { //insert
                    $o = new ArticleView();
                }
                $o->map_object($datapost);
                // </editor-fold>
                $o->save();
                $this->flash->success("Information saved !");
            } catch (\Exception $e) {
                $this->flash->error($e->getMessage());
            }
            $this->response->redirect($this->request->getHTTPReferer());
        }
        if ($id > 0) {
            $o = ArticleView::findFirst($id);
            $o->name = $o->Article->name;
            $this->view->object = $o;
        }
        $this->view->backurl = strlen($this->request->getHTTPReferer()) <= 0 ? $this->view->activesidebar : $this->request->getHTTPReferer();
        $this->view->catid= $catid;
    }

    public function deleteAction()
    {
        if (!$this->checkpermission("articleview_delete")) return false;
        $id = $this->request->get("id");
        $o = ArticleView::findFirst($id);
        if ($o) {
            try {
                $o->delete();
                $this->flash->success("Delete Successfully !");
            } catch (\Exception $e) {
                $this->flash->error($e->getMessage());
            }
        }
        $this->response->redirect($this->request->getHTTPReferer());
    }

}