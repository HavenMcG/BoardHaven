<?php


class AnonBoard extends PanelModel
{
    function __construct($user, $db, $postArray, $pageTitle, $pageHead, $pageID)
    {
        $this->modelType = 'MemberBoard';
        parent::__construct($user, $db, $postArray, $pageTitle, $pageHead, $pageID);
    }

    public function setPanelHead_1()
    {
        $board_name = explode('/', $this->pageID)[1];
        $bt = new BoardTable($this->db);
        $board_id = $bt->get_id_by_name($board_name);
        $board = $bt->get_by_id($board_id);
        $this->panelHead_1 = htmlGen\board\header($board,$this->user);
    }

    public function setPanelContent_1()
    {
        $board_name = explode('/', $this->pageID)[1];
        $bt = new BoardTable($this->db);
        $pt = new PostTable($this->db);
        $board_id = $bt->get_id_by_name($board_name);

        $board = $bt->get_by_id($board_id);
        $posts = $pt->get_by_board($board_id);
        if ($posts) $this->panelContent_1 = htmlGen\board\post_list($posts,$this->user);
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