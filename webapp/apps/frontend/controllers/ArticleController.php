<?php
namespace Webapp\Frontend\Controllers;
use Webapp\Frontend\Models\Article;
use Webapp\Frontend\Models\AtCat;
use Webapp\Frontend\Models\Category;

class ArticleController extends ControllerBase
{

    public function initialize()
    {
        $this->modulename = "article";
        parent::initialize();
    }

    public function detailAction(){
        //if(!$this->ismobile) $this->view->setMainView("article");
        $id = $this->dispatcher->getParam("id") ? $this->dispatcher->getParam("id") : $this->request->get("id");
        //var_dump($id);die;
        $data = Article::findFirst($id);
        if(!$data) { $this->response->redirect("/error/e404"); return false; }

        $query = "atid={$data->id}";
        $listcat = AtCat::find(array('conditions' => $query));
        $listcat = $listcat->toArray();
        $detailType = "detail";
        $relatedCount = 5;
        if($data->types=="audio") {
            $detailType = "audio";
            $relatedCount = 4;
            if(count($listcat)>0){
                $query = 'Webapp\Frontend\Models\Article.types = :type: and Webapp\Frontend\Models\Article.id != :atid: and \Webapp\Frontend\Models\AtCat.catid = :catid: 
                    and  Webapp\Frontend\Models\Article.status = 1';
                $bind = array('catid' => $listcat[0]['catid'] ,'type'=>"audio",'atid'=>$data->id);
            }
            else{
                $query = 'Webapp\Frontend\Models\Article.types = :type: and Webapp\Frontend\Models\Article.id != :atid: and  Webapp\Frontend\Models\Article.status = 1';
                $bind = array('type'=>"audio",'atid'=>$data->id);
            }
            $relatedpost = AtCat::query()
                ->leftJoin('Webapp\Frontend\Models\Article', 'Webapp\Frontend\Models\AtCat.atid = Webapp\Frontend\Models\Article.id')
                ->where($query,$bind)
                ->orderBy('Webapp\Frontend\Models\Article.datecreate DESC')
                ->limit($relatedCount,0)
                ->execute();
        }
        else if($data->types=="video"){
            $detailType = "video";
            $relatedCount = 4;
            if(count($listcat)>0){
                $query = 'Webapp\Frontend\Models\Article.types = :type: and Webapp\Frontend\Models\Article.id != :atid: and \Webapp\Frontend\Models\AtCat.catid = :catid: 
                    and  Webapp\Frontend\Models\Article.status = 1';
                $bind = array('catid' => $listcat[0]['catid'] ,'type'=>"video",'atid'=>$data->id);
            }
            else{
                $query = 'Webapp\Frontend\Models\Article.types = :type: and Webapp\Frontend\Models\Article.id != :atid: and  Webapp\Frontend\Models\Article.status = 1';
                $bind = array('type'=>"audio",'atid'=>$data->id);
            }
            $relatedpost = AtCat::query()
                ->leftJoin('Webapp\Frontend\Models\Article', 'Webapp\Frontend\Models\AtCat.atid = Webapp\Frontend\Models\Article.id')
                ->where($query,$bind)
                ->orderBy('Webapp\Frontend\Models\Article.datecreate DESC')
                ->limit($relatedCount,0)
                ->execute();
        }
        else if(in_array($data->types,array("nganhdaotao","tinbai","uuthe","tuyensinh","kynang","giangvien"))){
            $detailType = "detail";
            $relatedCount = 4;
            if(count($listcat)>0){
                $query = 'Webapp\Frontend\Models\Article.types = :type: and Webapp\Frontend\Models\Article.id != :atid: and \Webapp\Frontend\Models\AtCat.catid = :catid: 
                    and  Webapp\Frontend\Models\Article.status = 1';
                $bind = array('catid' => $listcat[0]['catid'] ,'type'=>$data->types,'atid'=>$data->id);
            }
            else{
                $query = 'Webapp\Frontend\Models\Article.types = :type: and Webapp\Frontend\Models\Article.id != :atid: and  Webapp\Frontend\Models\Article.status = 1';
                $bind = array('type'=>$data->types,'atid'=>$data->id);
            }
            $relatedpost = AtCat::query()
                ->leftJoin('Webapp\Frontend\Models\Article', 'Webapp\Frontend\Models\AtCat.atid = Webapp\Frontend\Models\Article.id')
                ->where($query,$bind)
                ->orderBy('Webapp\Frontend\Models\Article.datecreate DESC')
                ->limit($relatedCount,0)
                ->execute();
        }
        else{
            $categoryFirst = Category::findFirst($listcat[0]['catid']);
            if($categoryFirst->type=="creator"){
                $detailType = "creator";
                $query = 'atid != '.$data->id.' AND catid = '.$listcat[0]['catid'];
                $relatedpost = AtCat::find(
                    array(
                        'conditions' => $query,
                        'order' => 'atid DESC',
                        'limit' => $relatedCount
                    )
                );
            }
            else{
                $query = 'atid != '.$data->id.' AND catid = '.$listcat[0]['catid'];
                $relatedpost = AtCat::find(
                    array(
                        'conditions' => $query,
                        'order' => 'atid DESC',
                        'limit' => $relatedCount
                    )
                );
            }
        }

        $viewdata = new \stdClass();

        $viewdata->coverphoto = $data->coverphoto ? $data->coverphoto : $this->config->media->host.'uploads/default-image/article-cover.jpg';
        //$viewdata->listcat = $listcat;
        $viewdata->data = $data;
        $viewdata->relatedpost = $relatedpost;
        $query = "catid={$listcat[0]['catid']}";
        $cat = AtCat::find(array('conditions' => $query));
        $list_cat = $cat->toArray();
        $list_id = array_column($list_cat, 'atid');
        unset($list_id[array_search($id, $list_id)]); //remove current at out of list
        $list_id= array_values($list_id);
        $list_at = Article::find(
            [
                'id IN ({list_id:array}) AND types = "'.$data->types.'"',
                //'conditions' => 'types = '.$data->types,
                'bind' => [
                    'list_id' => $list_id
                ],
                "order" => "view_count DESC",
                //'limit' => $relatedCount
            ]
        );
        //increase view + 1
        $datapost['view_count']= ($data->view_count + 1);
        $data->map_object($datapost);
        $data->save();


        $viewdata->news = $list_at;

        $this->view->htmlx = $this->render_template("article/detail","$detailType",$viewdata);
        /** Header */
        $this->view->header = array(
                "title"=>$data->name,
                "desc"=>$data->captions,
                "keyword"=>$data->captions,
                "canonial"=>str_replace('http:/','http://',str_replace("//","/",$this->config->application->baseUrl.$data->getlink())),
                "image"=>$this->config->media->host.$data->avatar
        );
    }
}