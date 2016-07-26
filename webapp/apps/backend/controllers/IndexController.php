<?php
namespace Webapp\Backend\Controllers;
use Webapp\Backend\Models\RpRequestLog;
use Webapp\Backend\Models\User;

class IndexController extends ControllerBase
{
    public function initialize()
    {
        $this->modulename = "home";
        $this->view->activesidebar = "/index/index";
        parent::initialize();
    }

    public function indexAction()
    {
        if($this->request->isPost()){
            $memcache_obj = new \Memcache;
            $memcache_obj->connect('127.0.0.1', 11211);
            $memcache_obj->flush();
        }

        // Delete expired log
        $deletetime = time()-($this->config->application->rpRequestLogLimit*86400);
        $rrl = RpRequestLog::find("datecreate<=$deletetime");
        if ($rrl) {
            try {
                $rrl->delete();
            } catch (\Exception $e) {
                $this->flash->error($e->getMessage());
            }
        }
    }

    public function changelanguageAction()
    {
        $lang = $this->request->getQuery("lang","string");
        $this->session->set("lang",$lang);
        $this->cookies->set('wsi_lang', $lang, time() + 30 * 86400);
        $r = $this->request->get("r");
        $r = urldecode($r);
        if(strlen($r)<=0) $r = "index/index";
        $this->response->redirect($r);
    }

    public function initnameAction(){
        $listuser = User::find();
        foreach($listuser as $u){
            $u->fullname_none_utf = Helper::khongdau($u->firstname." ".$u->lastname);
            $u->save();
        }
    }
}

