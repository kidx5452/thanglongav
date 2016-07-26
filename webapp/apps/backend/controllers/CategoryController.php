<?php
namespace Webapp\Backend\Controllers;
use Webapp\Backend\Locale\Culture;
use Webapp\Backend\Models\AtCat;
use Webapp\Backend\Models\Category;
use Webapp\Backend\Models\CategoryView;
use Webapp\Backend\Utility\Helper;

class CategoryController extends ControllerBase
{
    public function initialize()
    {
        global $config;
        $this->modulename = "category";
        $this->view->activesidebar = $config->application->baseUri."category/index";
        parent::initialize();
    }
    public function indexAction()
    {
        if (!$this->checkpermission("category_view")) return false;
        $langlist = Culture::lang();
        $this->view->langlist = $langlist;
        $l = $this->request->getQuery('lang', 'string') ? $this->request->getQuery('lang', 'string') : $langlist['vi_VN']['key'];
        $cattree = self::getMenu(0, $l);
        $this->view->cattree = $cattree;
    }

    public function getMenu($parentid, $lang)
    {
        $listdata = Category::find(array("conditions" => "parentid=$parentid AND lang='$lang'"));
        $listdata = $listdata->toArray();
        if (!$listdata) return null;
        $html = "<ul>";
        foreach ($listdata as $row) {
            $status = $row['status'] == 1 ? '' : '<span class="label label-danger">H</span>';
            switch($row['type']){
                default:
                    $typeStr = 'S';
                    $titleStr = 'Single Page Category';
                    break;
                case 'list':
                    $typeStr = 'L';
                    $titleStr = 'List Article Category';
                    break;
                case 'photo':
                    $typeStr = 'P';
                    $titleStr = 'Photo Category';
                    break;
                case 'video':
                    $typeStr = 'V';
                    $titleStr = 'Video Category';
                    break;
            }
            $type = '<span class="label label-success" title="'.$titleStr.'">'.$typeStr.'</span>';
            $layout = $row['layout'] == '2col' ? '<span class="label label-info" title="2 columns">2</span>' : '<span class="label label-info" title="3 columns">3</span>';
            $html .= "<li id='{$row['id']}'><a href=\"#\">{$row['name']} &nbsp;&nbsp; $type $layout $status</a>";
            $html .= self::getMenu($row['id'],$lang);
            $html .= "</li>";
        }
        $html .= "</ul>";
        return $html;
    }

    public function formAction()
    {
        $id = $this->request->get("id");
        if(!empty($id)){
            if (!$this->checkpermission("category_update")) return false;
        }
        else {
            if (!$this->checkpermission("category_add")) return false;
        }
        if ($this->request->isPost()) {
            try {
                $datapost = Helper::post_to_array("name,caption,descriptions,status,parentid,lang,type,layout,content,rightcolcontent,pintop_atid,left_atid,center_atid,right_atid,cover_video");
                if($datapost['pintop_atid']<=0) $datapost['pintop_atid'] = 0;
                if($datapost['left_atid']<=0) $datapost['left_atid'] = 0;
                if($datapost['center_atid']<=0) $datapost['center_atid'] = 0;
                if($datapost['right_atid']<=0) $datapost['right_atid'] = 0;
                $coverphoto = $this->post_file_key("coverphoto");
                if ($coverphoto != null) $datapost['coverphoto'] = $coverphoto;
                $avatar = $this->post_file_key("avatar");
                if ($avatar != null) $datapost['avatar'] = $avatar;

                if ($id > 0) { // Update
                    $o = Category::findFirst($id);
                    if ($o->name == $datapost['name']) unset($datapost['name']);
                } else { //insert
                    $o = new Category();
                    $o->id = time();
                    $datapost['usercreate'] = $this->userinfo['id'];
                    $datapost['datecreate'] = time();
                }

                if($datapost['type']=='list') $datapost['content'] = '';
                if($datapost['layout']=='2col') $datapost['rightcolcontent'] = '';

                $o->map_object($datapost);
                $o->save();
                $this->flash->success($this->view->labelkey['general.lbl_process_success']);
                if($_POST['backurl']) header('Location: ' . $_POST['backurl']);
            } catch (\Exception $e) {
                $this->flash->error($e->getMessage());
            }
        }
        if (!empty($id)) $o = Category::findFirst($id);
        $this->view->object = $o;
        $listdata = Category::find();
        $this->view->listdata = $listdata;
        $this->view->langlist = Culture::lang();
        $this->view->backurl = strlen($this->request->getHTTPReferer())<=0? $this->view->activesidebar: $this->request->getHTTPReferer();
    }

    public function deleteAction()
    {
        $id = $this->request->get("id");
        if (!$this->checkpermission("category_delete")) return false;

        // Delete article cat
        $at = AtCat::find("catid=$id");
        if ($at) {
            try {
                $at->delete();
            } catch (Exception $e) {
                $this->flash->error($e->getMessage());
            }
        }

        // Delete category view
        $cv = CategoryView::find("catid=$id");
        if ($cv) {
            try {
                $cv->delete();
            } catch (\Exception $e) {
                $this->flash->error($e->getMessage());
            }
        }

        $o = Category::findFirst($id);
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

    public function getcategorybynameAction()
    {
        if (!$this->checkpermission("category_view")) return;
        $this->view->setRenderLevel(\Phalcon\Mvc\View::LEVEL_NO_RENDER);
        header("Content-Type:application/json;charset=utf-8");
        $q = $this->request->getQuery("q", "string");
        $query = $q ? "parentid = 0 AND name LIKE '%" . $q . "%'" : '';
        $listdata = Category::find(array(
            "conditions" => $query,
            "order" => "id asc",
            "limit" => 100
        ));
        echo json_encode($listdata->toArray());
        return;
    }

    public function getajaxmenuAction()
    {
        if (!$this->checkpermission("category_view")) return;
        $this->view->setRenderLevel(\Phalcon\Mvc\View::LEVEL_NO_RENDER);
        header("Content-Type:application/json;charset=utf-8");
        $lang = $this->request->getPost("lang", "string");
        $atid = $this->request->getPost("atid");
        $selectedArr = array();
        if($atid>0){
            $selectedCat = AtCat::find(array('conditions'=>"atid=$atid",'columns'=>'catid'));
            $selectedCat = $selectedCat->toArray();
            $selectedArr = array();
            foreach($selectedCat as $sCat) array_push($selectedArr,$sCat['catid']);
        }
        $menudata = self::getAjaxCat(0, $lang, $selectedArr);
        echo json_encode($menudata);
        return;
    }

    public function getAjaxCat($parentid, $lang, $selectedArr)
    {
        if (!$this->checkpermission("category_view")) return;
        $listdata = Category::find(array("conditions" => "parentid=$parentid AND lang='$lang'"));
        $listdata = $listdata->toArray();
        if (!$listdata) return null;
        $html = "<ul>";
        foreach ($listdata as $row) {
            $checked = in_array($row['id'],$selectedArr) ? 'checked' : '';
            $html .= "<li id='{$row['id']}'><label><input {$checked} type='checkbox' value='{$row['id']}' name='category[]' /> {$row['name']}</label>";
            $html .= self::getAjaxCat($row['id'],$lang,$selectedArr);
            $html .= "</li>";
        }
        $html .= "</ul>";
        return $html;
    }

}