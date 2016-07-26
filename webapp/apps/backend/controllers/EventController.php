<?php
namespace Webapp\Backend\Controllers;
class EventController extends ControllerBase
{
    public function initialize()
    {
        $this->modulename = "event";
        $cid = $this->request->getQuery("cid","string");
        $uid = $this->request->getQuery("uid","string");
        /*
        if(!empty($cid)) {
            $this->view->activesidebar = "/classobj/index";
        }
        else if(!empty($uid)) {
            $this->view->activesidebar = "/pupil/index";
        }
        */
        $this->view->activesidebar = "/event/index";

        parent::initialize();
    }

    public function indexAction()
    {
        if (!$this->checkpermission("event_view")) return false;
        $limit = 20;
        $p = $this->request->get("p");
        if ($p <= 1) $p = 1;
        $cp = ($p - 1) * $limit;

        $query = "1=1";
        $q = $this->request->getQuery("q", "string");
        $status = $this->request->get("status");
        $lang = $this->request->getQuery('lang', 'string');
        if ($q) $query .= " AND name LIKE '%" . $q . "%'";
        if (isset($status) && $status<2) $query .= " AND status = $status";
        if ($lang) $query .= " AND lang='$lang'";

        $listdata = Event::find(array(
            "conditions" => $query,
            "order" => "datecreate desc",
            "limit" => $limit,
            "offset" => $cp
        ));
        $this->view->listdata = $listdata;
        $this->view->langlist = Language::lang();
        $this->view->painginfo = Helper::paginginfo(Event::count($query), $limit, $p);
        $this->view->backurl = strlen($this->request->getHTTPReferer())<=0? $this->view->activesidebar: $this->request->getHTTPReferer();
    }

    public function formAction()
    {

        $id = $this->request->get("id");
        if(!empty($id)){
            if (!$this->checkpermission("event_update")) return false;
        }
        else {
            if (!$this->checkpermission("event_add")) return false;
        }
        $id = $this->request->get("id");
        if ($this->request->isPost()) {
            try {
                $datapost = Helper::post_to_array("name,captions,content,status,startdate,enddate,location,lang");
                $datapost['startdate'] = strtotime($datapost['startdate']);
                $datapost['enddate'] = strtotime($datapost['enddate']);

                $coverphoto = $this->post_file_key("coverphoto");
                if ($coverphoto != null) $datapost['coverphoto'] = $coverphoto;

                if(!empty($cid)) $datapost['classid'] = $cid;
                else if(!empty($uid)) $datapost['userid'] = $uid;
                // <editor-fold desc="Validate">
                if ($id > 0) { // Update
                    $o = Event::findFirst($id);
                } else { //insert
                    $o = new Event();
                    $datapost['usercreate'] = $this->userinfo['id'];
                    $datapost['datecreate'] = time();
                    $datapost['id'] = time();
                }
                $o->map_object($datapost);
                // </editor-fold>
                $o->save();

                if(!empty($id))  EventTag::find(
                    array(
                        "conditions" => "eventid = $id"
                    )
                )->delete();
                else $id = $datapost['id'];
                $ucpost = Helper::post_to_array("userid,classid");
                $ucpost['userid'] = array_values(array_unique($ucpost['userid']));
                $ucpost['classid'] = array_values(array_unique($ucpost['classid']));
                foreach($ucpost['userid'] as $item){
                    $etag =  new EventTag();
                    $etag->userid = $item;
                    $etag->eventid = $id;
                    $etag->classid = 0;
                    $etag->save();
                }
                foreach($ucpost['classid'] as $item){
                    $etag =  new EventTag();
                    $etag->classid = $item;
                    $etag->eventid = $id;
                    $etag->userid = 0;
                    $etag->save();
                }
                $this->flash->success("Information saved !");
            } catch (Exception $e) {
                $this->flash->error($e->getMessage());
            }

        }
        if (!empty($id)) {
            $o = Event::findFirst($id);
            $listtag = EventTag::find( array(
                "conditions" => "eventid = $id"
            ))->toArray();
            $listiduser = implode(",",array_column($listtag,"userid"));
            $listuser = $listiduser ? User::find(array("id in ($listiduser)")) : array();
            $listidclass = implode(",",array_column($listtag,"classid"));
            $listclass = $listidclass ? Classobj::find(array("id in ($listidclass)")) : array();
        }
        $o->startdate = date("Y-m-d H:i",$o->startdate);
        $o->enddate = date("Y-m-d H:i",$o->enddate);
        $this->view->object = $o;
        $this->view->tagclass = $listclass;
        $this->view->taguser = $listuser;
        $this->view->langlist = Language::lang();
        $this->view->backurl = strlen($this->request->getHTTPReferer())<=0? $this->view->activesidebar: $this->request->getHTTPReferer();
    }

    public function deleteAction()
    {
        if (!$this->checkpermission("event_delete")) return false;
        $id = $this->request->get("id");

        // Delete in Event Tag
        $et = EventTag::find("eventid=$id");
        if ($et) {
            try {
                $et->delete();
            } catch (Exception $e) {
                $this->flash->error($e->getMessage());
            }
        }

        $o = Event::findFirst($id);
        if ($o) {
            try {
                $o->delete();
                $this->flash->success("Delete Successfully !");
            } catch (Exception $e) {
                $this->flash->error($e->getMessage());
            }
        }
        $this->response->redirect($this->request->getHTTPReferer());
    }



}