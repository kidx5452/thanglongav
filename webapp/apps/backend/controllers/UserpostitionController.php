<?php
namespace Webapp\Backend\Controllers;
class UserpostitionController extends ControllerBase
{
    public function initialize()
    {
        $this->modulename = "userpostition";
        $this->view->activesidebar = "/userpostition/index";
        parent::initialize();
    }

    public function indexAction()
    {
        if (!$this->checkpermission("userpostition_view")) return false;
        $limit = 20;
        $p = $this->request->get("p");
        if ($p <= 1) $p = 1;
        $cp = ($p - 1) * $limit;

        $q = $this->request->getQuery("q", "string");
        $cid = $this->request->getQuery('cid');
        $query = "id > 0";
        if (!empty($q)) $query .= " AND name LIKE '%" . $q . "%'";
        $listdata = UserPosition::find(array(
            "conditions" => $query,
            "order" => "id asc",
            "limit" => $limit,
            "offset" => $cp
        ));

        $this->view->q = $q;
        $this->view->listdata = $listdata;
        $this->view->painginfo = Helper::paginginfo(UserPosition::count($query), $limit, $p);
    }

    public function formAction()
    {
        $id = $this->request->get("id");
        if (!empty($id)) {
            if (!$this->checkpermission("userpostition_update")) return false;
        } else {
            if (!$this->checkpermission("userpostition_add")) return false;
        }
        if ($this->request->isPost()) {
            try {
                $datapost = Helper::post_to_array("captions,name,sorts,contents");
                // <editor-fold desc="Validate">
                $is_action = true;
                if ($id > 0) { // Update
                    $o = UserPosition::findFirst($id);
                } else { //insert
                    $o = new UserPosition();
                }
                if ($is_action == true) $o->map_object($datapost);

                // </editor-fold>
                $o->save();
                $this->flash->success("Information saved !");
            } catch (Exception $e) {
                if((int)$e->getCode()==23000) $this->flash->error($this->culture['general.lbl_duplicateuser']);
                else $this->flash->error($e->getMessage());
            }

        }
        if (!empty($id)) $o = UserPosition::findFirst($id);
        $this->view->object = $o;
        $this->view->backurl = strlen($this->request->getHTTPReferer()) <= 0 ? $this->view->activesidebar : $this->request->getHTTPReferer();
    }

    public function deleteAction()
    {
        if (!$this->checkpermission("userpostition_delete")) return false;
        $id = $this->request->get("id");
        $o = UserPosition::findFirst($id);
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