<?php


class AnonUserPage extends PanelModel
{
    function __construct($user, $db, $postArray, $pageTitle, $pageHead, $pageID)
    {
        $this->modelType = 'MemberUserPage';
        parent::__construct($user, $db, $postArray, $pageTitle, $pageHead, $pageID);
    }

    public function setPanelHead_1()
    {
        $b = explode('/', $this->pageID)[1];
        $this->panelHead_1 = '<h3>' . $b . '</h3>';
    }

    public function setPanelContent_1()
    {
        $subTable = new SubmissionTable($this->db);
        $userTable = new UserTable($this->db);
        $rs = $subTable->get_user_submissions($userTable->get_id_by_username(explode('/', $this->pageID)[1]));
        while ($row = $rs->fetch_assoc()) {
            $s = new Submission($row);
            $this->panelContent_1 .= \htmlGen\submission($s);
        }
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