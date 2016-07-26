<?php
namespace Webapp\Backend\Controllers;
class teacherController extends ControllerBase
{
    public function initialize()
    {
        $this->modulename = "teacher";
        $this->view->activesidebar = "/teacher/index";
        parent::initialize();
    }

    public function indexAction()
    {
        if (!$this->checkpermission("teacher_view")) return false;
        $limit = 20;
        $p = $this->request->get("p");
        if ($p <= 1) $p = 1;
        $cp = ($p - 1) * $limit;

        $q = $this->request->getQuery("q", "string");
        $query = "flags = 'teacher'";
        if (!empty($q)) $query .= " and (username LIKE '%" . $q . "%' OR firstname LIKE '%" . $q . "%' OR lastname LIKE '%" . $q . "%')";

        $listdata = User::find(array(
            "conditions" => $query,
            "order" => "id asc",
            "limit" => $limit,
            "offset" => $cp
        ));

        $this->view->q = $q;
        $this->view->listdata = $listdata;
        $this->view->painginfo = Helper::paginginfo(User::count($query), $limit, $p);
    }

    public function formAction()
    {
        $id = $this->request->get("id");
        if(!empty($id)){
            if (!$this->checkpermission("teacher_update")) return false;
        }
        else {
            if (!$this->checkpermission("teacher_add")) return false;
        }
        if ($this->request->isPost()) {
            try {
                $datapost = Helper::post_to_array("username,password,email,firstname,lastname,dob,address,phone,gender,captions");
                // <editor-fold desc="Validate">
                if (strlen($datapost['password']) > 0) $datapost['password'] = Helper::encryptpassword($datapost['password']);
                else unset($datapost['password']);

                $avatar = $this->post_file_key("avatar");
                if ($avatar != null) $datapost['avatar'] = $avatar;

                $datapost['dob'] = strtotime($datapost['dob']);
                $datapost['flags'] = "teacher";
                if ($id > 0) { // Update
                    $o = User::findFirst($id);
                    if ($o->username == $datapost['username']) unset($datapost['username']);
                } else { //insert
                    $o = new User();
                    $datapost['usercreate'] = $this->userinfo['id'];
                    $datapost['datecreate'] = time();
                }

                $o->map_object($datapost);
                // </editor-fold>
                $o->save();
                $this->flash->success("Information saved !");
            } catch (Exception $e) {
                if((int)$e->getCode()==23000) $this->flash->error($this->culture['general.lbl_duplicateuser']);
                else $this->flash->error($e->getMessage());
            }

        }
        if (!empty($id)) $o = User::findFirst($id);
        $o->birthday = date('d-m-Y', $o->dob);
        $this->view->object = $o;
        $this->view->backurl = strlen($this->request->getHTTPReferer())<=0? $this->view->activesidebar: $this->request->getHTTPReferer();
    }

    public function deleteAction()
    {
        if (!$this->checkpermission("teacher_delete")) return false;
        $id = $this->request->get("id");
        $o = User::findFirst($id);
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