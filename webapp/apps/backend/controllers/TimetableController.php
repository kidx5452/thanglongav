<?php
namespace Webapp\Backend\Controllers;
class TimetableController extends ControllerBase
{
    public function initialize()
    {
        $this->modulename = "timetable";
        $cid = $this->request->getQuery("cid","string");
        $uid = $this->request->getQuery("uid","string");
        if(!empty($cid)) {
            $this->view->activesidebar = "/classobj/index";
        }
        else if(!empty($uid)) {
            $this->view->activesidebar = "/pupil/index";
        }

        parent::initialize();
    }

    public function indexAction()
    {
        if (!$this->checkpermission("timetable_view")) return false;
        $cid = $this->request->getQuery("cid","string");
        $uid = $this->request->getQuery("uid","string");
        if(!empty($cid)) {
            $this->view->type = "cid";
            $this->view->id = $cid;
            $obj = (array)Classobj::findFirst($cid);
        }
        else if(!empty($uid)) {
            $this->view->type = "uid";
            $this->view->id = $uid;
            $obj = (array)User::findFirst($cid);
            $obj['name'] = $obj['firstname']." ".$obj['lastname'];
        }
        $this->view->obj = $obj;
        $limit = 20;
        $p = $this->request->get("p");
        if ($p <= 1) $p = 1;
        $cp = ($p - 1) * $limit;
        $query = "1=1";
        if(!empty($cid)) $query .=" and classid = $cid";
        else if(!empty($uid)) $query .=" and userid = $uid";
        $listdata = Timetable::find(array(
            "conditions" => $query,
            "order" => "datecreate desc",
            "limit" => $limit,
            "offset" => $cp
        ));
        $this->view->listdata = $listdata;
        $this->view->painginfo = Helper::paginginfo(Timetable::count($query), $limit, $p);
        $this->view->backurl = strlen($this->request->getHTTPReferer())<=0? $this->view->activesidebar: $this->request->getHTTPReferer();
    }

    public function formAction()
    {
        $id = $this->request->get("id");
        if(!empty($id)){
            if (!$this->checkpermission("timetable_update")) return false;
        }
        else {
            if (!$this->checkpermission("timetable_add")) return false;
        }
        $cid = $this->request->get("cid");
        $uid = $this->request->get("uid");
        if ($this->request->isPost()) {
            try {
                $datapost = Helper::post_to_array("name,content,status");
                if(!empty($cid)) $datapost['classid'] = $cid;
                else if(!empty($uid)) $datapost['userid'] = $uid;
                // <editor-fold desc="Validate">
                if ($id > 0) { // Update
                    $o = Timetable::findFirst($id);
                } else { //insert
                    $o = new Timetable();
                    $datapost['usercreate'] = $this->userinfo['id'];
                    $datapost['datecreate'] = time();
                }

                $o->map_object($datapost);
                // </editor-fold>
                $o->save();
                $this->flash->success("Information saved !");
            } catch (Exception $e) {
                $this->flash->error($e->getMessage());
            }

        }
        if (!empty($id)) $o = Timetable::findFirst($id);
        $this->view->object = $o;
        $this->view->backurl = strlen($this->request->getHTTPReferer())<=0? $this->view->activesidebar: $this->request->getHTTPReferer();
    }

    public function deleteAction()
    {
        if (!$this->checkpermission("timetable_delete")) return false;
        $id = $this->request->get("id");
        $uid = $this->request->get("uid");
        $cid = $this->request->get("cid");
        $o = Timetable::findFirst($id);
        if ($o) {
            try {
                $o->delete();
                $this->flash->success("Delete Successfully !");
            } catch (Exception $e) {
                $this->flash->error($e->getMessage());
            }
        }
        if(!empty($uid)) $this->response->redirect("timetable/index?uid=$uid");
        else if(!empty($cid)) $this->response->redirect("timetable/index?cid=$cid");
    }



}