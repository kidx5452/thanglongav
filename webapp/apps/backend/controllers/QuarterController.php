<?php
namespace Webapp\Backend\Controllers;
/**
 * Created by PhpStorm.
 * User: VietNH
 * Date: 5/19/2016
 * Time: 3:22 PM
 */
class QuarterController extends ControllerBase
{
    public function indexAction(){
        $limit = 40;
        $p = $this->request->get("p");
        if ($p <= 1) $p = 1;
        $cp = ($p - 1) * $limit;

        $userid = $this->request->get("userid");
        $q = $this->request->getQuery("q", "string");

        $query = "userid=$userid";
        $query .= $q ? " and name LIKE '%" . $q . "%'" : '';
        if(isset($status) && $status < 3) $query .= " and status=$status";

        $listdata = RpQuarter::find(array(
                "conditions" => $query,
                "order" => "id desc",
                "limit" => $limit,
                "offset" => $cp
        ));

        $this->view->q = $q;
        $this->view->userinfo = User::findFirst(array('conditions' => "id=$userid"));
        $this->view->listdata = $listdata;
        $this->view->painginfo = Helper::paginginfo(RpQuarter::count($query), $limit, $p);
        $this->view->backurl = strlen($this->request->getHTTPReferer())<=0? $this->view->activesidebar: $this->request->getHTTPReferer();
    }
    public function formAction()
    {
        $id = $this->request->get("id");
        $userid = $this->request->get("userid");

        $back = $this->request->get("back");
        if ($this->request->isPost()) {
            try {
                $datapost = Helper::post_to_array("name");
                if ($id > 0) { // Update
                    $o = RpQuarter::findFirst($id);
                } else { //insert
                    $o = new RpQuarter();
                    $o->id = time();
                    $o->userid = $userid;
                    $o->status = 1;
                    $datapost['usercreate'] = $this->userinfo['id'];
                    $datapost['datecreate'] = time();
                }
                $o->map_object($datapost);
                $o->save();
                $this->flash->success($this->view->labelkey['general.lbl_process_success']);
                if($back==1) $this->response->redirect("classobj/editquarterreport?id=$userid");
                else $this->response->redirect("quarter/index?userid=$userid");
            } catch (Exception $e) {
                $this->flash->error($e->getMessage());
            }
        }
        $o = new RpQuarter();
        if (!empty($id)) {
            $o = RpQuarter::findFirst($id);
            $userid = $o->userid;
        }
        $this->view->object = $o;
        $this->view->userid = $userid;
    }
    public function deleteAction(){
        $id = $this->request->get("id");
        $uid = $this->request->get("userid");
        try {
            RpSkilltest::find(array("conditions"=>"quarterid = $id"))->delete();
            RpOraltest::find(array("conditions"=>"quarterid = $id"))->delete();
            RpPresentation::find(array("conditions"=>"quarterid = $id"))->delete();
            RpMinitest::find(array("conditions"=>"quarterid = $id"))->delete();
            RpAttitude::find(array("conditions"=>"quarterid = $id"))->delete();
            $c = RpQuarter::findFirst($id);
            $c->delete();
            $this->flash->success($this->view->labelkey['general.lbl_process_success']);
            $this->response->redirect("quarter/index?userid=$uid");
        } catch (Exception $e) {
            $this->flash->error($e->getMessage());
        }

    }
}