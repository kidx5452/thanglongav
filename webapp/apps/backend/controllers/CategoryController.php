<?php
    namespace Webapp\Backend\Controllers;

    use Webapp\Backend\Locale\Culture;
    use Webapp\Backend\Models\AtCat;
    use Webapp\Backend\Models\Category;
    use Webapp\Backend\Models\CategoryView;
    use Webapp\Backend\Utility\Helper;
    use Webapp\Backend\Utility\Module;

    class CategoryController extends ControllerBase {
        public function initialize() {
            global $config;
            $this->modulename = "category";
            $this->view->activesidebar = $config->application->baseUri . "category/index";
            parent::initialize();
        }

        public function indexAction() {
            if (!$this->checkpermission("category_view")) return false;
            $cattype = $this->request->get("cattype");
            if (empty($cattype)) $cattype = "news";
            $listcategory = Module::category_type();
            $this->view->listCategoryType = $listcategory;
            $cattree = self::getMenu(0, $cattype);
            $this->view->cattree = $cattree;
            $this->view->viewvar = ["cattype" => $cattype];
        }

        public function getMenu($parentid, $type) {
            $listdata = Category::find(["conditions" => "parentid=$parentid AND type='$type'"]);
            if (!$listdata) return null;
            $html = "<ul>";
            foreach ($listdata as $row) {
                $html .= "<li id='{$row->id}'><a class='text-danger' href=''>{$row->name}</a>&nbsp;&nbsp;&nbsp;&nbsp;";
                $html .= "<a href='form?cattype=$type&id={$row->id}'>Sửa</a> | ";
                $html .= "<a href='delete?id={$row->id}'>Xóa</a> | ";
                $html .= "<a href='form?cattype=$type&parentid={$row->id}'>Thêm con</a> | ";
                $html .= "<a href='{$row->getlink()}' target='_blank'>Xem trên client</a> | ";
                $html .= "<a href='{$row->get_article_link()}'>Xem bài viết</a> | ";
                $html .= "<a target='_blank' href='/backend/articleview/index?catid={$row->id}'>Cấu hình slideshow</a>";
                $html .= self::getMenu($row->id, $type);
                $html .= "</li>";
            }
            $html .= "</ul>";

            return $html;
        }

        public function formAction() {
            $id = $this->request->get("id");
            $cattype = $this->request->get("cattype");
            if (empty($cattype)) $cattype = "news";
            if (!empty($id)) {
                if (!$this->checkpermission("category_update")) return false;
            }
            else {
                if (!$this->checkpermission("category_add")) return false;
            }
            if ($this->request->isPost()) {
                try {
                    $datapost = Helper::post_to_array("name,caption,descriptions,status,lang,type,layout,content,rightcolcontent,view_type,pintop_atid,left_atid,center_atid,right_atid,cover_video");
                    $datapost['type'] = $cattype;
                    $coverphoto = $this->post_file_key("coverphoto");
                    if ($coverphoto != null) $datapost['coverphoto'] = $coverphoto;
                    $avatar = $this->post_file_key("avatar");
                    if ($avatar != null) $datapost['avatar'] = $avatar;
                    if ($id > 0) { // Update
                        $o = Category::findFirst($id);
                        if ($o->name == $datapost['name']) unset($datapost['name']);
                    }
                    else { //insert
                        $parentid = $this->request->get("parentid");
                        if (empty($parentid)) $parentid = 0;
                        $datapost['parentid'] = $parentid;
                        $o = new Category();
                        $o->id = time();
                        $datapost['usercreate'] = $this->userinfo['id'];
                        $datapost['datecreate'] = time();
                    }
                    if ($datapost['type'] == 'list') $datapost['content'] = '';
                    if ($datapost['layout'] == '2col') $datapost['rightcolcontent'] = '';
                    $o->map_object($datapost);
                    $o->save();
                    $this->flash->success($this->view->labelkey['general.lbl_process_success']);
                    $this->response->redirect("category/index?cattype=$cattype");

                    return;
                } catch (\Exception $e) {
                    $this->flash->error($e->getMessage());
                }
            }
            if (!empty($id)) $o = Category::findFirst($id);
            $this->view->object = $o;
            $listdata = Category::find();
            $this->view->listdata = $listdata;
            $this->view->viewvar = ["cattype" => $cattype];
        }

        public function deleteAction() {
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

        public function getcategorybynameAction() {
            if (!$this->checkpermission("category_view")) return;
            $this->view->setRenderLevel(\Phalcon\Mvc\View::LEVEL_NO_RENDER);
            header("Content-Type:application/json;charset=utf-8");
            $q = $this->request->getQuery("q", "string");
            $query = $q ? "name LIKE '%" . $q . "%'" : '';
            $listdata = Category::find([
                "conditions" => $query,
                "order" => "id asc",
                "limit" => 100
            ]);
            echo json_encode($listdata->toArray());

            return;
        }

        public function getajaxmenuAction() {
            if (!$this->checkpermission("category_view")) return;
            $this->view->setRenderLevel(\Phalcon\Mvc\View::LEVEL_NO_RENDER);
            header("Content-Type:application/json;charset=utf-8");
            $atid = $this->request->getPost("atid");
            $catid = $this->request->getPost("catid");
            $catobj = Category::findFirst($catid);
            $selectedArr = [$catid];
            if ($atid > 0) {
                $selectedCat = AtCat::find([
                    'conditions' => "atid=$atid",
                    'columns' => 'catid'
                ]);
                $selectedCat = $selectedCat->toArray();
                $selectedArr = [];
                foreach ($selectedCat as $sCat) array_push($selectedArr, $sCat['catid']);
            }
            $menudata = self::getAjaxCat(0, $selectedArr,$catobj->type);
            echo json_encode($menudata);
            return;
        }

        public function getAjaxCat($parentid, $selectedArr,$type) {
            if (!$this->checkpermission("category_view")) return;
            $listdata = Category::find(["conditions" => "parentid=$parentid and type='$type'"]);
            $listdata = $listdata->toArray();
            if (!count($listdata)) return null;
            $html = "<ul>";
            foreach ($listdata as $row) {
                $checked = in_array($row['id'], $selectedArr) ? 'checked' : '';
                $html .= "<li id='{$row['id']}'><label><input {$checked} type='checkbox' value='{$row['id']}' name='category[]' /> {$row['name']}</label>";
                $html .= self::getAjaxCat($row['id'], $selectedArr,$type);
                $html .= "</li>";
            }
            $html .= "</ul>";

            return $html;
        }
    }