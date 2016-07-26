<?php
namespace Webapp\Backend\Controllers;
class CategoryviewController extends ControllerBase
{
    public function initialize()
    {
        $this->modulename = "categoryview";
        $this->view->activesidebar = "/categoryview/index";
        parent::initialize();
    }
    public function indexAction()
    {
        if (!$this->checkpermission("categoryview_view")) return false;
        $poslist = Category::position();
        $langlist = Language::lang();
        $this->view->catpos = $poslist;
        $this->view->langlist = $langlist;
        $q = $this->request->getQuery("pos", "string") ? $this->request->getQuery("pos", "string") : $poslist[0]['key'];
        $l = $this->request->getQuery('lang','string') ? $this->request->getQuery('lang','string') : $langlist['vi_VN']['key'];
        if ($this->request->isPost()) {
            try {
                $selectedCat = array_values(array_unique($this->request->getPost('cat')));
                    $query = "poskey='$q' AND lang='$l'";
                    $o = CategoryView::find(array('conditions' => $query));
                    if ($o) {
                        try {
                            $o->delete();
                        } catch (Exception $e) {
                            $this->flash->error($e->getMessage());
                        }
                    }
                    $i = 1;
                    foreach ($selectedCat as $sCat) {
                        try {
                            $datapost['catid'] = (int) $sCat;
                            $datapost['poskey'] = $q;
                            $datapost['sorts'] = $i;
                            $datapost['lang'] = $l;
                            $o = new CategoryView();
                            $o->map_object($datapost);
                            $o->save();
                            $i++;
                        } catch (Exception $e) {
                            $this->flash->error($e->getMessage());
                        }
                    }
                    if($i>sizeof($selectedCat)) $this->flash->success("Saved Successfully !");
            } catch (Exception $e) {
                $this->flash->error($e->getMessage());
            }
        }

        $query = "poskey = '$q' AND lang='$l'";
        $listdata = CategoryView::find(
            array(
                'conditions' => $query
            )
        );
        $this->view->listdata = $listdata;
    }


}