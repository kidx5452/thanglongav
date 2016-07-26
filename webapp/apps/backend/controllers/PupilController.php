<?php
namespace Webapp\Backend\Controllers;
class PupilController extends ControllerBase
{
    public function initialize()
    {
        $this->modulename = "pupil";
        $this->view->activesidebar = "/pupil/index";
        parent::initialize();
    }

    public function indexAction()
    {
        if (!$this->checkpermission("pupil_view")) return false;
        $limit = 50;
        $p = $this->request->get("p");
        if ($p <= 1) $p = 1;
        $cp = ($p - 1) * $limit;

        $q = $this->request->getQuery("q", "string");
        $classid = $this->request->getQuery('classid');
        $sby = $this->request->get("sby");
        if(empty($sby)) $sby ="username";
        if($sby=="fullname_none_utf") $q = Helper::khongdau($q);
        $query = "flags = 'pupil'";
        if (!empty($q)) $query .= " AND $sby LIKE '%" . $q . "%'";
        if($classid) $query .= " AND classid=$classid";
        $listdata = User::find(array(
            "conditions" => $query,
            "order" => "id asc",
            "limit" => $limit,
            "offset" => $cp
        ));

        $this->view->q =  $this->request->getQuery("q", "string");
        $this->view->listdata = $listdata;
        $this->view->painginfo = Helper::paginginfo(User::count($query), $limit, $p);
    }

    public function formAction()
    {
        $id = $this->request->get("id");
        if (!empty($id)) {
            if (!$this->checkpermission("pupil_update")) return false;
        } else {
            if (!$this->checkpermission("pupil_add")) return false;
        }
        if ($this->request->isPost()) {
            try {
                $datapost = Helper::post_to_array("username,password,email,firstname,lastname,dob,address,phone,gender,classid,pos_id,email,phone2,father_name,mother_name");
                // <editor-fold desc="Validate">
                if (strlen($datapost['password']) > 0) $datapost['password'] = Helper::encryptpassword($datapost['password']);
                else unset($datapost['password']);

                $avatar = $this->post_file_key("avatar");
                if ($avatar != null) $datapost['avatar'] = $avatar;

                $datapost['dob'] = strtotime($datapost['dob']);
                $datapost['flags'] = "pupil";
                $is_action = true;
                $datapost['fullname_none_utf'] = Helper::khongdau($datapost['firstname']." ".$datapost['lastname']);
                if ($id > 0) { // Update
                    $o = User::findFirst($id);
                    if ($o->username == $datapost['username']) unset($datapost['username']);

                } else { //insert
                    $o = new User();
                    $datapost['status'] = 1;
                    $datapost['usercreate'] = $this->userinfo['id'];
                    $datapost['datecreate'] = time();
                    $datapost['active_register'] = md5(time() . uniqid());
                   /* if (!empty($datapost['email'])) {
                        $htmlx = $this->render_template("shared/mailtemplate", "registerpupil", array("link" => $this->config->application->baseUrl."user/activeaccount?u=" . $datapost['username'] . "&a=" . $datapost['active_register']));
                        Helper::sendMail("Thông tin tài khoản WSI", $htmlx, $datapost['email']);
                    }*/
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

        $listpos = UserPosition::find(
            array(
                'conditions' => '1=1',
                "order" => "sorts ASC"
            )
        );

        $this->view->listpos = $listpos;
        if (!empty($id)) $o = User::findFirst($id);
        $o->birthday = date('d-m-Y', $o->dob);
        $this->view->object = $o;
        $this->view->backurl = strlen($this->request->getHTTPReferer()) <= 0 ? $this->view->activesidebar : $this->request->getHTTPReferer();
    }

    public function deleteAction()
    {
        if (!$this->checkpermission("pupil_delete")) return false;
        $id = $this->request->get("id");
        try {
            AlbumTag::find("userid=$id")->delete();
            EventTag::find("userid=$id")->delete();
            NotifyPupil::find("userid=$id")->delete();
            RpAttitude::find("userid=$id")->delete();
            RpMinitest::find("userid=$id")->delete();
            RpOraltest::find("userid=$id")->delete();
            RpPresentation::find("userid=$id")->delete();
            RpSkilltest::find("userid=$id")->delete();
            RpQuarter::find("userid=$id")->delete();
            RpRequestLog::find("userid=$id")->delete();
            Timetable::find("userid=$id")->delete();
            Tuition::find("userid=$id")->delete();
            User::findFirst($id)->delete();
            $this->flash->success($this->view->labelkey['general.lbl_process_success']);
        } catch (Exception $e) {
            $this->flash->error($e->getMessage());
        }
        $this->response->redirect($this->request->getHTTPReferer());
    }

    public function excelAction()
    {
        if (!$this->checkpermission("pupil_add")) return false;
        if ($this->request->isPost()) {
            try {
                $file = $this->post_file_key("excel");
                $target_dir = "/home/wsi.vn/public_html/public/";
                $file = $target_dir.$file;
                require $this->config->application['vendorDir'].'excel/PHPExcel.php';

                $objReader = PHPExcel_IOFactory::createReader('Excel2007');
                $objReader->setReadDataOnly(true);
                $objPHPExcel = $objReader->load($file);
                $worksheet = $objPHPExcel->getActiveSheet();
                $rowcount = 1;
                $listclassobj = array();
                foreach ($worksheet->getRowIterator() as $row) {
                    if($rowcount>=2){
                        $cellIterator = $row->getCellIterator();
                        $cellIterator->setIterateOnlyExistingCells(false); // Loop all cells, even if it is not set
                        $pupilitem = array();
                        foreach ($cellIterator as $cell) {
                            if (!is_null($cell)) {
                                $column = trim($cell->getColumn());
                                if($column=="A") $pupilitem['firstname'] = $cell->getValue();
                                else if($column=="B") $pupilitem['lastname'] = $cell->getValue();
                                else if($column=="C") $pupilitem['username'] = $cell->getValue();
                                else if($column=="D") $pupilitem['password'] = $cell->getValue();
                                else if($column=="E") $pupilitem['email'] = $cell->getValue();
                                else if($column=="F") $pupilitem['class'] = $cell->getValue();
                                else if($column=="G") $pupilitem['dob'] = $cell->getValue();
                                else if($column=="H") $pupilitem['address'] = $cell->getValue();
                                else if($column=="I") $pupilitem['phone'] = $cell->getValue();
                                else if($column=="J") $pupilitem['phone2'] = $cell->getValue();
                                else if($column=="K") $pupilitem['father_name'] = $cell->getValue();
                                else if($column=="L") $pupilitem['mother_name'] = $cell->getValue();
                            }
                        }
                        $listclassobj[] = $pupilitem;
                    }
                    ++$rowcount;
                }
                foreach($listclassobj as $key=> $item){
                    $user = new User();
                    $countUserbyUsername = User::count("username='{$item['username']}'");
                    if($countUserbyUsername>0) $item['username'] = $item['username'].($countUserbyUsername+1);

                    // Insert class group
                    $class_box = Classbox::findFirst(array("conditions"=>"keycode = '{$item['class'][0]}'"));
                    if($class_box->id<=0){
                        $class_box = new Classbox();
                        $class_box->id = time()+$key;
                        $class_box->name = "Khối {$item['class'][0]}";
                        $class_box->keycode = $item['class'][0];
                        $class_box->sorts = $key;
                        $class_box->save();
                    }
                    $classobj = Classobj::findFirst(array(
                            "conditions"=>"keycode='{$item['class']}'"
                    ));
                    if(isset($classobj->id)) $classid = $classobj->id;
                    else {
                        $classobj = new Classobj();
                        $classid = time()+$key;
                        $classobj->id = $classid;
                        $classobj->name = $item['class'];
                        $classobj->captions = $item['class'];
                        $classobj->datecreate = time();
                        $classobj->usercreate = $this->userinfo['id'];
                        $classobj->classboxid = $class_box->id;
                        $classobj->keycode = $item['class'];
                        $classobj->save();
                    }
                    $item['classid'] = $classid;
                    $item['dob'] = date($format = "d-m-Y", PHPExcel_Shared_Date::ExcelToPHP($item['dob']));
                    $item['dob'] = strtotime($item['dob']);
                    $item['fullname_none_utf'] = Helper::khongdau($item['firstname']." ".$item['lastname']);
                    if(strlen($item['password'])<=0) $item['password'] = uniqid()."";
                    else $item['password'] = Helper::encryptpassword($item['password']);
                    unset($item['class'],$classobj);
                    $user->map_object($item);
                    $user->active_register = md5(uniqid().time());
                    $user->status = 1;
                    $user->flags = "pupil";
                    $user->datecreate = time();
                    $user->save();
                }
                $this->flash->success($this->view->labelkey['general.lbl_process_success']);
            } catch (Exception $e) {
                $this->flash->error($e->getMessage());
            }
        }
        $this->view->backurl = strlen($this->request->getHTTPReferer())<=0? $this->view->activesidebar: $this->request->getHTTPReferer();
    }

    public function generalreportAction(){
        if (!$this->checkpermission("pupil_report")) return false;
        $userid = $this->request->get("uid");
        $key = $this->request->get("q");
        $query = "userid = $userid";
        $limit = 20;
        $p = $this->request->get("p");
        if ($p <= 1) $p = 1;
        $cp = ($p - 1) * $limit;

        if(!empty($key)) {
            $datecreate_q = strtotime($key);
            if($datecreate_q<=0) $datecreate_q = date("d-m-Y");
            $query .=" and datecreate=$datecreate_q";
        }
        $listdata = RpGeneral::find(array(
                "conditions" => $query,
                "order" => "datecreate desc",
                "limit" => $limit,
                "offset" => $cp
        ));
        $this->view->listdata = $listdata;
        $this->view->uid = $userid;
        $this->view->q = $key;
        $this->view->backurl = strlen($this->request->getHTTPReferer())<=0? $this->view->activesidebar: $this->request->getHTTPReferer();
        $this->view->painginfo = Helper::paginginfo(RpGeneral::count($query), $limit, $p);
    }

    public function generalreportformAction(){
        if (!$this->checkpermission("pupil_report")) return false;
        $userid = $this->request->get("uid");
        $rpid = $this->request->get("rid");
        try{
            if($this->request->isPost()){
                $datapost = Helper::post_to_array("datecreate,point,contents");
                $datapost['datecreate'] = strtotime($datapost['datecreate']);
                if($rpid>0){ // Update
                    $o = RpGeneral::findFirst($rpid);
                }
                else{ // Insert
                    $o = new RpGeneral();
                }
                $o->userid = $userid;
                $o->map_object($datapost);
                $o->save();
                $this->flash->success($this->view->labelkey['general.lbl_process_success']);
                $this->response->redirect("pupil/generalreport?uid=$userid");
                return false;
            }
            if (!empty($rpid)) $o = RpGeneral::findFirst($rpid);
            $o->datecreate = date("d-m-Y",$o->datecreate);
            $this->view->object = $o;
        }
        catch(Exception $e){
            $this->flash->error($e->getMessage());
        }
        $this->view->backurl = strlen($this->request->getHTTPReferer())<=0? $this->view->activesidebar: $this->request->getHTTPReferer();
    }
    public function generalreportdeleteAction()
    {
        if (!$this->checkpermission("pupil_report")) return false;
        $id = $this->request->get("rid");
        $o = RpGeneral::findFirst($id);
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