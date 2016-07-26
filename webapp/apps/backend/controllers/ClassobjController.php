<?php
namespace Webapp\Backend\Controllers;
/**
 * Created by PhpStorm.
 * User: ViviPro
 * Date: 3/25/2016
 * Time: 12:37 PM
 */
class ClassobjController extends ControllerBase
{
    public function initialize()
    {
        $this->modulename = "classobj";
        $this->view->activesidebar = "/classobj/index";
        parent::initialize();
    }

    public function indexAction()
    {
        if (!$this->checkpermission("classobj_view")) return false;
        $limit = 25;
        $p = $this->request->get("p");
        if ($p <= 1) $p = 1;
        $cp = ($p - 1) * $limit;
        $query = "1=1";
        $q = $this->request->getQuery("q", "string");
        if ($q) $query .= " AND name LIKE '%" . $q . "%'";

        $listgroup = Classbox::find(
            array(
                "conditions" => $query,
                "order" => "keycode ASC",
                "limit" => $limit,
                "offset" => $cp
            )
        );
        $this->view->listdata = $listgroup;
        $this->view->q = $q;
        $this->view->painginfo = Helper::paginginfo(Classbox::count($query), $limit, $p);
    }

    public function groupformAction()
    {
        $id = $this->request->get("id");
        if (!empty($id)) {
            if (!$this->checkpermission("classobj_update")) return false;
        } else {
            if (!$this->checkpermission("classobj_add")) return false;
        }
        if ($this->request->isPost()) {
            try {
                $datapost = Helper::post_to_array("name,captions,sorts,keycode");
                if ($id > 0) { // Update
                    $o = Classbox::findFirst($id);
                } else { //insert
                    $o = new Classbox();
                    $o->id = time();
                }
                $o->map_object($datapost);
                $o->save();
                $this->flash->success($this->view->labelkey['general.lbl_process_success']);
            } catch (Exception $e) {
                $this->flash->error($e->getMessage());
            }
        }
        if (!empty($id)) $o = Classbox::findFirst($id);
        $this->view->object = $o;
    }

    public function formAction()
    {
        $id = $this->request->get("id");
        $groupid = $this->request->get("groupid");
        if (!empty($id)) {
            if (!$this->checkpermission("classobj_update")) return false;
        } else {
            if (!$this->checkpermission("classobj_add")) return false;
        }
        if ($this->request->isPost()) {
            try {
                $datapost = Helper::post_to_array("name,captions,classboxid");
                if ($id > 0) { // Update
                    $o = Classobj::findFirst($id);
                } else { //insert
                    $o = new Classobj();
                    $o->id = time();
                    $datapost['usercreate'] = $this->userinfo['id'];
                    $datapost['datecreate'] = time();
                }
                $o->map_object($datapost);
                $o->save();
                $this->flash->success($this->view->labelkey['general.lbl_process_success']);
            } catch (Exception $e) {
                $this->flash->error($e->getMessage());
            }
        }
        $o = new Classobj();
        if (!empty($id)) $o = Classobj::findFirst($id);
        if ($groupid > 0) $o->classboxid = $groupid;
        $this->view->object = $o;
        $this->view->listgroup = Classbox::find();
    }

    public function excelAction()
    {
        if (!$this->checkpermission("classobj_add")) return false;
        if ($this->request->isPost()) {
            try {
                $file = $this->post_file_key("excel", true);
                require $this->config->application['vendorDir'] . 'excel/PHPExcel.php';

                $objReader = PHPExcel_IOFactory::createReader('Excel2007');
                $objReader->setReadDataOnly(true);
                $objPHPExcel = $objReader->load($file);
                $worksheet = $objPHPExcel->getActiveSheet();
                $rowcount = 1;
                $listclassobj = array();
                foreach ($worksheet->getRowIterator() as $row) {
                    if ($rowcount >= 2) {
                        $cellIterator = $row->getCellIterator();
                        $cellIterator->setIterateOnlyExistingCells(false); // Loop all cells, even if it is not set
                        foreach ($cellIterator as $cell) {
                            if (!is_null($cell)) {
                                $column = trim($cell->getColumn());
                                if ($column == "A") $listclassobj[] = $cell->getValue();
                            }
                        }
                    }
                    ++$rowcount;
                }
                foreach ($listclassobj as $key => $item) {
                    $c = Classobj::count("name='$item'");
                    if ($c <= 0) {
                        $classobj = new Classobj();
                        $id = time() + $key;
                        $classobj->id = $id;
                        $classobj->datecreate = time();
                        $classobj->keycode = $item;
                        $classobj->name = $item;
                        $classobj->captions = $item;
                        $classobj->usercreate = $this->userinfo['id'];
                        $classobj->save();
                    }
                }
                $this->flash->success($this->view->labelkey['general.lbl_process_success']);
            } catch (Exception $e) {
                $this->flash->error($e->getMessage());
            }
        }
        $this->view->backurl = strlen($this->request->getHTTPReferer()) <= 0 ? $this->view->activesidebar : $this->request->getHTTPReferer();
    }

    public function deleteAction()
    {
        if (!$this->checkpermission("classobj_delete")) return false;
        $id = $this->request->get("id");
        try {
            AlbumTag::find("classid=$id")->delete();
            EventTag::find("classid=$id")->delete();
            Timetable::find("classid=$id")->delete();
            Classobj::findFirst($id)->delete();
            $this->flash->success($this->view->labelkey['general.lbl_process_success']);
        } catch (Exception $e) {
            $this->flash->error($e->getMessage());
        }
        $this->response->redirect($this->request->getHTTPReferer());
    }

    public function getbynameAction()
    {
        if (!$this->checkpermission("classobj_view")) return;
        $this->view->setRenderLevel(\Phalcon\Mvc\View::LEVEL_NO_RENDER);
        header("Content-Type:application/json;charset=utf-8");
        $q = $this->request->getQuery("q", "string");
        $query = $q ? "name LIKE '%" . $q . "%'" : '';
        $listdata = Classobj::find(array(
            "conditions" => $query,
            "order" => "id asc",
            "limit" => 100
        ));
        echo json_encode($listdata->toArray());
        return;
    }

    /** Report */
    public function dailyreportAction()
    {
        if (!$this->checkpermission("pupil_report")) return false;
        $classid = $this->request->get("classid", "int");
        $id = $this->request->get("id", "int");

        try {
            if ($this->request->isPost()) {
                if ($this->request->getPost("actiontype") == "attitude") { // Save Attitude
                    $datapost = Helper::post_to_array("attendance,participation,behavior,diligence,datetest,userid");
                    $datapost['datetest'] = str_replace(array("\\", "/"), "-", $datapost['datetest']);
                    $datapost['datetest'] = strtotime($datapost['datetest']);
                    $tmp = RpAttitude::find(array(
                        "conditions" => " datetest = :datetest: ",
                        "bind" => array("datetest" => $datapost['datetest'])
                    ));
                    if ($tmp) $tmp->delete();
                    foreach ($datapost['userid'] as $key => $val) {
                        if (strlen($datapost['attendance'][$key]) > 0) {
                            $attitudepost = new RpAttitude();
                            if( strlen($datapost['attendance'][$key])>0 &&
                            strlen($datapost['participation'][$key])>0 &&
                            strlen($datapost['behavior'][$key])>0 &&
                            strlen($datapost['diligence'][$key])>0){
                                $attitudepost->attendance = $datapost['attendance'][$key];
                                $attitudepost->participation = $datapost['participation'][$key];
                                $attitudepost->behavior = $datapost['behavior'][$key];
                                $attitudepost->diligence = $datapost['diligence'][$key];
                                $attitudepost->status = 1;
                                $attitudepost->datetest = $datapost['datetest'];
                                $attitudepost->datecreate = time();
                                $attitudepost->usercreate = $this->userinfo['id'];
                                $attitudepost->userid = $val;
                                $attitudepost->type = "day";
                                $attitudepost->save();
                            }

                        }
                    }
                } else if ($this->request->getPost("actiontype") == "minitest") { // Save MiniTest
                    $datapost = Helper::post_to_array("point,userid,datetest");
                    $datapost['datetest'] = str_replace(array("\\", "/"), "-", $datapost['datetest']);
                    $datapost['datetest'] = strtotime($datapost['datetest']);
                    $tmp = RpMinitest::find(array(
                        "conditions" => " datetest = :datetest: ",
                        "bind" => array("datetest" => $datapost['datetest'])
                    ));
                    if ($tmp) $tmp->delete();
                    foreach ($datapost['userid'] as $key => $val) {
                        $minitestpost = new RpMinitest();
                        if(strlen($datapost['point'][$key])>0){
                            $minitestpost->point = $datapost['point'][$key];
                            $minitestpost->sorts = $key;
                            $minitestpost->status = 1;
                            $minitestpost->datetest = $datapost['datetest'];
                            $minitestpost->datecreate = time();
                            $minitestpost->usercreate = $this->userinfo['id'];
                            $minitestpost->userid = $val;
                            $minitestpost->type = "day";
                            $minitestpost->save();
                        }

                    }
                } else if ($this->request->getPost("actiontype") == "notify") { // Save Notify
                    $datapost = Helper::post_to_array("name,content,userid");
                    /*
                    $datapost['datetest'] = str_replace(array("\\", "/"), "-", $datapost['datetest']);
                    $datapost['datetest'] = strtotime($datapost['datetest']);
                    $tmp = NotifyPupil::find(array(
                        "conditions" => " datetest = :datetest: ",
                        "bind" => array("datetest" => $datapost['datetest'])
                    ));
                    if ($tmp) $tmp->delete();
                    */
                    foreach ($datapost['userid'] as $key => $val) {
                        if (strlen($datapost['name'][$key]) > 0) {
                            $notify = new NotifyPupil();
                            $notify->id = time() + $key;
                            $notify->name = $datapost['name'][$key];
                            $notify->content = $datapost['content'][$key];
                            $notify->status = 2;
                            $notify->datetest = time();
                            $notify->datecreate = time();
                            $notify->usercreate = $this->userinfo['id'];
                            $notify->userid = $val;
                            $notify->save();
                        }
                    }

                }
                $this->flash->success($this->view->labelkey['general.lbl_process_success']);
                //$this->response->redirect("classobj/dailyreport?classid=$classid");
            }
        } catch (Exception $e) {
            $this->flash->error($e->getMessage());
            $this->response->redirect("classobj/dailyreport?classid=$classid");
            return false;
        }
        $classobj = Classobj::findFirst($classid);
        $pupilobj = $id ? User::findFirst($id)->toArray() : array();
        $this->view->classobj = $classobj;
        $this->view->pupilobj = $pupilobj;
        $this->view->activetab = $this->request->get("actiontype") ? $this->request->get("actiontype") : 'attitude';
    }

    public function viewdailyreportAction()
    {
        if (!$this->checkpermission("pupil_report")) return false;
        $classid = $this->request->get("classid", "int");
        $type = $this->request->get('type') ? $this->request->get("type", "string") : 'attitude';
        $classobj = Classobj::findFirst($classid);
        $this->view->classobj = $classobj;

        if ($this->request->get('delete', 'int') == 1) {
            $datetest = $this->request->get('datetest', 'int');
            switch ($type) {
                default:
                    $listdelete = RpAttitude::find("datetest=$datetest AND type='day'");
                    break;
                case 'minitest':
                    $listdelete = RpMinitest::find("datetest=$datetest AND type='day'");
                    break;
                case 'notify':
                    $listdelete = NotifyPupil::find("datecreate=$datetest");
                    break;
            }
            if ($listdelete) {
                try {
                    $listdelete->delete();
                } catch (Exception $e) {
                    $this->flash->error($e->getMessage());
                }
            }
        }

        $pupilStr = '';
        foreach ($classobj->Pupil as $pupil) $pupilStr .= $pupil->id . ',';
        $pupilStr = $pupilStr ? substr($pupilStr, 0, -1) : 'false';

        $limit = 20;
        $p = $this->request->get("p");
        if ($p <= 1) $p = 1;
        $cp = ($p - 1) * $limit;

        switch ($type) {
            default:
                $query = $this->db->query("SELECT DISTINCT FROM_UNIXTIME(datetest,\"%d-%m-%Y\") AS day, datetest FROM rp_attitude WHERE type='day' AND userid IN($pupilStr) GROUP BY day ORDER BY datetest DESC LIMIT $cp,$limit");
                $listdata = $query->fetchAll();
                $count = $this->db->query("SELECT DISTINCT FROM_UNIXTIME(datetest,\"%d-%m-%Y\") AS day, datetest FROM rp_attitude WHERE type='day' AND userid IN($pupilStr) GROUP BY day")->numRows();
                $pointName = 'reportpupil.lbl_attitude';
                break;
            case 'minitest':
                $query = $this->db->query("SELECT DISTINCT FROM_UNIXTIME(datetest,\"%d-%m-%Y\") AS day, datetest FROM rp_minitest WHERE type='day' AND userid IN($pupilStr) GROUP BY day ORDER BY datetest DESC LIMIT $cp,$limit");
                $listdata = $query->fetchAll();
                $count = $this->db->query("SELECT DISTINCT FROM_UNIXTIME(datetest,\"%d-%m-%Y\") AS day, datetest FROM rp_minitest WHERE type='day' AND userid IN($pupilStr) GROUP BY day")->numRows();
                $pointName = 'reportpupil.lbl_minitest';
                break;
            case 'notify':
                $query = $this->db->query("SELECT FROM_UNIXTIME(datecreate,\"%d-%m-%Y %H:%i:%s\") AS day, datecreate as datetest FROM notify_pupil WHERE userid IN($pupilStr) ORDER BY datecreate DESC LIMIT $cp,$limit");
                $listdata = $query->fetchAll();
                $count = $this->db->query("SELECT FROM_UNIXTIME(datecreate,\"%d-%m-%Y\") AS day, datecreate as datetest FROM notify_pupil WHERE userid IN($pupilStr)")->numRows();
                $pointName = 'reportpupil.lbl_notify';
                break;
        }
        $this->view->pointname = $pointName;
        $this->view->listdata = $listdata;
        $this->view->painginfo = Helper::paginginfo($count, $limit, $p);
    }

    public function viewattitudereportAction()
    {
        if (!$this->checkpermission("pupil_report")) return false;
        $classid = $this->request->get("classid", "int");
        $datetest = $this->request->get('datetest', 'int');
        $classobj = Classobj::findFirst($classid);
        $this->view->classobj = $classobj;

        if ($this->request->isPost()) {
            if ($this->request->getPost("actiontype") == "attitude") { // Update
                try {
                    $datapost = Helper::post_to_array("id,attendance,participation,behavior,diligence,status");
                    foreach ($datapost['id'] as $key => $val) {
                        if (strlen($datapost['attendance'][$val]) > 0) {
                            $attitudepost = RpAttitude::findFirst($val);
                            $attitudepost->attendance = $datapost['attendance'][$val];
                            $attitudepost->participation = $datapost['participation'][$val];
                            $attitudepost->behavior = $datapost['behavior'][$val];
                            $attitudepost->diligence = $datapost['diligence'][$val];
                            $attitudepost->status = $datapost['status'];
                            $attitudepost->save();
                        }
                    }
                    $this->flash->success($this->view->labelkey['general.lbl_process_success']);
                } catch (Exception $e) {
                    $this->flash->error($e->getMessage());
                }
            }
        }

        $pupilStr = '';
        foreach ($classobj->Pupil as $pupil) $pupilStr .= $pupil->id . ',';
        $pupilStr = $pupilStr ? substr($pupilStr, 0, -1) : 'false';

        $listdata = RpAttitude::find(array(
            'conditions' => "type='day' AND datetest=$datetest AND userid IN ($pupilStr) ORDER BY userid ASC"
        ));

        $this->view->listdata = $listdata;
    }

    public function viewminitestreportAction()
    {
        if (!$this->checkpermission("pupil_report")) return false;
        $classid = $this->request->get("classid", "int");
        $datetest = $this->request->get('datetest', 'int');
        $classobj = Classobj::findFirst($classid);
        $this->view->classobj = $classobj;

        if ($this->request->isPost()) {
            if ($this->request->getPost("actiontype") == "attitude") { // Update
                try {
                    $datapost = Helper::post_to_array("id,point,status");
                    foreach ($datapost['id'] as $key => $val) {
                        if (strlen($datapost['point'][$val]) > 0) {
                            $minitestpost = RpMinitest::findFirst($val);
                            $minitestpost->point = $datapost['point'][$val];
                            $minitestpost->status = $datapost['status'];
                            $minitestpost->save();
                        }
                    }
                    $this->flash->success($this->view->labelkey['general.lbl_process_success']);
                } catch (Exception $e) {
                    $this->flash->error($e->getMessage());
                }
            }
        }

        $pupilStr = '';
        foreach ($classobj->Pupil as $pupil) $pupilStr .= $pupil->id . ',';
        $pupilStr = $pupilStr ? substr($pupilStr, 0, -1) : 'false';

        $listdata = RpMinitest::find(array(
            'conditions' => "type='day' AND datetest=$datetest AND userid IN ($pupilStr) ORDER BY userid ASC"
        ));

        $this->view->listdata = $listdata;
    }

    public function viewnotifyreportAction()
    {
        if (!$this->checkpermission("pupil_report")) return false;
        $classid = $this->request->get("classid", "int");
        $datecreate = $this->request->get('datetest', 'int');
        $classobj = Classobj::findFirst($classid);
        $this->view->classobj = $classobj;

        if ($this->request->isPost()) {
            if ($this->request->getPost("actiontype") == "notify") { // Update
                try {
                    $datapost = Helper::post_to_array("id,name,content,status");
                    foreach ($datapost['id'] as $key => $val) {
                        if (strlen($datapost['content'][$val]) > 0) {
                            $notifypost = NotifyPupil::findFirst($val);
                            $notifypost->name = $datapost['name'][$val];
                            $notifypost->content = $datapost['content'][$val];
                            $notifypost->status = $datapost['status'][$val];
                            $notifypost->save();
                        }
                    }
                    $this->flash->success($this->view->labelkey['general.lbl_process_success']);
                } catch (Exception $e) {
                    $this->flash->error($e->getMessage());
                }
            }
        }

        $pupilStr = '';
        foreach ($classobj->Pupil as $pupil) $pupilStr .= $pupil->id . ',';
        $pupilStr = $pupilStr ? substr($pupilStr, 0, -1) : 'false';

        $listdata = NotifyPupil::find(array(
            'conditions' => "datecreate=$datecreate AND userid IN ($pupilStr) ORDER BY userid ASC"
        ));

        $this->view->listdata = $listdata;
    }

    public function monthlyreportAction()
    {
        if (!$this->checkpermission("pupil_report")) return false;
        $classid = $this->request->get("classid", "int");
        $classobj = Classobj::findFirst($classid);
        if ($this->request->isPost()) {
            $fileexcel = $this->post_file_key("file", true);
            $flag_process = true;
            if(!file_exists($fileexcel)){
                $this->flash->error("Upload not success");
                $flag_process = false;
            }
            if($flag_process==true){
                require $this->config->application['vendorDir'] . 'excel/PHPExcel.php';
                $objReader = PHPExcel_IOFactory::createReader('Excel2007');
                $objPHPExcel = $objReader->load($fileexcel);
                $worksheet = $objPHPExcel->getActiveSheet();
                $totalrow = $worksheet->getHighestRow();
                $monthcreate = $worksheet->getCell("B1")->getValue();
                $monthcreate = date($format = "m/d/Y", PHPExcel_Shared_Date::ExcelToPHP($monthcreate));
                $monthcreate = date("m-Y",strtotime($monthcreate));
                if ($this->request->get("action") == "skilltest") {
                    $reading_column = $worksheet->getCell("C2");
                    if(strtolower(trim($reading_column))=="reading"){
                        try {
                            $monthcreate = "01-".$monthcreate." 00:00:00";
                            $monthcreate = strtotime($monthcreate);
                            for ($i = 3; $i <= $totalrow; $i++) {
                                $userid = $worksheet->getCell("B$i")->getValue();
                                $rpskilltest = new RpSkilltest();
                                RpSkilltest::find(array(
                                    "conditions" => "datetest=:datetest: and type='month' and userid = :userid:",
                                    "bind" => array("datetest" => $monthcreate, "userid" => $userid)
                                ))->delete();
                                $rpskilltest->datetest = $monthcreate;
                                $rpskilltest->type = "month";
                                $rpskilltest->datecreate = time();
                                $rpskilltest->userid = $userid;
                                $rpskilltest->name = $worksheet->getCell("B4")->getValue();
                                $rpskilltest->reading = $worksheet->getCell("C$i")->getValue();
                                $rpskilltest->listening = $worksheet->getCell("D$i")->getValue();
                                $rpskilltest->writing = $worksheet->getCell("E$i")->getValue();
                                $rpskilltest->grammar = $worksheet->getCell("F$i")->getValue();
                                $rpskilltest->status = 1;
                                $rpskilltest->sorts = $i;
                                $rpskilltest->usercreate = $this->userinfo['id'];
                                $rpskilltest->save();
                            }
                            $this->flash->success($this->view->labelkey['general.lbl_process_success']);
                        } catch (Exception $e) {
                            $this->flash->error($e->getMessage());
                        }
                    }
                }
                else if ($this->request->get("action") == "oraltest") {
                    $reading_column = $worksheet->getCell("C2");
                    if(strtolower(trim($reading_column))=="pronunciation"){
                        try {
                            $monthcreate = "01-".$monthcreate." 00:00:00";
                            $monthcreate = strtotime($monthcreate);
                            for ($i = 3; $i <= $totalrow; $i++) {
                                $userid = $worksheet->getCell("B$i")->getValue();
                                RpOraltest::find(array(
                                    "conditions" => "datetest=:datetest: and type=:type: and userid = :userid:",
                                    "bind" => array("datetest" => $monthcreate, "type" => "month", "userid" => $userid)
                                ))->delete();
                                $rporaltest = new RpOraltest();
                                $rporaltest->datetest = $monthcreate;
                                $rporaltest->type = (string)"month";
                                $rporaltest->datecreate = time();
                                $rporaltest->userid = $userid;
                                $rporaltest->name = $worksheet->getCell("B$i")->getValue();
                                $rporaltest->pronunciation = $worksheet->getCell("C$i")->getValue();
                                $rporaltest->vocabular = $worksheet->getCell("D$i")->getValue();
                                $rporaltest->grammar = $worksheet->getCell("E$i")->getValue();
                                $rporaltest->fluency = $worksheet->getCell("F$i")->getValue();
                                $rporaltest->comprehension = $worksheet->getCell("G$i")->getValue();
                                $rporaltest->note_pronunciation = $worksheet->getCell("H$i")->getValue();
                                $rporaltest->note_vocabulary = $worksheet->getCell("I$i")->getValue();
                                $rporaltest->note_grammar = $worksheet->getCell("J$i")->getValue();
                                $rporaltest->note_fluency = $worksheet->getCell("K$i")->getValue();
                                $rporaltest->note_comprehension = $worksheet->getCell("L$i")->getValue();
                                $rporaltest->status = 1;
                                $rporaltest->sorts = $i;
                                $rporaltest->usercreate = $this->userinfo['id'];
                                $rporaltest->save();
                            }
                            $this->flash->success($this->view->labelkey['general.lbl_process_success']);
                        } catch (Exception $e) {
                            $this->flash->error($e->getMessage());
                        }
                    }
                }
                else if ($this->request->get("action") == "presentation") {
                    $reading_column = $worksheet->getCell("C2");
                    if(strtolower(trim($reading_column))=="organization"){
                        try {
                            $monthcreate = "01-".$monthcreate." 00:00:00";
                            $monthcreate = strtotime($monthcreate);
                            for ($i = 3; $i <= $totalrow; $i++) {
                                $userid = $worksheet->getCell("B$i")->getValue();
                                $rppresent = new RpPresentation();
                                RpPresentation::find(array(
                                    "conditions" => "datetest=:datetest: and type='month' and userid = :userid:",
                                    "bind" => array("datetest" => $monthcreate, "userid" => $userid)
                                ))->delete();
                                $rppresent->datetest = $monthcreate;
                                $rppresent->type = "month";
                                $rppresent->datecreate = time();
                                $rppresent->userid = $userid;
                                $rppresent->organization = $worksheet->getCell("C$i")->getValue();
                                $rppresent->language_use = $worksheet->getCell("D$i")->getValue();
                                $rppresent->pronunciation = $worksheet->getCell("E$i")->getValue();
                                $rppresent->interaction = $worksheet->getCell("F$i")->getValue();
                                $rppresent->voice = $worksheet->getCell("G$i")->getValue();
                                $rppresent->body_language = $worksheet->getCell("H$i")->getValue();
                                $rppresent->visual_aids = $worksheet->getCell("I$i")->getValue();
                                $rppresent->comment = $worksheet->getCell("J$i")->getValue();
                                $rppresent->status = 1;
                                $rppresent->sorts = $i;
                                $rppresent->usercreate = $this->userinfo['id'];
                                $rppresent->save();
                            }
                            $this->flash->success($this->view->labelkey['general.lbl_process_success']);
                        } catch (Exception $e) {
                            $this->flash->error($e->getMessage());
                        }
                    }
                }
                unlink($fileexcel);
            }
        }
        $this->view->classobj = $classobj;
        $this->view->activetab = $this->request->get("action") ? $this->request->get("action") : 'skilltest';
    }

    public function viewmonthlyreportAction()
    {
        if (!$this->checkpermission("pupil_report")) return false;
        $classid = $this->request->get("classid", "int");
        $type = $this->request->get('type') ? $this->request->get("type", "string") : 'skilltest';
        $classobj = Classobj::findFirst($classid);
        $this->view->classobj = $classobj;

        if ($this->request->get('delete', 'int') == 1) {
            $datetest = $this->request->get('datetest', 'int');
            switch ($type) {
                default:
                    $listdelete = RpSkilltest::find("datetest=$datetest AND type='month'");
                    break;
                case 'oraltest':
                    $listdelete = RpOraltest::find("datetest=$datetest AND type='month'");
                    break;
                case 'presentation':
                    $listdelete = RpPresentation::find("datetest=$datetest AND type='month'");
                    break;
            }
            if ($listdelete) {
                try {
                    $listdelete->delete();
                } catch (Exception $e) {
                    $this->flash->error($e->getMessage());
                }
            }
        }

        $pupilStr = '';
        foreach ($classobj->Pupil as $pupil) $pupilStr .= $pupil->id . ',';
        $pupilStr = $pupilStr ? substr($pupilStr, 0, -1) : 'false';

        $limit = 20;
        $p = $this->request->get("p");
        if ($p <= 1) $p = 1;
        $cp = ($p - 1) * $limit;

        switch ($type) {
            default:
                $query = $this->db->query("SELECT DISTINCT FROM_UNIXTIME(datetest,\"%d-%m-%Y\") AS month, datetest FROM rp_skilltest WHERE type='month' AND userid IN($pupilStr) GROUP BY month ORDER BY datetest DESC LIMIT $cp,$limit");
                $listdata = $query->fetchAll();
                $count = $this->db->query("SELECT DISTINCT FROM_UNIXTIME(datetest,\"%d-%m-%Y\") AS month, datetest FROM rp_skilltest WHERE type='month' AND userid IN($pupilStr) GROUP BY month")->numRows();
                $pointName = 'reportpupil.lbl_skilltest';
                break;
            case 'oraltest':
                $query = $this->db->query("SELECT DISTINCT FROM_UNIXTIME(datetest,\"%m-%Y\") AS month, datetest FROM rp_oraltest WHERE type='month' AND userid IN($pupilStr) GROUP BY month ORDER BY datetest DESC LIMIT $cp,$limit");
                $listdata = $query->fetchAll();
                $count = $this->db->query("SELECT DISTINCT FROM_UNIXTIME(datetest,\"%m-%Y\") AS month, datetest FROM rp_oraltest WHERE type='month' AND userid IN($pupilStr) GROUP BY month")->numRows();
                $pointName = 'reportpupil.lbl_oraltest';
                break;
            case 'presentation':
                $query = $this->db->query("SELECT DISTINCT FROM_UNIXTIME(datetest,\"%m-%Y\") AS month, datetest FROM rp_presentation WHERE type='month' AND userid IN($pupilStr) GROUP BY month ORDER BY datetest DESC LIMIT $cp,$limit");
                $listdata = $query->fetchAll();
                $count = $this->db->query("SELECT DISTINCT FROM_UNIXTIME(datetest,\"%m-%Y\") AS month, datetest FROM rp_presentation WHERE type='month' AND userid IN($pupilStr) GROUP BY month")->numRows();
                $pointName = 'reportpupil.lbl_presentation';
                break;
        }
        $this->view->pointname = $pointName;
        $this->view->listdata = $listdata;
        $this->view->painginfo = Helper::paginginfo($count, $limit, $p);
    }

    public function viewskilltestreportAction()
    {
        if (!$this->checkpermission("pupil_report")) return false;
        $classid = $this->request->get("classid", "int");
        $datetest = $this->request->get('datetest', 'int');
        $classobj = Classobj::findFirst($classid);
        $this->view->classobj = $classobj;

        if ($this->request->isPost()) {
            if ($this->request->getPost("actiontype") == "skilltest") { // Update
                try {
                    $datapost = Helper::post_to_array("id,reading,listening,writing,grammar,status");
                    foreach ($datapost['id'] as $key => $val) {
                        if (strlen($datapost['reading'][$val]) > 0) {
                            $skilltestpost = RpSkilltest::findFirst($val);
                            $skilltestpost->reading = $datapost['reading'][$val];
                            $skilltestpost->listening = $datapost['listening'][$val];
                            $skilltestpost->writing = $datapost['writing'][$val];
                            $skilltestpost->grammar = $datapost['grammar'][$val];
                            $skilltestpost->status = $datapost['status'];
                            $skilltestpost->save();
                        }
                    }
                    $this->flash->success($this->view->labelkey['general.lbl_process_success']);
                } catch (Exception $e) {
                    $this->flash->error($e->getMessage());
                }
            }
        }

        $pupilStr = '';
        foreach ($classobj->Pupil as $pupil) $pupilStr .= $pupil->id . ',';
        $pupilStr = $pupilStr ? substr($pupilStr, 0, -1) : 'false';

        $listdata = RpSkilltest::find(array(
            'conditions' => "type='month' AND datetest=$datetest AND userid IN ($pupilStr) ORDER BY userid ASC"
        ));

        $this->view->listdata = $listdata;
    }

    public function vieworaltestreportAction()
    {
        if (!$this->checkpermission("pupil_report")) return false;
        $classid = $this->request->get("classid", "int");
        $datetest = $this->request->get('datetest', 'int');
        $classobj = Classobj::findFirst($classid);
        $this->view->classobj = $classobj;

        if ($this->request->isPost()) {
            if ($this->request->getPost("actiontype") == "oraltest") { // Update
                try {
                    $datapost = Helper::post_to_array("id,pronunciation,vocabular,grammar,fluency,comprehension,status");
                    foreach ($datapost['id'] as $key => $val) {
                        if (strlen($datapost['pronunciation'][$val]) > 0) {
                            $oraltestpost = RpOraltest::findFirst($val);
                            $oraltestpost->pronunciation = $datapost['pronunciation'][$val];
                            $oraltestpost->vocabular = $datapost['vocabular'][$val];
                            $oraltestpost->grammar = $datapost['grammar'][$val];
                            $oraltestpost->fluency = $datapost['fluency'][$val];
                            $oraltestpost->comprehension = $datapost['comprehension'][$val];
                            $oraltestpost->status = $datapost['status'];
                            $oraltestpost->save();
                        }
                    }
                    $this->flash->success($this->view->labelkey['general.lbl_process_success']);
                } catch (Exception $e) {
                    $this->flash->error($e->getMessage());
                }
            }
        }

        $pupilStr = '';
        foreach ($classobj->Pupil as $pupil) $pupilStr .= $pupil->id . ',';
        $pupilStr = $pupilStr ? substr($pupilStr, 0, -1) : 'false';

        $listdata = RpOraltest::find(array(
            'conditions' => "type='month' AND datetest=$datetest AND userid IN ($pupilStr) ORDER BY userid ASC"
        ));

        $this->view->listdata = $listdata;
    }

    public function viewpresentationreportAction()
    {
        if (!$this->checkpermission("pupil_report")) return false;
        $classid = $this->request->get("classid", "int");
        $datetest = $this->request->get('datetest', 'int');
        $classobj = Classobj::findFirst($classid);
        $this->view->classobj = $classobj;

        if ($this->request->isPost()) {
            if ($this->request->getPost("actiontype") == "presentationtest") { // Update
                try {
                    $datapost = Helper::post_to_array("id,organization,language_use,pronunciation,interaction,voice,body_language,visual_aids,status");
                    foreach ($datapost['id'] as $key => $val) {
                        if (strlen($datapost['organization'][$val]) > 0) {
                            $presentationtestpost = RpPresentation::findFirst($val);
                            $presentationtestpost->organization = $datapost['organization'][$val];
                            $presentationtestpost->language_use = $datapost['language_use'][$val];
                            $presentationtestpost->pronunciation = $datapost['pronunciation'][$val];
                            $presentationtestpost->interaction = $datapost['interaction'][$val];
                            $presentationtestpost->voice = $datapost['voice'][$val];
                            $presentationtestpost->body_language = $datapost['body_language'][$val];
                            $presentationtestpost->visual_aids = $datapost['visual_aids'][$val];
                            $presentationtestpost->status = $datapost['status'];
                            $presentationtestpost->save();
                        }
                    }
                    $this->flash->success($this->view->labelkey['general.lbl_process_success']);
                } catch (Exception $e) {
                    $this->flash->error($e->getMessage());
                }
            }
        }

        $pupilStr = '';
        foreach ($classobj->Pupil as $pupil) $pupilStr .= $pupil->id . ',';
        $pupilStr = $pupilStr ? substr($pupilStr, 0, -1) : 'false';

        $listdata = RpPresentation::find(array(
            'conditions' => "type='month' AND datetest=$datetest AND userid IN ($pupilStr) ORDER BY userid ASC"
        ));

        $this->view->listdata = $listdata;
    }

    public function quarterreportAction()
    {
        if (!$this->checkpermission("pupil_report")) return false;
        $classid = $this->request->get("classid", "int");
        $classobj = Classobj::findFirst($classid);
        $this->view->classobj = $classobj;
    }

    public function editquarterreportAction()
    {
        if (!$this->checkpermission("pupil_report")) return false;
        $id = $this->request->get("id", "int");
        $month = $this->request->get('month');
        $year = $this->request->get('year') ? $this->request->get('year', 'int') : date("Y");
        $listquarter = RpQuarter::find(array(
            "conditions" => "userid=:userid:",
            "bind" => array("userid" => $id)
        ));
        $o = User::findFirst($id);
        $this->view->object = $o;
        $this->view->listquarter = $listquarter;
        $this->view->month = $month;
        $this->view->year = $year;
    }

    public function quarterreportdetailAction()
    {
        $months = $this->request->get('month');
        $year = $this->request->get('year');
        $type = $this->request->get('type');
        $userid = $this->request->get('id');
        $classid = $this->request->get('classid');
        $quarterid = $this->request->get('quarterid');
        if ($this->request->isPost()) {
            if ($this->request->getPost("action") == "skilltest")  $this->saveskilltest_quarter();
            else if ($this->request->getPost("action") == "oraltest") $this->saveoraltest_quarter();
            else if ($this->request->getPost("action") == "presentation") $this->savepresentation_quarter();
            else if ($this->request->getPost("action") == "minitest") $this->saveminitest_quarter();
            else if ($this->request->getPost("action") == "attitude") $this->saveattitude_quarter();
            $this->flash->success($this->view->labelkey['general.lbl_process_success']);
            $this->response->redirect("classobj/editquarterreport?id=$userid&classid=$classid");
            return;
        }
        $o = User::findFirst($userid);
        $this->view->object = $o;
        $quarterobject = RpQuarter::findFirst($quarterid);
        foreach ($months as $month)   $datemonth[] = strtotime("01-$month-$year");
        $datemonth_string = implode(",",$datemonth);
        if ($type == "oraltest") {
            $listdata = RpOraltest::find(array(
                "conditions" => "type='quarter' and userid = '$userid' and datetest in($datemonth_string) order by datetest asc"
            ))->toArray();
            if(!$listdata) $listdata = RpOraltest::find(array(
                "conditions" => "type='month' and userid = '$userid' and datetest in($datemonth_string) order by datetest asc"
            ))->toArray();
        } else if ($type == "skilltest") {
            $listdata = RpSkilltest::find(array(
                "conditions" => "type='quarter' and userid = '$userid' and datetest in($datemonth_string) order by datetest asc"
            ))->toArray();
            if(!$listdata) $listdata = RpSkilltest::find(array(
                "conditions" => "type='month' and userid = '$userid' and datetest in($datemonth_string) order by datetest asc"
            ))->toArray();

        } else if ($type == "presentation") {
            $listdata = RpPresentation::find(array(
                "conditions" => "type='quarter' and userid = '$userid' and datetest in($datemonth_string) order by datetest asc"
            ))->toArray();
            if(!$listdata) $listdata = RpPresentation::find(array(
                "conditions" => "type='month' and userid = '$userid' and datetest in($datemonth_string) order by datetest asc"
            ))->toArray();
        }
        else if ($type == "minitest") {
            foreach ($months as $key => $month) {
                $startdate = strtotime("01-$month-$year");
                $enddate = strtotime(date("t-m-Y", strtotime("01-$month-$year")));
                $tmp = RpMinitest::find(array(
                    "conditions" => "type='quarter' and userid = '$userid' and datetest >= $startdate and datetest <= $enddate order by datetest asc"
                ))->toArray();
                if(!$tmp){
                    $tmp = RpMinitest::find(array(
                        "conditions" => "type='day' and userid = '$userid' and datetest >= $startdate and datetest <= $enddate order by datetest asc"
                    ))->toArray();
                    $av = $this->calcaverage($tmp, "point");
                    $listdata[] = array("name" => "$month - $year (1)", "point" => $av[0], "datetest" => strtotime("01-$month-$year"));
                    $listdata[] = array("name" => "$month - $year (2)", "point" => $av[1], "datetest" => strtotime("01-$month-$year"));
                }
                else{
                    $listdata[] = array("name" => "$month - $year (1)", "point" => $tmp[0]['point'], "datetest" => strtotime("01-$month-$year"));
                    $listdata[] = array("name" => "$month - $year (2)", "point" => $tmp[1]['point'], "datetest" => strtotime("01-$month-$year"));
                }
            }
        }
        else if ($type == "attitude") {
            foreach ($months as $key => $month) {
                $startdate = strtotime("01-$month-$year");
                $enddate = strtotime(date("t-m-Y", strtotime("01-$month-$year")));
                $tmp = RpAttitude::find(array(
                    "conditions" => "type='quarter' and userid = '$userid' and datetest >= $startdate and datetest <= $enddate   order by datetest asc"
                ))->toArray();
                if(!$tmp){
                    $tmp = RpAttitude::find(array(
                        "conditions" => "type='day' and userid = '$userid' and datetest >= $startdate and datetest <= $enddate   order by datetest asc"
                    ))->toArray();
                    $attendance = $this->calcaverage($tmp, "attendance");
                    $participation = $this->calcaverage($tmp, "participation");
                    $behavior = $this->calcaverage($tmp, "behavior");
                    $diligence = $this->calcaverage($tmp, "diligence");
                    $listdata[] = array("name" => "$month - $year (1)", "attendance" => $attendance[0], "participation" => $participation[0], "behavior" => $behavior[0], "diligence" => $diligence[0],  "datetest" => strtotime("01-$month-$year"));
                    $listdata[] = array("name" => "$month - $year (2)", "attendance" => $attendance[1], "participation" => $participation[1], "behavior" => $behavior[1], "diligence" => $diligence[1],  "datetest" => strtotime("01-$month-$year"));
                }
                else{
                    $listdata[] = array("name" => "$month - $year (1)", "attendance" => $tmp[0]['attendance'], "participation" => $tmp[0]['participation'], "behavior" => $tmp[0]['behavior'], "diligence" => $tmp[0]['diligence'],  "datetest" => strtotime("01-$month-$year"));
                    $listdata[] = array("name" => "$month - $year (2)", "attendance" => $tmp[1]['attendance'], "participation" => $tmp[1]['participation'], "behavior" => $tmp[1]['behavior'], "diligence" => $tmp[1]['diligence'],  "datetest" => strtotime("01-$month-$year"));
                }
            }
        }
        $htmlx = $this->render_template("shared/quarter/$type", "form", array("listdata" => $listdata, "quarterobj" => $quarterobject));
        $this->view->htmlx = $htmlx;
    }

    public function genexcelmonthlyAction()
    {
        $this->view->setRenderLevel(\Phalcon\Mvc\View::LEVEL_NO_RENDER);
        $classid = $this->request->get("classid");
        $classobj = Classobj::findFirst($classid);
        $obj = $this->request->get("obj");
        $listuser = User::find(array(
            "conditions" => "classid=:classid:",
            "bind" => array("classid" => $classid)
        ));
        flush();
        require $this->config->application['vendorDir'] . 'excel/PHPExcel.php';
        $objPHPExcel = new PHPExcel();
        $objPHPExcel->setActiveSheetIndex(0);
        if ($obj == "skilltest") {
            $objPHPExcel->getActiveSheet()->setTitle("Skill Test");
            $objPHPExcel->getActiveSheet()->SetCellValue('A1', "Ngày nhập dữ liệu");
            $objPHPExcel->getActiveSheet()->SetCellValue('B3', "Tên bài test");
            $objPHPExcel->getActiveSheet()->SetCellValue('A2', "Họ và tên");
            $objPHPExcel->getActiveSheet()->SetCellValue('B2', "Mã học sinh");
            $objPHPExcel->getActiveSheet()->SetCellValue('C2', "Reading");
            $objPHPExcel->getActiveSheet()->SetCellValue('D2', "Listening");
            $objPHPExcel->getActiveSheet()->SetCellValue('E2', "Writing");
            $objPHPExcel->getActiveSheet()->SetCellValue('F2', "Grammar");
            $rowCount = 3;
            foreach ($listuser as $item) {
                $objPHPExcel->getActiveSheet()->SetCellValue('A' . $rowCount, $item->firstname . " " . $item->lastname);
                $objPHPExcel->getActiveSheet()->SetCellValue('B' . $rowCount, $item->id);
                $rowCount++;
            }
        } else if ($obj == "oraltest") {
            $objPHPExcel->getActiveSheet()->setTitle("Oral Test");
            $objPHPExcel->getActiveSheet()->SetCellValue('A1', "Ngày nhập dữ liệu");
            $objPHPExcel->getActiveSheet()->SetCellValue('B3', "Tên bài test");
            $objPHPExcel->getActiveSheet()->SetCellValue('A2', "Họ và tên");
            $objPHPExcel->getActiveSheet()->SetCellValue('B2', "Mã học sinh");
            $objPHPExcel->getActiveSheet()->SetCellValue('C2', "Pronunciation");
            $objPHPExcel->getActiveSheet()->SetCellValue('D2', "Vocabulary");
            $objPHPExcel->getActiveSheet()->SetCellValue('E2', "Grammar");
            $objPHPExcel->getActiveSheet()->SetCellValue('F2', "Fluency");
            $objPHPExcel->getActiveSheet()->SetCellValue('G2', "Comprehension");
            $objPHPExcel->getActiveSheet()->SetCellValue('H2', "Pronunciation Note");
            $objPHPExcel->getActiveSheet()->SetCellValue('I2', "Vocabulary Note");
            $objPHPExcel->getActiveSheet()->SetCellValue('J2', "Grammar Note");
            $objPHPExcel->getActiveSheet()->SetCellValue('K2', "Fluency Note");
            $objPHPExcel->getActiveSheet()->SetCellValue('L2', "Comprehension Note");
            $rowCount = 3;
            foreach ($listuser as $item) {
                $objPHPExcel->getActiveSheet()->SetCellValue('A' . $rowCount, $item->firstname . " " . $item->lastname);
                $objPHPExcel->getActiveSheet()->SetCellValue('B' . $rowCount, $item->id);
                $rowCount++;
            }


        } else if ($obj == "presentation") {
            $objPHPExcel->getActiveSheet()->setTitle("Presentation");
            $objPHPExcel->getActiveSheet()->SetCellValue('A1', "Ngày nhập dữ liệu");
            $objPHPExcel->getActiveSheet()->SetCellValue('A2', "Họ và tên");
            $objPHPExcel->getActiveSheet()->SetCellValue('B2', "Mã học sinh");
            $objPHPExcel->getActiveSheet()->SetCellValue('C2', "Organization");
            $objPHPExcel->getActiveSheet()->SetCellValue('D2', "Language use");
            $objPHPExcel->getActiveSheet()->SetCellValue('E2', "Pronunciation");
            $objPHPExcel->getActiveSheet()->SetCellValue('F2', "Interaction");
            $objPHPExcel->getActiveSheet()->SetCellValue('G2', "Voice");
            $objPHPExcel->getActiveSheet()->SetCellValue('H2', "Body language");
            $objPHPExcel->getActiveSheet()->SetCellValue('I2', "Visual aids");
            $objPHPExcel->getActiveSheet()->SetCellValue('J2', "Note");
            $rowCount = 3;
            foreach ($listuser as $item) {
                $objPHPExcel->getActiveSheet()->SetCellValue('A' . $rowCount, $item->firstname . " " . $item->lastname);
                $objPHPExcel->getActiveSheet()->SetCellValue('B' . $rowCount, $item->id);
                $rowCount++;
            }


        }
        for ($col = 'A'; $col !== 'Z'; $col++) {
            $objPHPExcel->getActiveSheet()->getColumnDimension($col)->setAutoSize(true);
        }
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
        ob_end_clean();
        header("Content-Type: application/vnd.ms-excel");
        header("Content-Disposition: attachment; filename=\"Bao_cao_thang_lop_{$classobj->name}_$obj.xls\"");
        header("Pragma: no-cache");
        header("Expires: 0");
        $objWriter->save('php://output');
    }

    /*Function Save Quarter Report*/
    private function saveskilltest_quarter()
    {
        $months = $this->request->get('month');
        $year = $this->request->get('year');
        foreach ($months as $month)   $datemonth[] = strtotime("01-$month-$year");
        $datemonth_string = implode(",",$datemonth);
        $quarterid = $this->request->get("quarterid");
        $userid = $this->request->get("id");
        $datapost = Helper::post_to_array("rpitem,reading,listening,writing,grammar,name,datetest,content");
        $list = RpSkilltest::find(array(
            "conditions" => "type='quarter' AND datetest in($datemonth_string) AND quarterid = :quarterid:",
            "bind" => array("quarterid" => $quarterid)
        ));
        if ($list) $list->delete();
        foreach ($datapost['rpitem'] as $key => $item) {
            $object = new RpSkilltest();
            $object->type = "quarter";
            $object->quarterid = $quarterid;
            $object->userid = $userid;
            $object->name = $datapost['name'][$key];
            $object->datetest = $datapost['datetest'][$key];
            $object->datecreate = time();
            $object->grammar = $datapost['grammar'][$key];
            $object->listening = $datapost['listening'][$key];
            $object->reading = $datapost['reading'][$key];
            $object->writing = $datapost['writing'][$key];
            $object->status = 1;
            $object->usercreate = $this->userinfo['id'];
            $object->save();
        }
        $rpquarter = RpQuarter::findFirst($quarterid);
        if ($rpquarter->id > 0) {
            $rpquarter->skilltest_note = $datapost['content'];
            $rpquarter->save();
        }
    }

    private function saveoraltest_quarter()
    {
        $months = $this->request->get('month');
        $year = $this->request->get('year');
        foreach ($months as $month)   $datemonth[] = strtotime("01-$month-$year");
        $datemonth_string = implode(",",$datemonth);
        $quarterid = $this->request->get("quarterid");
        $userid = $this->request->get("id");
        $datapost = Helper::post_to_array("rpitem,comprehension,note_comprehension,fluency,note_fluency,grammar,note_grammar,vocabular,note_vocabular,pronunciation,note_pronunciation,name,datetest,content");
        $list = RpOraltest::find(array(
            "conditions" => "type='quarter' AND datetest in($datemonth_string) AND quarterid = :quarterid:",
            "bind" => array("quarterid" => $quarterid)
        ));
        if ($list) $list->delete();
        foreach ($datapost['rpitem'] as $key => $item) {
            $object = new RpOraltest();
            $object->type = "quarter";
            $object->quarterid = $quarterid;
            $object->userid = $userid;
            $object->name = $datapost['name'][$key];
            $object->datetest = $datapost['datetest'][$key];
            $object->datecreate = time();
            $object->comprehension = $datapost['comprehension'][$key];
            $object->note_comprehension = $datapost['note_comprehension'][$key];
            $object->fluency = $datapost['fluency'][$key];
            $object->note_fluency = $datapost['note_fluency'][$key];
            $object->grammar = $datapost['grammar'][$key];
            $object->note_grammar = $datapost['note_grammar'][$key];
            $object->vocabular = $datapost['vocabular'][$key];
            $object->note_vocabulary = $datapost['note_vocabular'][$key];
            $object->pronunciation = $datapost['pronunciation'][$key];
            $object->note_pronunciation = $datapost['note_pronunciation'][$key];
            $object->status = 1;
            $object->usercreate = $this->userinfo['id'];
            $object->save();
        }
        $rpquarter = RpQuarter::findFirst($quarterid);
        if ($rpquarter->id > 0) {
            $rpquarter->oraltest_note = $datapost['content'];
            $rpquarter->save();
        }
    }

    private function savepresentation_quarter()
    {
        $months = $this->request->get('month');
        $year = $this->request->get('year');
        foreach ($months as $month)   $datemonth[] = strtotime("01-$month-$year");
        $datemonth_string = implode(",",$datemonth);
        $quarterid = $this->request->get("quarterid");
        $userid = $this->request->get("id");
        $datapost = Helper::post_to_array("rpitem,visual_aids,body_language,voice,interaction,pronunciation,language_use,organization,name,datetest,content");
        $list = RpPresentation::find(array(
            "conditions" => "type='quarter' AND datetest in($datemonth_string) AND quarterid = :quarterid:",
            "bind" => array("quarterid" => $quarterid)
        ));
        if ($list) $list->delete();
        foreach ($datapost['rpitem'] as $key => $item) {
            $object = new RpPresentation();
            $object->type = "quarter";
            $object->quarterid = $quarterid;
            $object->userid = $userid;
            $object->name = $datapost['name'][$key];
            $object->datetest = $datapost['datetest'][$key];
            $object->datecreate = time();
            $object->visual_aids = $datapost['visual_aids'][$key];
            $object->body_language = $datapost['body_language'][$key];
            $object->voice = $datapost['voice'][$key];
            $object->interaction = $datapost['interaction'][$key];
            $object->pronunciation = $datapost['pronunciation'][$key];
            $object->language_use = $datapost['language_use'][$key];
            $object->organization = $datapost['organization'][$key];
            $object->status = 1;
            $object->usercreate = $this->userinfo['id'];
            $object->save();
        }
        $rpquarter = RpQuarter::findFirst($quarterid);
        if ($rpquarter->id > 0) {
            $rpquarter->presentation_note = $datapost['content'];
            $rpquarter->save();
        }
    }

    private function calcaverage($listdata, $keyel)
    {
        if (count($listdata) <= 0) return array(0 => 0, 1 => 0);
        if (count($listdata) % 2 == 0) $cue = (count($listdata) / 2);
        else $cue = floor((count($listdata) / 2)) + 1;
        for ($i = 0; $i <= $cue; $i++) $l1[] = $listdata[$i][$keyel];
        for ($i = $cue; $i <= count($listdata) - 1; $i++) $l2[] = $listdata[$i][$keyel];

        $av1 = number_format(Helper::average_byarray($l1), 1, '.', ',');
        $av2 = number_format(Helper::average_byarray($l2), 1, '.', ',');
        return array(0 => $av1, 1 => $av2);
    }

    private function saveminitest_quarter()
    {
        $months = $this->request->get('month');
        $year = $this->request->get('year');
        foreach ($months as $month)   $datemonth[] = strtotime("01-$month-$year");
        $datemonth_string = implode(",",$datemonth);
        $quarterid = $this->request->get("quarterid");
        $userid = $this->request->get("id");
        $datapost = Helper::post_to_array("rpitem,point,name,datetest,content");
        $list = RpMinitest::find(array("conditions" => "type='quarter' AND datetest in($datemonth_string) AND quarterid = $quarterid"));
        if ($list) $list->delete();
        foreach ($datapost['rpitem'] as $key => $item) {
            $object = new RpMinitest();
            $object->type = "quarter";
            $object->quarterid = $quarterid;
            $object->userid = $userid;
            $object->name = $datapost['name'][$key];
            $object->datetest = $datapost['datetest'][$key];
            $object->datecreate = time();
            $object->point = $datapost['point'][$key];
            $object->status = 1;
            $object->usercreate = $this->userinfo['id'];
            $object->save();
        }
        $rpquarter = RpQuarter::findFirst($quarterid);
        if ($rpquarter->id > 0) {
            $rpquarter->minitest_note = $datapost['content'];
            $rpquarter->save();
        }
    }

    private function saveattitude_quarter()
    {
        $months = $this->request->get('month');
        $year = $this->request->get('year');
        foreach ($months as $month)   $datemonth[] = strtotime("01-$month-$year");
        $datemonth_string = implode(",",$datemonth);
        $quarterid = $this->request->get("quarterid");
        $userid = $this->request->get("id");
        $datapost = Helper::post_to_array("rpitem,attendance,participation,behavior,diligence,name,datetest,content");
        $list = RpAttitude::find(array("conditions" => "type='quarter' AND datetest in($datemonth_string) AND quarterid = $quarterid"));
        if ($list) $list->delete();
        foreach ($datapost['rpitem'] as $key => $item) {
            $object = new RpAttitude();
            $object->type = "quarter";
            $object->quarterid = $quarterid;
            $object->userid = $userid;
            $object->name = $datapost['name'][$key];
            $object->datetest = $datapost['datetest'][$key];
            $object->datecreate = time();
            $object->attendance = $datapost['attendance'][$key];
            $object->participation = $datapost['participation'][$key];
            $object->behavior = $datapost['behavior'][$key];
            $object->diligence = $datapost['diligence'][$key];
            $object->status = 1;
            $object->usercreate = $this->userinfo['id'];
            $object->save();
        }
        $rpquarter = RpQuarter::findFirst($quarterid);
        if ($rpquarter->id > 0) {
            $rpquarter->attitude_note = $datapost['content'];
            $rpquarter->save();
        }
    }
}