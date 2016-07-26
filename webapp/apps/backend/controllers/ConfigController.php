<?php
namespace Webapp\Backend\Controllers;
class ConfigController extends ControllerBase
{
    public function initialize()
    {
        $this->modulename = "config";
        parent::initialize();
    }

    public function imageAction(){
        if (!$this->checkpermission("config_update")) return false;
        $this->view->activesidebar = "/config/image";
        if($this->request->isPost()) {
            try {
                $fbthumb = $this->upload_image_key('fbthumb', 'fb-thumb');
                $articlecover = $this->upload_image_key('articlecover', 'article-cover');
                $categorycover = $this->upload_image_key('categorycover', 'category-cover');
                $dashboardcover = $this->upload_image_key('dashboardcover', 'dashboard-cover');
                $eventcover = $this->upload_image_key('eventcover', 'event-cover');
                $searchcover = $this->upload_image_key('searchcover', 'search-cover');
                $this->flash->success($this->culture['config.lbl_updatesucc']);
            } catch (Exception $e) {
                $this->flash->error($e->getMessage());
            }
        }
    }

    public function upload_image_key($key,$imagename)
    {
        if (!isset($_FILES["$key"])) return null;
        //$target_dir = getcwd() . "/";
        //$target_dir = "/home/wsi.vn/public_html/public/";
        $target_dir = $this->config->media->dir;
        $folder = "uploads/default-image";
        $listallow = array("jpg", "jpeg", "png", "gif", "mp3", "mp4","xlsx","xls");
        $fileParts = strtolower(pathinfo($_FILES[$key]['name'], PATHINFO_EXTENSION));
        if (!in_array($fileParts, $listallow)) return null;
        $folder_name = '/';
        if (!file_exists($target_dir . $folder . $folder_name)) mkdir($target_dir . $folder . $folder_name, 0777, true);
        $target_file = $folder . $folder_name . $imagename.'.jpg';
        if (file_exists($target_file)) unlink($target_file);
        if ($_FILES["$key"]["size"] <= 0) return null;

        move_uploaded_file($_FILES["$key"]["tmp_name"], $target_dir . $target_file);
        return $target_file;
    }
    public function noteAction(){
        $this->view->activesidebar = "/config/note";
        if($this->request->isPost()){
            ConfigNotecircle::find()->delete();
            $datapost = Helper::post_to_array("keys,name,contents");
            foreach($datapost['keys'] as $key=>$val){
                $cfg = new ConfigNotecircle();
                $cfg->keys = $val;
                $cfg->name = $datapost['name'][$key];
                $cfg->contents = $datapost['contents'][$key];
                $cfg->save();
            }
            $this->flash->success($this->view->labelkey['general.lbl_process_success']);
        }
        $cursor = ConfigNotecircle::find();        
        foreach($cursor as $item) $confignote[$item->keys] = $item;
        $this->view->object = $confignote;
    }
}