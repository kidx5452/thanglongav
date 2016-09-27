<?php
/**
 * Created by PhpStorm.
 * User: VietNH
 * Date: 8/11/2016
 * Time: 3:49 PM
 */
namespace Webapp\Backend\Controllers;
use Webapp\Backend\Models\Configs;

class ConfigsController extends ControllerBase
{
    public function initialize()
    {
        global $config;
        $this->modulename = "configs";
        $this->view->activesidebar = $config->application->baseUri."configs/index";
        parent::initialize();
    }

    public function indexAction()
    {
        
        if($this->request->isPost()){
            Configs::find()->delete();
            $array = array("facebook","google","youtube","email","work","footer","hotline");
            foreach($array as $item){
                $op = new Configs();
                $op->keys = $item;
                $op->name = $item;
                $op->contents = $this->request->getPost($item);
                $op->save();
            }
            $this->flash->success("Success");
        }
        $configs = Configs::find()->toArray();
        foreach($configs as $key=>$item){
            $configs[$item['keys']] = $item;
        }
        $this->view->configs = $configs;

    }


}