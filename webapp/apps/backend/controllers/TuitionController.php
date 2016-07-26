<?php
namespace Webapp\Backend\Controllers;
class TuitionController extends ControllerBase
{
    public function initialize()
    {
        $this->modulename = "tuition";
        $this->view->activesidebar = "/pupil/index";
        parent::initialize();
    }

    public function indexAction()
    {
        if (!$this->checkpermission("tuition_view")) return false;
        $uid = $this->request->getQuery("uid","string");
        $userobj = (array)User::findFirst($uid);
        $this->view->user = $userobj;
        $limit = 20;
        $p = $this->request->get("p");
        if ($p <= 1) $p = 1;
        $cp = ($p - 1) * $limit;

        $query = "userid=$uid";

        $listdata = Tuition::find(array(
            "conditions" => $query,
            "order" => "datecreate desc",
            "limit" => $limit,
            "offset" => $cp
        ));

        $this->view->listdata = $listdata;
        $this->view->painginfo = Helper::paginginfo(Tuition::count($query), $limit, $p);
    }

    public function formAction()
    {
        $id = $this->request->get("id");
        if(!empty($id)){
            if (!$this->checkpermission("tuition_update")) return false;
        }
        else {
            if (!$this->checkpermission("tuition_add")) return false;
        }
        if ($this->request->isPost()) {
            try {
                $datapost = Helper::post_to_array("name,price,status,expired_date,start_date,captions");
                $datapost['expired_date'] = strtotime($datapost['expired_date']);
                $datapost['start_date'] = strtotime($datapost['start_date']);
                $datapost['userid'] = $this->request->getQuery("uid","string");
                // <editor-fold desc="Validate">
                if ($id > 0) { // Update
                    $o = Tuition::findFirst($id);
                } else { //insert
                    $o = new Tuition();
                    $datapost['usercreate'] = $this->userinfo['id'];
                    $datapost['datecreate'] = time();
                    $datapost['viewed'] = 0;
                }

                $o->map_object($datapost);
                // </editor-fold>
                $o->save();
                $this->flash->success("Information saved !");
            } catch (Exception $e) {
                $this->flash->error($e->getMessage());
            }

        }
        if (!empty($id)) $o = Tuition::findFirst($id);
        $o->expired_date = date('d-m-Y', $o->expired_date);
        $o->start_date = date('d-m-Y', $o->start_date);
        $this->view->object = $o;
        $this->view->backurl = strlen($this->request->getHTTPReferer())<=0? $this->view->activesidebar: $this->request->getHTTPReferer();
    }

    public function deleteAction()
    {
        if (!$this->checkpermission("tuition_delete")) return false;
        $id = $this->request->get("id");
        $uid = $this->request->get("uid");
        $o = Tuition::findFirst($id);
        if ($o) {
            try {
                $o->delete();
                $this->flash->success("Delete Successfully !");
            } catch (Exception $e) {
                $this->flash->error($e->getMessage());
            }
        }
        if(!empty($uid)) $this->response->redirect("tuition/index?uid=$uid");
    }



}