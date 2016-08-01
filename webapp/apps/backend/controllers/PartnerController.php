<?php
    /**
     * Created by PhpStorm.
     * User: User
     * Date: 8/1/2016
     * Time: 11:20 PM
     */
    namespace Webapp\Backend\Controllers;
    use Phalcon\Exception;
    use Webapp\Backend\Models\Partner;
    use Webapp\Backend\Utility\Helper;

    class PartnerController extends ControllerBase{
        public function initialize() {
            global $config;
            $this->modulename = "partner";
            $this->view->activesidebar = $config->application->baseUri . "partner/index";
            parent::initialize();
        }

        public function indexAction() {
            if (!$this->checkpermission("partner_view")) return false;
            $limit = 20;
            $p = $this->request->get("p");
            if ($p <= 1) $p = 1;
            $cp = Helper::offset($p, $limit);
            $status = $this->request->get('status');
            $query = "id > 0 ";
            $q = $this->request->getQuery("q", "string");
            if ($q) $query .= " AND name LIKE '%" . $q . "%'";
            if (isset($status) && $status < 2) $query .= " AND status = $status";
            $listdata = Partner::find([
                "conditions" => $query,
                "order" => "id DESC",
                "limit" => $limit,
                "offset" => $cp
            ]);
            $this->view->q = $q;
            $this->view->listdata = $listdata;
            $this->view->painginfo = Helper::paginginfo(Partner::count($query), $limit, $p);
        }

        public function formAction() {
            $id = $this->request->get("id");
            if (!empty($id)) {
                if (!$this->checkpermission("partner_update")) return false;
            }
            else {
                if (!$this->checkpermission("partner_add")) return false;
            }
            if ($this->request->isPost()) {
                try {
                    $datapost = Helper::post_to_array("name,status");
                    $avatar = $this->post_file_key("avatar");
                    if ($avatar != null) $datapost['avatar'] = $avatar;
                    if ($id > 0) { // Update
                        $o = Partner::findFirst($id);
                    }
                    else { //insert
                        $o = new Partner();
                    }
                    $o->map_object($datapost);

                    if ($o->save()) $this->flash->success($this->view->labelkey['general.lbl_process_success']);
                    else  $this->flash->success($this->view->labelkey['general.lbl_process_fail']);
                } catch (\Exception $e) {
                    $this->flash->error($e->getMessage());
                }
            }
            if (!empty($id)) $o = Partner::findFirst($id);
            $this->view->object = $o;
            $this->view->backurl = strlen($this->request->getHTTPReferer()) <= 0 ? $this->view->activesidebar : $this->request->getHTTPReferer();
        }

        public function deleteAction() {
            if (!$this->checkpermission("partner_delete")) return false;
            $id = $this->request->get("id");
            try {
                Partner::findFirst($id)->delete();
                $this->flash->success($this->view->labelkey['general.lbl_process_success']);
            } catch (\Exception $e) {
                $this->flash->error($e->getMessage());
            }
            $this->response->redirect($this->request->getHTTPReferer());
        }
    }