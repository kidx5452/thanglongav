<?php
namespace Webapp\Backend\Controllers;
use Webapp\Backend\Models\Rolegroup;
use Webapp\Backend\Utility\Helper;
use Webapp\Backend\Utility\Module;

class RolegroupController extends ControllerBase
{
    public function initialize()
    {
        global $config;
        $this->modulename = "rolegroup";
        $this->view->activesidebar = $config->application->baseUri."rolegroup/index";
        parent::initialize();
    }
    public function indexAction()
    {
        if (!$this->checkpermission("rolegroup_view")) return false;
        $limit = 20;
        $p = $this->request->get("p");
        if ($p <= 1) $p = 1;
        $cp = ($p - 1) * $limit;

        $query = "id > 0";
        $q = $this->request->getQuery("q", "string");
        if ($q) $query .= " AND name LIKE '%" . $q . "%'";
        $listdata = Rolegroup::find(
            array(
                "conditions" => $query,
                "order" => "level asc",
                "limit" => $limit,
                "offset" => $cp
            )
        );

        $this->view->q = $q;
        $this->view->listdata = $listdata;
        $this->view->painginfo = Helper::paginginfo(Rolegroup::count($query), $limit, $p);
    }

    public function formAction()
    {
        $id = $this->request->get("id");
        if(!empty($id)){
            if (!$this->checkpermission("rolegroup_update")) return false;
        }
        else {
            if (!$this->checkpermission("rolegroup_add")) return false;
        }
        $uinfo = (array)$this->session->get("uinfo");

        if ($this->request->isPost()) {
            try {
                $datapost = Helper::post_to_array("name,level,permissions");
                $datapost['permissions'] = implode(",", $datapost['permissions']);
                // <editor-fold desc="Validate">
                if ($id > 0) { // Update
                    $o = Rolegroup::findFirst($id);
                } else { //insert
                    $o = new Rolegroup();
                    $datapost['datecreate'] = time();
                    $datapost['usercreate'] = $uinfo['id'];
                }
                $o->map_object($datapost);
                // </editor-fold>
                $o->save();
                $this->flash->success("Information saved !");
            } catch (\Exception $e) {
                $this->flash->error($e->getMessage());
            }

        }
        if (!empty($id)) $o = Rolegroup::findFirst($id);
        $activepermission = $o->permissions;
        $this->view->object = $o;

        $activepermission = explode(",", $activepermission);
        $module = new Module();
        $listpermission = $module->Permission();
        //set active for rolegroup
        foreach ($listpermission as $key => $item) {
            if (in_array($key, $activepermission)) $listpermission[$key]['checked'] = 'checked';
            else $listpermission[$key]['checked'] = '';
            foreach ($item['child'] as $ckey => $val) {
                if (in_array($key . "_" . $val['key'], $activepermission)) $listpermission[$key]['child'][$ckey]['checked'] = "checked";
                else $listpermission[$key]['child'][$ckey]['checked'] = "";
            }
        }
        $this->view->module = $listpermission;
        $this->view->backurl = strlen($this->request->getHTTPReferer())<=0? $this->view->activesidebar: $this->request->getHTTPReferer();
    }
    public function deleteAction()
    {
        if (!$this->checkpermission("rolegroup_delete")) return false;
        $id = $this->request->get("id");
        $o = Rolegroup::findFirst($id);
        if ($o) {
            try {
                $o->delete();
                $this->flash->success($this->view->labelkey['general.lbl_process_success']);
            } catch (\Exception $e) {
                $this->flash->error($e->getMessage());
            }
        }
        $this->response->redirect($this->request->getHTTPReferer());
    }
}

