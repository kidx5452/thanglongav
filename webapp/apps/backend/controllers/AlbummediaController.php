<?php
namespace Webapp\Backend\Controllers;

use Webapp\Backend\Models\Albummedia;
use Webapp\Backend\Models\AlbummediaDetail;
use Webapp\Backend\Models\AlbumTag;
use Webapp\Backend\Models\Classobj;
use Webapp\Backend\Models\User;
use Webapp\Backend\Utility\Helper;
use Webapp\Backend\Utility\SimpleImage;

class AlbummediaController extends ControllerBase
{
    public function initialize()
    {
        global $config;
        $this->modulename = "albummedia";
        $this->view->activesidebar = $config->application->baseUri."albummedia/index";
        parent::initialize();
    }

    public function indexAction()
    {
        if (!$this->checkpermission("albummedia_view")) return false;
        $limit = 20;
        $p = $this->request->get("p");
        if ($p <= 1) $p = 1;
        $cp = ($p - 1) * $limit;

        $query = "1=1";
        $q = $this->request->getQuery("q", "string");
        $status = $this->request->get("status");
        $type = $this->request->getQuery('type', 'string');
        if ($q) $query .= " AND name LIKE '%" . $q . "%'";
        if (isset($status) && $status<2) $query .= " AND status = $status";
        if($type) $query .= " AND type='$type'";

        $listdata = Albummedia::find(
            array(
                "conditions" => $query,
                "order" => "id DESC",
                "limit" => $limit,
                "offset" => $cp
            )
        );

        $this->view->q = $q;
        $this->view->listdata = $listdata;
        $this->view->painginfo = Helper::paginginfo(Albummedia::count($query), $limit, $p);
    }

    public function addAction()
    {
        $id = $this->request->get("id");
        $o = Albummedia::findFirst($id);
        $this->view->object = $o;

        if ($this->request->isPost()) {
            try {
                // Insert Video vao Album
                if($o->type == 'video') {
                    $listName = $this->request->getPost('name');
                    $listLink = $this->request->getPost('link');
                    foreach($listLink as $key=>$value){
                        try {
                            $datapost['albumid'] = $o->id;
                            $datapost['name'] = $listName[$key];
                            $datapost['content'] = $listLink[$key];
                            $datapost['datecreate'] = time();
                            $datapost['usercreate'] = $this->userinfo['id'];
                            $datapost['status'] = 1;
                            $vid = new AlbummediaDetail();
                            $vid->map_object($datapost);
                            $vid->save();
                        } catch (\Exception $e) {
                            $this->flash->error($e->getMessage());
                        }
                    }
                    $this->flash->success($this->view->labelkey['general.lbl_process_success']);
                }
                // Insert Anh vao Album
                else {

                }

            } catch (\Exception $e) {
                $this->flash->error($e->getMessage());
            }
        }

        $limit = 20;
        $p = $this->request->get("p");
        if ($p <= 1) $p = 1;
        $cp = ($p - 1) * $limit;

        $query = "albumid='{$o->id}'";
        $listdata = AlbummediaDetail::find(
            array(
                "conditions" => $query,
                "order" => "id DESC",
                "limit" => $limit,
                "offset" => $cp
            )
        );
        $this->view->listdata = $listdata;
        $this->view->painginfo = Helper::paginginfo(AlbummediaDetail::count($query), $limit, $p);
        $this->view->host = $this->config->media->host;
        $this->view->backurl = strlen($this->request->getHTTPReferer())<=0? $this->view->activesidebar: $this->request->getHTTPReferer();
    }

    public function formAction()
    {
        $id = $this->request->get("id");
        if(!empty($id)){
            if (!$this->checkpermission("albummedia_update")) return false;
        }
        else {
            if (!$this->checkpermission("albummedia_add")) return false;
        }

        if ($this->request->isPost()) {
            try {
                $datapost = Helper::post_to_array("name,type,status,content");

                $avatar = $this->post_file_key("avatar");
                if ($avatar != null) $datapost['avatar'] = $avatar;
                $coveravatar = $this->post_file_key("coveravatar");
                if ($coveravatar != null) $datapost['coveravatar'] = $coveravatar;

                if ($id > 0) { // Update
                    $o = Albummedia::findFirst($id);
                } else { //insert
                    $o = new Albummedia();
                    $insertid = $o->id = time();
                    $datapost['usercreate'] = $this->userinfo['id'];
                    $datapost['datecreate'] = time();
                }

                $o->map_object($datapost);
                $o->save();

                if(!empty($id))  AlbumTag::find(
                    array(
                        "conditions" => "albumid = $id"
                    )
                )->delete();
                else $id = $insertid;
                $ucpost = Helper::post_to_array("userid,classid");
                $ucpost['userid'] = array_values(array_unique($ucpost['userid']));
                $ucpost['classid'] = array_values(array_unique($ucpost['classid']));
                foreach($ucpost['userid'] as $item){
                    $etag =  new AlbumTag();
                    $etag->userid = $item;
                    $etag->albumid = $id;
                    $etag->classid = 0;
                    $etag->save();
                }
                foreach($ucpost['classid'] as $item){
                    $etag =  new AlbumTag();
                    $etag->classid = $item;
                    $etag->albumid = $id;
                    $etag->userid = 0;
                    $etag->save();
                }
                $this->flash->success($this->view->labelkey['general.lbl_process_success']);
            } catch (\Exception $e) {
                $this->flash->error($e->getMessage());
            }
        }
        if (!empty($id)){
            $o = Albummedia::findFirst($id);
            $listtag = AlbumTag::find( array(
                "conditions" => "albumid = $id"
            ))->toArray();
            $listiduser = implode(",",array_column($listtag,"userid"));
            $listuser = $listiduser ? User::find(array("id in ($listiduser)")) : array();
            $listidclass = implode(",",array_column($listtag,"classid"));
            $listclass = $listidclass ? Classobj::find(array("id in ($listidclass)")) : array();
        }
        $this->view->object = $o;
        $this->view->tagclass = $listclass;
        $this->view->taguser = $listuser;
        $this->view->backurl = strlen($this->request->getHTTPReferer())<=0? $this->view->activesidebar: $this->request->getHTTPReferer();
    }

    public function deleteAction()
    {
        if (!$this->checkpermission("albummedia_delete")) return false;
        $id = $this->request->get("id");

        // Start Delete Album Tag
        $at = AlbumTag::find("albumid=$id");
        if ($at) {
            try {
                $at->delete();
            } catch (\Exception $e) {
                $this->flash->error($e->getMessage());
            }
        }

        // Delete In Album Media Details
        $ad = AlbummediaDetail::find("albumid=$id");
        if ($ad) {
            try {
                $ad->delete();
            } catch (\Exception $e) {
                $this->flash->error($e->getMessage());
            }
        }

        $o = Albummedia::findFirst($id);
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

    public function getmediainfoAction()
    {
        if (!$this->checkpermission("albummedia_update")) return false;
        $this->view->setRenderLevel(\Phalcon\Mvc\View::LEVEL_NO_RENDER);
        header("Content-Type:application/json;charset=utf-8");
        $error = 0;
        $id = $this->request->getPost('id');
        $o = AlbummediaDetail::findFirst("id=$id");
        $data = $o ? $o->toArray() : array();
        echo json_encode(array('error'=>$error,'data'=>$data));
        return;
    }

    public function savemediainfoAction(){
        if (!$this->checkpermission("albummedia_update")) return false;
        $this->view->setRenderLevel(\Phalcon\Mvc\View::LEVEL_NO_RENDER);
        header("Content-Type:application/json;charset=utf-8");
        $error = 0; $msg = '';
        try{
            $id = $this->request->getPost('id');
            $type = $this->request->getPost('type', 'string');
            $datapost = $type == 'photo' ?  Helper::post_to_array("name,status") : Helper::post_to_array("name,content,status");
            $o = AlbummediaDetail::findFirst($id);
            $o->map_object($datapost);
            $o->save();
            echo json_encode(array('error'=>$error,'data'=>$datapost));
        } catch (\Exception $e) {
            $error = 1;
            $msg = $e->getMessage();
            echo json_encode(array('error'=>$error,'msg'=>$msg));
        }
        return;
    }

    public function ajaxdeleteAction()
    {
        if (!$this->checkpermission("albummedia_delete")) return false;
        $this->view->setRenderLevel(\Phalcon\Mvc\View::LEVEL_NO_RENDER);
        header("Content-Type:application/json;charset=utf-8");
        $error = 0; $msg = '';
        $id = $this->request->getPost('id');
        $type = $this->request->getPost('type', 'string');
        $o = AlbummediaDetail::findFirst("id=$id");
        if ($o) {
            try {
                if($type=='video'){
                    $o->delete();
                }
                else{
                    unlink($this->config->media->dir.$o->content);
                    unlink($this->config->media->dir.$o->avatar);
                    $o->delete();
                }
            } catch (\Exception $e) {
                $error = 1;
                $msg = $e->getMessage();
            }
        }
        echo json_encode(array('error'=>$error,'msg'=>$msg));
        return;
    }

    public function uploadphotoAction()
    {
        if (!$this->checkpermission("albummedia_update")) return false;
        $this->view->setRenderLevel(\Phalcon\Mvc\View::LEVEL_NO_RENDER);
        header("Content-Type:application/json;charset=utf-8");
        $error = 0; $msg = '';
        $albumid = $this->request->getPost('albumid');

        require_once($this->config->application->libraryDir.'SimpleImage.php');
        $key = 'photos';
        $image = new SimpleImage();
        $thumbArr = $largeArr = array();
        for($i=0; $i < count($_FILES[$key]['name']); $i++){
            try {
                $image->load($_FILES[$key]['tmp_name'][$i]);
                // Save Large Photo
                $image->resizeToWidth(1600);
                $target_file = $this->create_album_folder($_FILES[$key]['name'][$i], $_FILES[$key]['size'][$i]);
                $image->save($target_file);
                // Save Thumb Photo
                $image->resize(300, 200);
                $target_file_thumb = str_replace('/large/', '/thumb/', $target_file);
                $image->save($target_file_thumb);
                if ($target_file_thumb) array_push($thumbArr, $target_file_thumb);
                if ($target_file) array_push($largeArr, $target_file);

                // Save to database
                $datapost['albumid'] = $albumid;
                $datapost['content'] = $target_file;
                $datapost['avatar'] = $target_file_thumb;
                $datapost['datecreate'] = time();
                $datapost['usercreate'] = $this->userinfo['id'];
                $datapost['status'] = 1;
                $photo = new AlbummediaDetail();
                $photo->map_object($datapost);
                $photo->save();
            } catch (\Exception $e) {
                $error = 1;
                $msg = $e->getMessage();
            }
        }
        if(sizeof($thumbArr)!=count($_FILES[$key]['name'])){ $error = 1; $msg = 'Upload fail !'; }
        if($error) echo json_encode(array('error'=>$msg));
        else echo json_encode(array('msg'=>$msg));
        return;
    }

}