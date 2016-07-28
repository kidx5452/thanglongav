<?php
namespace Webapp\Backend\Controllers;
use Webapp\Backend\Locale\Culture;
use Webapp\Backend\Models\AtCat;
use Webapp\Backend\Models\Category;
use Webapp\Backend\Models\CategoryView;
use Webapp\Backend\Models\Menu;
use Webapp\Backend\Utility\Helper;
use Webapp\Backend\Utility\Module;

class MenuController extends ControllerBase
{
    public function initialize()
    {
        global $config;
        $this->modulename = "menu";
        $this->view->activesidebar = $config->application->baseUri."menu/index";
        parent::initialize();
    }
    public function indexAction()
    {
        $cattree = self::getMenu(0);
        $this->view->cattree = $cattree;
    }


    public function getMenu($parentid)
    {
        $listdata = Menu::find(array("conditions" => "parentid=$parentid","order"=>'sorts asc'));
        $listdata = $listdata->toArray();
        if (!$listdata) return null;
        $html = "<ul>";
        foreach ($listdata as $row) {
            $html .= "<li id='{$row['id']}'><a class='text-danger' href=''>{$row['name']}</a>&nbsp;&nbsp;&nbsp;&nbsp;";
            $html .= "<a href='form?id={$row['id']}'>Sửa</a> | ";
            $html .= "<a href='delete?id={$row['id']}'>Xóa</a> | ";
            $html .= "<a href='form?parentid={$row['id']}'>Thêm con</a>";
            $html .= self::getMenu($row['id']);
            $html .= "</li>";
        }
        $html .= "</ul>";
        return $html;
    }

    public function formAction()
    {
        $id = $this->request->get("id");
        if(!empty($id)){
            if (!$this->checkpermission("menuview_update")) return false;
        }
        else {
            if (!$this->checkpermission("menuview_add")) return false;
        }
        if ($this->request->isPost()) {
            try {
                $datapost = Helper::post_to_array("name,type,objid,status,sorts");
                if ($id > 0) { // Update
                    $o = Menu::findFirst($id);
                    if ($o->name == $datapost['name']) unset($datapost['name']);
                } else { //insert
                    $parentid = $this->request->get("parentid");
                    if(empty($parentid)) $parentid = 0;
                    $datapost['parentid'] = $parentid;
                    $o = new Menu();
                    $o->id = time();
                }
                $o->map_object($datapost);
                $o->save();
                $this->flash->success($this->view->labelkey['general.lbl_process_success']);
                $this->response->redirect("menu/index");
                return;
            } catch (\Exception $e) {
                $this->flash->error($e->getMessage());
            }
        }
        if (!empty($id)) $o = Menu::findFirst($id);
        $this->view->object = $o;
        $listdata = Menu::find();
        $this->view->listdata = $listdata;
    }

    public function deleteAction()
    {
        $id = $this->request->get("id");
        if (!$this->checkpermission("menuview_delete")) return false;

        $o = Menu::findFirst($id);
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