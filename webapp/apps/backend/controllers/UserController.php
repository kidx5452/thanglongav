<?php
namespace Webapp\Backend\Controllers;
use Webapp\Backend\Models\Rolegroup;
use Webapp\Backend\Models\User;
use Webapp\Backend\Models\UserRole;
use Webapp\Backend\Utility\Helper;

class UserController extends ControllerBase
{
    public function initialize()
    {
        global $config;
        $this->modulename = "user";
        $this->view->activesidebar = $config->application->baseUri."user/index";
        parent::initialize();
    }

    public function indexAction()
    {
        if (!$this->checkpermission("user_view")) return false;
        $limit = 20;
        $p = $this->request->get("p");
        if ($p <= 1) $p = 1;
        $cp = ($p - 1) * $limit;

        $q = $this->request->getQuery("q", "string");
        $query = "flags = 'system'";
        if (!empty($q)) $query .= " and (username LIKE '%" . $q . "%' OR firstname LIKE '%" . $q . "%' OR lastname LIKE '%" . $q . "%')";
        $listdata = User::find(array(
            "conditions" => $query,
            "order" => "id DESC",
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
            if (!$this->checkpermission("user_update")) return false;
        }
        else {
            if (!$this->checkpermission("user_add")) return false;
        }
        if ($this->request->isPost()) {
            try {
                $datapost = Helper::post_to_array("username,password,email,firstname,lastname,dob,address,phone,gender");
                // <editor-fold desc="Validate">
                if (strlen($datapost['password']) > 0) $datapost['password'] = Helper::encryptpassword($datapost['password']);
                else unset($datapost['password']);

                $avatar = $this->post_file_key("avatar");
                if ($avatar != null) $datapost['avatar'] = $avatar;

                $datapost['dob'] = strtotime($datapost['dob']);
                $datapost['flags'] = "system";
                if ($id > 0) { // Update
                    $o = User::findFirst($id);
                    if ($o->username == $datapost['username']) unset($datapost['username']);
                } else { //insert
                    $o = new User();
                    $datapost['datecreate'] = time();
                }

                $o->map_object($datapost);
                // </editor-fold>
                $o->save();
                $this->flash->success("Information saved !");
            } catch (\Exception $e) {
                if((int)$e->getCode()==23000) $this->flash->error($this->culture['general.lbl_duplicateuser']);
                else $this->flash->error($e->getMessage());
            }

        }
        if (!empty($id)) $o = User::findFirst($id);
        $o->birthday = date('d-m-Y', $o->dob);
        $this->view->object = $o;
        $this->view->backurl = strlen($this->request->getHTTPReferer())<=0? $this->view->activesidebar: $this->request->getHTTPReferer();
    }

    public function roleAction()
    {
        if (!$this->checkpermission("user_role")) return false;
        $id = Helper::xss_clean($this->request->get("id"));
        if ($this->request->isPost()) {
            try {
                $query = "userid=$id";
                $o = UserRole::find(array("conditions" => $query));
                if ($o) $o->delete();
                $datapost = Helper::post_to_array("role");
                foreach ($datapost['role'] as $item) {
                    $urole = new UserRole();
                    $urole->userid = $id;
                    $urole->roleid = $item;
                    $urole->save();
                }
                $this->flash->success("Save Successfully !");
            } catch (\Exception $e) {
                $this->flash->error($e->getMessage());
            }
        }
        $listrole_actived = UserRole::find(array("conditions" => "userid = $id"))->toArray();
        $listrole_actived = array_column($listrole_actived, "roleid");
        $this->view->listrole_actived = $listrole_actived;
        $listrole = Rolegroup::find();
        $this->view->listrole = $listrole;
        $userinfo = User::findFirst(array('conditions' => "id=$id"));
        $this->view->userinfo = $userinfo;
        $this->view->backurl = strlen($this->request->getHTTPReferer())<=0? $this->view->activesidebar: $this->request->getHTTPReferer();
    }

    public function deleteAction()
    {
        if (!$this->checkpermission("user_delete")) return false;
        $id = $this->request->get("id");

        // Delete in User Role
        $ur = UserRole::find("userid=$id");
        if ($ur) {
            try {
                $ur->delete();
            } catch (\Exception $e) {
                $this->flash->error($e->getMessage());
            }
        }

        $o = User::findFirst($id);
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

    public function getbynameAction()
    {
        if (!$this->checkpermission("user_view")) return;
        $this->view->setRenderLevel(\Phalcon\Mvc\View::LEVEL_NO_RENDER);
        header("Content-Type:application/json;charset=utf-8");
        $q = $this->request->getQuery("q", "string");
        $query = $q ? "username LIKE '%" . $q . "%'" : '';
        $listdata = User::find(array(
                "columns"=>"id,username as name",
                "conditions" => $query,
                "order" => "id asc",
                "limit" => 100
        ));
        echo json_encode($listdata->toArray());
        return;
    }

}