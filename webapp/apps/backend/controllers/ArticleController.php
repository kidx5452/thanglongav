<?php
    namespace Webapp\Backend\Controllers;

    use Webapp\Backend\Locale\Culture;
    use Webapp\Backend\Models\Article;
    use Webapp\Backend\Models\ArticleView;
    use Webapp\Backend\Models\AtCat;
    use Webapp\Backend\Models\Category;
    use Webapp\Backend\Utility\Helper;

    class ArticleController extends ControllerBase {
        public function initialize() {
            global $config;
            $this->modulename = "article";
            $this->view->activesidebar = $config->application->baseUri . "category/index";
            parent::initialize();
        }

        public function indexAction() {
            if (!$this->checkpermission("news_view")) return false;
            $limit = 20;
            $p = $this->request->get("p");
            if ($p <= 1) $p = 1;
            $cp = ($p - 1) * $limit;
            $catid = $this->request->get("catid");
            $query = "1=1 ";
            if (!isset($catid)) $this->response->redirect('/category/index');

            $query .= " and catid = '{$catid}'";
            $list_atcat = AtCat::find([
                'conditions' => $query,
                'order' => 'id desc',
                'limit' => $limit,
                'offset' => $cp
            ]);
            if (count($list_atcat)) {
                $list_atcat = $list_atcat->toArray();
                $list_id = implode(",", array_column($list_atcat, 'atid'));
                $listdata = Article::find([
                    "conditions" => "id in ($list_id)",
                    "order" => "id DESC"
                ]);
            }
            $this->view->painginfo = Helper::paginginfo(AtCat::count($query), $limit, $p);

            $this->view->q = $q;
            $this->view->langlist = Culture::lang();
            $this->view->listdata = $listdata;
        }

        public function formAction() {
            $catid = $this->request->get("catid");
            $id = $this->request->get("id");
            if (!empty($id)) {
                if (!$this->checkpermission("news_update")) return false;
            }
            else {
                if (!$this->checkpermission("news_add")) return false;
            }
            if ($this->request->isPost()) {
                try {
                    $datapost = Helper::post_to_array("name,captions,descriptions,status,content,lang,cover_video");
                    $avatar = $this->post_file_key("avatar");
                    if ($avatar != null) $datapost['avatar'] = $avatar;
                    $coveravatar = $this->post_file_key("coveravatar");
                    if ($coveravatar != null) $datapost['coveravatar'] = $coveravatar;
                    $coverphoto = $this->post_file_key("coverphoto");
                    if ($coverphoto != null) $datapost['coverphoto'] = $coverphoto;
                    if ($id > 0) { // Update
                        $o = Article::findFirst($id);
                        if ($o->name == $datapost['name']) unset($datapost['name']);
                        if (!$this->checkpermission("news_updatestatus", false)) unset($datapost['status']);
                        $atid = $id;
                        // Start Delete Article Cat
                        $c = AtCat::find("atid=$id");
                        if ($c) {
                            try {
                                $c->delete();
                            } catch (\Exception $e) {
                                $this->flash->error($e->getMessage());
                            }
                        }
                        // End Delete Article Cat
                    }
                    else { //insert
                        $o = new Article();
                        $atid = $o->id = time();
                        if (!$this->checkpermission("news_updatestatus", false)) $datapost['status'] = 0;
                        $datapost['usercreate'] = $this->userinfo['id'];
                        $datapost['datecreate'] = time();
                    }
                    $o->map_object($datapost);
                    $o->save();
                    // Start Insert Article Cat
                    $selectedCat = array_values(array_unique($this->request->getPost('category')));
                    $i = 1;
                    foreach ($selectedCat as $sCat) {
                        try {
                            $acdata['catid'] = (int)$sCat;
                            $acdata['atid'] = $atid;
                            $ac = new AtCat();
                            $ac->map_object($acdata);
                            $ac->save();
                            $i++;
                        } catch (\Exception $e) {
                            $this->flash->error($e->getMessage());
                        }
                    }
                    // End Insert Article Cat
                    if ($i > sizeof($selectedCat)) $this->flash->success($this->view->labelkey['general.lbl_process_success']);
                    else  $this->flash->success($this->view->labelkey['general.lbl_process_fail']);
                } catch (\Exception $e) {
                    $this->flash->error($e->getMessage());
                }
            }
            $catobject = Category::findFirst($catid);
            if (!empty($id)) $o = Article::findFirst($id);
            $htmlx = $this->render_template("article/form",$catobject->type,$o);
            $this->view->htmlx = $htmlx;
            $this->view->typesArticle = $this->articleType();
            $this->view->langlist = Culture::lang();
            $this->view->backurl = strlen($this->request->getHTTPReferer()) <= 0 ? $this->view->activesidebar : $this->request->getHTTPReferer();
        }

        public function deleteAction() {
            if (!$this->checkpermission("news_delete")) return false;
            $id = $this->request->get("id");
            // Update pin category
            foreach (Category::find("pintop_atid=$id") as $pintop) {
                $pintop->pintop_atid = 0;
                $pintop->save();
            }
            foreach (Category::find("left_atid=$id") as $pinleft) {
                $pinleft->left_atid = 0;
                $pinleft->save();
            }
            foreach (Category::find("center_atid=$id") as $pincenter) {
                $pincenter->center_atid = 0;
                $pincenter->save();
            }
            foreach (Category::find("right_atid=$id") as $pinright) {
                $pinright->right_atid = 0;
                $pinright->save();
            }
            try {
                AtCat::find("atid=$id")->delete();
                ArticleView::find("atid=$id")->delete();
                Article::findFirst($id)->delete();
                $this->flash->success($this->view->labelkey['general.lbl_process_success']);
            } catch (\Exception $e) {
                $this->flash->error($e->getMessage());
            }
            $this->response->redirect($this->request->getHTTPReferer());
        }

        public function getbynameAction() {
            if (!$this->checkpermission("news_view")) return false;
            $this->view->setRenderLevel(\Phalcon\Mvc\View::LEVEL_NO_RENDER);
            header("Content-Type:application/json;charset=utf-8");
            $q = $this->request->getQuery("q", "string");
            $query = $q ? "name LIKE '%" . $q . "%'" : '';
            $listdata = Article::find([
                "conditions" => $query,
                "order" => "id asc",
                "limit" => 100
            ]);
            echo json_encode($listdata->toArray());

            return;
        }

        public function articleType(){
            $type[] = array("name"=>"Bản quyền Audio","key"=>"audio");
            $type[] = array("name"=>"Bản quyền Video","key"=>"video");
            $type[] = array("name"=>"Trao đổi bản quyền","key"=>"copyright");
            return $type;
        }
    }

