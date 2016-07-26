<?php
namespace Webapp\Backend\Controllers;
class ReportpupilController extends ControllerBase
{
    public function initialize()
    {
        $this->modulename = "reportpupil";
        $this->view->activesidebar = "/pupil/index";
        parent::initialize();
    }

    public function indexAction()
    {
        if (!$this->checkpermission("pupil_report")) return false;
        $limit = 20;
        $p = $this->request->get("p");
        if ($p <= 1) $p = 1;
        $cp = ($p - 1) * $limit;

        $id = $this->request->get("id");
        $q = $this->request->getQuery("q", "string");
        $lang = $this->request->getQuery('lang', 'string');
        $status = $this->request->getQuery("status");

        $query = "userid=$id";
        $query .= $q ? " and name LIKE '%" . $q . "%'" : '';
        $query .= $lang ? " and lang = '$lang'" : '';
        $query .= $status ? " and status=$status" : ' and status < 3';

        $listdata = ReportPupil::find(array(
            "conditions" => $query,
            "order" => "id desc",
            "limit" => $limit,
            "offset" => $cp
        ));

        $this->view->langlist = Language::lang();
        $this->view->q = $q;
        $this->view->userinfo = User::findFirst(array('conditions' => "id=$id"));
        $this->view->listdata = $listdata;
        $this->view->painginfo = Helper::paginginfo(ReportPupil::count($query), $limit, $p);
        $this->view->backurl = strlen($this->request->getHTTPReferer())<=0? $this->view->activesidebar: $this->request->getHTTPReferer();
    }

    public function formAction()
    {
        if (!$this->checkpermission("pupil_report")) return false;
        $id = $this->request->get("id");
        $userid = $this->request->get("userid");

        if ($this->request->isPost()) {
            try {
                $datapost = Helper::post_to_array("name,status,content,skilltest_comment,oraltest_comment,presentation_comment,attitude_comment,minitest_comment");
                if (!$this->checkpermission("pupil_reportupdatestatus",false)) $datapost['status']=0;
                if ($id > 0) { // Update
                    $o = ReportPupil::findFirst($id);
                } else { //insert
                    $o = new ReportPupil();
                    $o->id = time();
                    $datapost['datecreate'] = time();
                    $datapost['usercreate'] = $this->userinfo['id'];
                    $datapost['userid'] = $userid;
                    $datapost['lang'] = 'en_EN';
                }
                $o->map_object($datapost);
                $o->save();
                $this->flash->success($this->view->labelkey['general.lbl_process_success']);
                if($_POST['backurl']) header('Location: ' . $_POST['backurl']);
            } catch (Exception $e) {
                $this->flash->error($e->getMessage());
            }
        }
        if (!empty($id)) $o = ReportPupil::findFirst($id);
        $this->view->object = $o;
        $this->view->userinfo = User::findFirst(array('conditions' => "id=$userid"));
        $this->view->langlist = Language::lang();
        if($this->request->get("back")==1) $this->view->backurl = $_SERVER['HTTP_REFERER'];
        $this->view->backurl = strlen($this->request->getHTTPReferer())<=0? $this->view->activesidebar: $this->request->getHTTPReferer();
    }

    public function deleteAction()
    {
        if (!$this->checkpermission("pupil_report")) return false;
        $id = $this->request->get("id");
        $o = ReportPupil::findFirst($id);
        $o->status=3;
        $o->save();
        $this->response->redirect($this->request->getHTTPReferer());
    }

    /***
     * Generate Template layout
     */
    public function gettemplateAction(){
        $this->view->setRenderLevel(\Phalcon\Mvc\View::LEVEL_NO_RENDER);
        $type = $this->request->get("type");
        $chtml = $this->render_template("shared", "$type/form",(object)array("datetest"=>time()));
        echo $chtml;
    }
    public function skilltestAction(){
        if (!$this->checkpermission("pupil_report")) return false;
        $userid = $this->request->get("userid");
        $ntfid = $this->request->get("id");
        try{
            if($this->request->isPost()){
                $datapost = Helper::post_to_array("name,reading,listening,writing,grammar,datetest");
                $o = RpSkilltest::find(array(
                    "conditions" => "notifyid = $ntfid"
                ));
                if($o) $o->delete();
                foreach($datapost['name'] as $key=>$val){
                    $skilltestpost = new RpSkilltest();
                    $skilltestpost->name = $val;
                    $skilltestpost->reading = $datapost['reading'][$key];
                    $skilltestpost->listening = $datapost['listening'][$key];
                    $skilltestpost->writing = $datapost['writing'][$key];
                    $skilltestpost->grammar = $datapost['grammar'][$key];
                    $skilltestpost->notifyid = $ntfid;
                    $skilltestpost->sorts = $key;
                    $skilltestpost->status = 1;
                    $skilltestpost->datecreate = time();
                    $skilltestpost->datetest = strtotime($datapost['datetest'][$key]);
                    $skilltestpost->usercreate = $this->userinfo['id'];
                    $skilltestpost->userid = $userid;
                    $skilltestpost->save();
                }
                $this->flash->success($this->view->labelkey['general.lbl_process_success']);
                $this->response->redirect("reportpupil/index?id=$userid");
                return false;
            }

            $query = "notifyid = $ntfid";
            $listdata = RpSkilltest::find(array(
                "conditions" => $query,
                "order" => "sorts asc"
            ));
            $listdata = $listdata->toArray();
            $chtml = "";
            foreach($listdata as $item){
                if($item['datetest']<=0) $item['datetest'] = time();
                $chtml .= $this->render_template("shared", "skilltest/form",(object)$item);
            }
            $this->view->form_html = $chtml;
        }
        catch(Exception $e){
            $this->flash->error($e->getMessage());
        }
        $this->view->backurl = strlen($this->request->getHTTPReferer())<=0? $this->view->activesidebar: $this->request->getHTTPReferer();
    }

    public function oraltestAction(){
        if (!$this->checkpermission("pupil_report")) return false;
        $userid = $this->request->get("userid");
        $ntfid = $this->request->get("id");
        try{
            if($this->request->isPost()){
                $datapost = Helper::post_to_array("name,comprehension,fluency,grammar,vocabular,pronunciation,datetest");
                $o = RpOraltest::find(array(
                    "conditions" => "notifyid = $ntfid"
                ));
                if($o) $o->delete();
                foreach($datapost['name'] as $key=>$val){
                    $oraltestpost = new RpOraltest();
                    $oraltestpost->name = $val;
                    $oraltestpost->comprehension = $datapost['comprehension'][$key];
                    $oraltestpost->fluency = $datapost['fluency'][$key];
                    $oraltestpost->grammar = $datapost['grammar'][$key];
                    $oraltestpost->vocabular = $datapost['vocabular'][$key];
                    $oraltestpost->pronunciation = $datapost['pronunciation'][$key];
                    $oraltestpost->notifyid = $ntfid;
                    $oraltestpost->sorts = $key;
                    $oraltestpost->status = 1;
                    $oraltestpost->datetest = strtotime($datapost['datetest'][$key]);
                    $oraltestpost->datecreate = time();
                    $oraltestpost->usercreate = $this->userinfo['id'];
                    $oraltestpost->userid = $userid;
                    $oraltestpost->save();
                }
                $this->flash->success($this->view->labelkey['general.lbl_process_success']);
                $this->response->redirect("reportpupil/index?id=$userid");
                return false;
            }

            $query = "notifyid = $ntfid";
            $listdata = RpOraltest::find(array(
                "conditions" => $query,
                "order" => "sorts asc"
            ));
            $listdata = $listdata->toArray();
            $chtml = "";
            foreach($listdata as $item){
                if($item['datetest']<=0) $item['datetest'] = time();
                $chtml .= $this->render_template("shared", "oraltest/form",(object)$item);
            }
            $this->view->form_html = $chtml;
        }
        catch(Exception $e){
            $this->flash->error($e->getMessage());
        }
        $this->view->backurl = strlen($this->request->getHTTPReferer())<=0? $this->view->activesidebar: $this->request->getHTTPReferer();
    }

    public function presentationAction(){
        if (!$this->checkpermission("pupil_report")) return false;
        $userid = $this->request->get("userid");
        $ntfid = $this->request->get("id");
        try{
            if($this->request->isPost()){
                $datapost = Helper::post_to_array("name,visual_aids,body_language,voice,interaction,pronunciation,language_use,organization,datetest");
                $o = RpPresentation::find(array(
                    "conditions" => "notifyid = $ntfid"
                ));
                if($o) $o->delete();
                foreach($datapost['name'] as $key=>$val){
                    $presentationpost = new RpPresentation();
                    $presentationpost->name = $val;
                    $presentationpost->visual_aids = $datapost['visual_aids'][$key];
                    $presentationpost->body_language = $datapost['body_language'][$key];
                    $presentationpost->voice = $datapost['voice'][$key];
                    $presentationpost->interaction = $datapost['interaction'][$key];
                    $presentationpost->pronunciation = $datapost['pronunciation'][$key];
                    $presentationpost->language_use = $datapost['language_use'][$key];
                    $presentationpost->organization = $datapost['organization'][$key];
                    $presentationpost->notifyid = $ntfid;
                    $presentationpost->sorts = $key;
                    $presentationpost->status = 1;
                    $presentationpost->datetest = strtotime($datapost['datetest'][$key]);
                    $presentationpost->datecreate = time();
                    $presentationpost->usercreate = $this->userinfo['id'];
                    $presentationpost->userid = $userid;
                    $presentationpost->save();
                }
                $this->flash->success($this->view->labelkey['general.lbl_process_success']);
                $this->response->redirect("reportpupil/index?id=$userid");
                return false;
            }

            $query = "notifyid = $ntfid";
            $listdata = RpPresentation::find(array(
                "conditions" => $query,
                "order" => "sorts asc"
            ));
            $listdata = $listdata->toArray();
            $chtml = "";
            foreach($listdata as $item){
                if($item['datetest']<=0) $item['datetest'] = time();
                $chtml .= $this->render_template("shared", "presentation/form",(object)$item);
            }
            $this->view->form_html = $chtml;
        }
        catch(Exception $e){
            $this->flash->error($e->getMessage());
        }
        $this->view->backurl = strlen($this->request->getHTTPReferer())<=0? $this->view->activesidebar: $this->request->getHTTPReferer();
    }
    public function attitudeAction(){
        if (!$this->checkpermission("pupil_report")) return false;
        $userid = $this->request->get("userid");
        $ntfid = $this->request->get("id");
        try{
            if($this->request->isPost()){
                $datapost = Helper::post_to_array("month,attendance,participation,behavior,diligence,datetest");
                $o = RpAttitude::find(array(
                    "conditions" => "notifyid = $ntfid"
                ));
                if($o) $o->delete();
                foreach($datapost['month'] as $key=>$val){
                    $attitudepost = new RpAttitude();
                    $attitudepost->month = $val;
                    $attitudepost->attendance = $datapost['attendance'][$key];
                    $attitudepost->participation = $datapost['participation'][$key];
                    $attitudepost->behavior = $datapost['behavior'][$key];
                    $attitudepost->diligence = $datapost['diligence'][$key];
                    $attitudepost->notifyid = $ntfid;
                    $attitudepost->sorts = $key;
                    $attitudepost->status = 1;
                    $attitudepost->datetest = strtotime($datapost['datetest'][$key]);
                    $attitudepost->datecreate = time();
                    $attitudepost->usercreate = $this->userinfo['id'];
                    $attitudepost->userid = $userid;
                    $attitudepost->save();
                }
                $this->flash->success($this->view->labelkey['general.lbl_process_success']);
                $this->response->redirect("reportpupil/index?id=$userid");
                return false;
            }

            $query = "notifyid = $ntfid";
            $listdata = RpAttitude::find(array(
                "conditions" => $query,
                "order" => "sorts asc"
            ));
            $listdata = $listdata->toArray();
            $chtml = "";
            foreach($listdata as $item){
                if($item['datetest']<=0) $item['datetest'] = time();
                $chtml .= $this->render_template("shared", "attitude/form",(object)$item);
            }
            $this->view->form_html = $chtml;
        }
        catch(Exception $e){
            $this->flash->error($e->getMessage());
        }
        $this->view->backurl = strlen($this->request->getHTTPReferer())<=0? $this->view->activesidebar: $this->request->getHTTPReferer();
    }
    public function minitestAction(){
        if (!$this->checkpermission("pupil_report")) return false;
        $userid = $this->request->get("userid");
        $ntfid = $this->request->get("id");
        try{
            if($this->request->isPost()){
                $datapost = Helper::post_to_array("name,note_name,point,datetest");
                $o = RpMinitest::find(array(
                        "conditions" => "notifyid = $ntfid"
                ));
                if($o) $o->delete();
                foreach($datapost['datetest'] as $key=>$val){
                    $minitestpost = new RpMinitest();
                    $minitestpost->name = $val;
                    $minitestpost->point = $datapost['point'][$key];
                    $minitestpost->notifyid = $ntfid;
                    $minitestpost->sorts = $key;
                    $minitestpost->status = 1;
                    $minitestpost->datetest = strtotime($val);
                    $minitestpost->datecreate = time();
                    $minitestpost->usercreate = $this->userinfo['id'];
                    $minitestpost->userid = $userid;
                    $minitestpost->save();
                }
                $this->flash->success($this->view->labelkey['general.lbl_process_success']);
                $this->response->redirect("reportpupil/index?id=$userid");
                return false;
            }

            $query = "notifyid = $ntfid";
            $listdata = RpMinitest::find(array(
                    "conditions" => $query,
                    "order" => "sorts asc"
            ));
            $listdata = $listdata->toArray();
            $chtml = "";
            foreach($listdata as $item){
                if($item['datetest']<=0) $item['datetest'] = time();
                $chtml .= $this->render_template("shared", "minitest/form",(object)$item);
            }
            $this->view->form_html = $chtml;
        }
        catch(Exception $e){
            $this->flash->error($e->getMessage());
        }
        $this->view->backurl = strlen($this->request->getHTTPReferer())<=0? $this->view->activesidebar: $this->request->getHTTPReferer();
    }
    public function previewchartAction(){
        if (!$this->checkpermission("pupil_report")) return false;
        $userid = $this->request->get("userid");
        $ntfid = $this->request->get("id");
        $o = ReportPupil::findFirst($ntfid);
        $this->view->object = $o;

        /*SkillTest*/
        $skilltestdata = RpSkilltest::find(array(
            "conditions" => "notifyid = $ntfid"
        ));
        $skilltestdata = $skilltestdata->toArray();
        $chartColor = array('#4ec9b4','#868bb8','#ff834d','#ffd200','#81cdea','#c3c3a5','#5c9ddc','#93d5a6','#ff81af','#ffb77c','#7eafb6');
        foreach($skilltestdata as $key=>$val){
            $skilltestdata[$key]['color'] = Helper::randomcolor();
            $skilltestdata[$key]['color'] = $chartColor[$key];
        }
        $this->view->skilltestdata = $skilltestdata;
        /*OralTest*/
        $oraltestdata = RpOraltest::find(array(
            "conditions" => "notifyid = $ntfid"
        ));
        $oraltestdata = $oraltestdata->toArray();
        $chartColor = array('#c3c3a5','#5c9ddc','#93d5a6','#ff81af','#ffb77c','#7eafb6','#4ec9b4','#868bb8','#ff834d','#ffd200','#81cdea');
        foreach($oraltestdata as $key=>$val){
            $oraltestdata[$key]['color'] = Helper::randomcolor();
            $oraltestdata[$key]['color'] = $chartColor[$key];
        }
        $this->view->oraltestdata = $oraltestdata;
        /*Attitude*/
        $attitudedata = RpAttitude::find(array(
            "conditions" => "notifyid = $ntfid"
        ));
        $attitudedata = $attitudedata->toArray();
        $this->view->attitudedata = $attitudedata;
        /*Presentation*/
        $presentationdata = RpPresentation::find(array(
            "conditions" => "notifyid = $ntfid"
        ));
        $presentationdata = $presentationdata->toArray();
        $chartColor = array('#3698A1','#79D2A9','#eca539','#eca539','#87aa66','#88abad','#88abad','#69c6ff','#ff81af','#ffb77c','#7eafb6');
        foreach($presentationdata as $key=>$val){
            $presentationdata[$key]['color'] = Helper::randomcolor();
            $presentationdata[$key]['color'] = $chartColor[$key];
            $presentationdata[$key]['average'] = Helper::average($val['visual_aids'],$val['body_language'],$val['voice'],$val['interaction'],$val['pronunciation'],$val['language_use'],$val['organization']);

        }
        $this->view->presentationdata = $presentationdata;
        /*MiniTest*/
        $minitestdata = RpMinitest::find(array(
            "conditions" => "notifyid = $ntfid"
        ));
        $minitestdata = $minitestdata->toArray();
        $this->view->minitestdata = $minitestdata;
        $this->view->backurl = strlen($this->request->getHTTPReferer())<=0? $this->view->activesidebar: $this->request->getHTTPReferer();
    }
}
?>