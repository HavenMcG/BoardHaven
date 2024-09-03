<?php


class AdminViewReports extends PanelModel
{
    function __construct($user, $db, $postArray, $pageTitle, $pageHead, $pageID)
    {
        $this->modelType = 'AdminViewReports';
        parent::__construct($user, $db, $postArray, $pageTitle, $pageHead, $pageID);
    }

    public function setPanelHead_1()
    {
        $this->panelHead_1 = '<h3>Reports</h3>';
    }

    public function setPanelContent_1()
    {
        $rt = new ReportTable($this->db);
        $reports = $rt->get_all();
        $this->panelContent_1 = htmlGen\report\report_list($reports,$this->user);
    }

    public function setPanelHead_2()
    {
    }

    public function setPanelContent_2()
    {
    }

    public function setPanelHead_3()
    {
    }

    public function setPanelContent_3()
    {
    }
}