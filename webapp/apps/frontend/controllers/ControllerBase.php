<?php

namespace Webapp\Frontend\Controllers;

use Phalcon\Mvc\Controller;
use Webapp\Frontend\Utility\Helper;
use Webapp\Frontend\Models\Category;
use Webapp\Frontend\Models\CategoryView;

class ControllerBase extends Controller
{
    public $userinfo;
    public $langkey;
    public $modulename; // For language
    public $culture;
    public $currenturl;
    public $ismobile;
    protected function initialize()
    {
        //Header
        $this->ismobile = Helper::isMobile();
        $topmenu = self::getPosMenu(0,'topmenu');
        $this->view->topmenu = $topmenu;
        $this->view->baseurl = $this->config->application->baseUrl;
        $this->view->media = $this->config->media;
        $this->view->currenturl = $this->currenturl = Helper::cpagerparm();
        $this->view->social = $this->config->social;
        $this->view->ismobile = $this->ismobile;

    }

    public function render_template($controller, $action, $data = null)
    {
        $view = $this->view;
        $content = $view->getRender($controller, $action, array("object" => $data),
            function ($view) {
                $view->setRenderLevel(\Phalcon\Mvc\View::LEVEL_LAYOUT);
            }
        );
        return $content;
    }

    public function getPosMenu($parentid, $poskey,$level)
    {
        if($parentid>0) {
            $listdata = Category::find(array("conditions" => "status=1 AND parentid=$parentid"));
        }
        else {
            $listCatView = CategoryView::find("poskey='$poskey'");
            $listCatView = $listCatView->toArray();
            $catStr = '';
            foreach($listCatView as $catview) $catStr .= $catview['catid'].',';
            $catStr = substr($catStr,0,-1);
            $listdata = Category::find(array('conditions'=>"status=1 AND parentid=$parentid AND id IN($catStr)"));
        }
        if (!$listdata->toArray()) return null;

        $html = $parentid > 0 ? '<ul>' : '<ul id="main-menu" class="sm sm-clean">';
        if($parentid==0) $html .= "<li><a href='/'>Trang chủ</a></li>";
        foreach ($listdata as $row) {
            $html .= "<li><a href='{$row->getlink()}'>{$row->name}</a>";
            $html .= self::getPosMenu($row->id,$poskey);
            $html .= "</li>";
        }
        $html .= '</ul>';
        return $html;
    }


}