<?php
namespace Webapp\Backend\Controllers;
class NotifypupilController extends ControllerBase
{
    public function initialize()
    {
        $this->modulename = "notifypupil";
        $this->view->activesidebar = "/pupil/index";
        parent::initialize();
    }

    public function indexAction()
    {
        if (!$this->checkpermission("pupil_notify")) return false;
        $limit = 20;
        $p = $this->request->get("p");
        if ($p <= 1) $p = 1;
        $cp = ($p - 1) * $limit;

        $id = $this->request->get("id");
        $q = $this->request->getQuery("q", "string");
        $lang = $this->request->getQuery('lang', 'string');
        $status = $this->request->getQuery('status','int');

        $query = "userid=$id";
        $query .= $q ? " and name LIKE '%" . $q . "%'" : '';
        if(isset($status) && $status < 3) $query .= " and status=$status";

        $listdata = NotifyPupil::find(array(
            "conditions" => $query,
            "order" => "id desc",
            "limit" => $limit,
            "offset" => $cp
        ));

        $this->view->langlist = Language::lang();
        $this->view->q = $q;
        $this->view->userinfo = User::findFirst(array('conditions' => "id=$id"));
        $this->view->listdata = $listdata;
        $this->view->painginfo = Helper::paginginfo(NotifyPupil::count($query), $limit, $p);
        $this->view->backurl = strlen($this->request->getHTTPReferer())<=0? $this->view->activesidebar: $this->request->getHTTPReferer();
    }

    public function formAction()
    {
        if (!$this->checkpermission("pupil_notify")) return false;
        $id = $this->request->get("id");
        $userid = $this->request->get("userid");

        if ($this->request->isPost()) {
            try {
                $datapost = Helper::post_to_array("name,status,content,skilltest_comment,oraltest_comment,presentation_comment,attitude_comment");
                if ($id > 0) { // Update
                    $o = NotifyPupil::findFirst($id);
                } else { //insert
                    $o = new NotifyPupil();
                    $o->id = time();
                    $datapost['datecreate'] = time();
                    $datapost['usercreate'] = $this->userinfo['id'];
                    $datapost['userid'] = $userid;
                    $datapost['lang'] = 'en_EN';
                }
                $o->map_object($datapost);
                $o->save();
                $this->flash->success($this->view->labelkey['general.lbl_process_success']);
                if($_POST['backurl']) header('Location: ' . $_POST['backurl']);
            } catch (Exception $e) {
                $this->flash->error($e->getMessage());
            }
        }
        if (!empty($id)) $o = NotifyPupil::findFirst($id);
        $this->view->object = $o;
        $this->view->userinfo = User::findFirst(array('conditions' => "id=$userid"));
        $this->view->langlist = Language::lang();
        if($this->request->get("back")==1) $this->view->backurl = $_SERVER['HTTP_REFERER'];
        //$this->view->backurl = strlen($this->request->getHTTPReferer())<=0? $this->view->activesidebar: $this->request->getHTTPReferer();
    }

    public function deleteAction()
    {
        if (!$this->checkpermission("pupil_notify")) return false;
        $id = $this->request->get("id");
        $o = NotifyPupil::findFirst($id);
        $o->status=3;
        $o->save();
        $this->response->redirect($this->request->getHTTPReferer());
    }


}
?>