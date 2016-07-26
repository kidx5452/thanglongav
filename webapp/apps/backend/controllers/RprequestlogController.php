<?php
namespace Webapp\Backend\Controllers;
class RpRequestLogController extends ControllerBase
{
    public function initialize()
    {
        $this->modulename = "rprequestlog";
        $this->view->activesidebar = "/rprequestlog/index";
        parent::initialize();
    }

    public function indexAction()
    {
        if (!$this->checkpermission("rprequestlog_view")) return false;
        $limit = 20;
        $p = $this->request->get("p");
        if ($p <= 1) $p = 1;
        $cp = ($p - 1) * $limit;

        $sdate = $this->request->getQuery("sdate", "string") ? strtotime($this->request->getQuery("sdate", "string")) : strtotime('-30 days');
        $edate = $this->request->getQuery("edate", "string") ? strtotime($this->request->getQuery("edate", "string")) : time();

        $sql = "SELECT rp.userid,COUNT(rp.id) as count,u.username FROM rp_request_log as rp, user as u WHERE rp.userid = u.id AND rp.datecreate BETWEEN $sdate AND $edate GROUP BY rp.userid ORDER BY count DESC";

        $result = $this->db->query("$sql LIMIT $cp,$limit");
        $listdata = $result->fetchAll();

        $count = $this->db->query("$sql");
        $totalRow = $count->numRows();

        $this->view->q = $q;
        $this->view->sdate = $sdate;
        $this->view->edate = $edate;
        $this->view->listdata = $listdata;
        $this->view->painginfo = Helper::paginginfo($totalRow, $limit, $p);
    }

    public function detailsAction()
    {
        if (!$this->checkpermission("rprequestlog_view")) return false;
        $limit = 20;
        $p = $this->request->get("p");
        if ($p <= 1) $p = 1;
        $cp = ($p - 1) * $limit;

        $userid = $this->request->getQuery('userid');
        $sdate = $this->request->getQuery("sdate", "string") ? strtotime($this->request->getQuery("sdate", "string")) : strtotime('-30 days');
        $edate = $this->request->getQuery("edate", "string") ? strtotime($this->request->getQuery("edate", "string").' '.date("H:i:s")) : date("d-m-Y");

        $sql = "SELECT rp.userid,rp.link,COUNT(rp.link) as count FROM rp_request_log as rp WHERE rp.userid=$userid AND rp.datecreate BETWEEN $sdate AND $edate GROUP BY rp.link ORDER BY count DESC";

        $result = $this->db->query("$sql LIMIT $cp,$limit");
        $listdata = $result->fetchAll();

        $count = $this->db->query("$sql");
        $totalRow = $count->numRows();

        /*$query = "userid=$userid AND datecreate BETWEEN $sdate AND $edate";
        $listdata = RpRequestLog::find(array(
            "conditions" => $query,
            "order" => "id ASC",
            "limit" => $limit,
            "offset" => $cp
        ));*/


        $this->view->sdate = $sdate;
        $this->view->edate = $edate;
        $this->view->listdata = $listdata;
        $this->view->painginfo = Helper::paginginfo($totalRow, $limit, $p);
        $this->view->backurl = strlen($this->request->getHTTPReferer())<=0? $this->view->activesidebar: $this->request->getHTTPReferer();
    }

}