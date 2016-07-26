<?php
namespace Webapp\Backend\Controllers;
/**
 * Created by PhpStorm.
 * User: ViviPro
 * Date: 5/6/2016
 * Time: 11:07 AM
 */
class GeneralmanageController extends ControllerBase
{
    public function classAction(){

    }
    public function gettemplateAction(){
        $this->view->setRenderLevel(\Phalcon\Mvc\View::LEVEL_NO_RENDER);
        $file = $this->request->get("file");
        $chtml = $this->render_template("generalmanage", "template/$file",(object)array("datetest"=>time()));
        echo $chtml;
    }
}