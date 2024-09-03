<?php


class AnonPost extends PanelModel
{
    function __construct($user, $db, $postArray, $pageTitle, $pageHead, $pageID)
    {
        $this->modelType = 'MemberPost';
        parent::__construct($user, $db, $postArray, $pageTitle, $pageHead, $pageID);
    }

    public function setPanelHead_1()
    {
        $pt = new PostTable($this->db);
        $page_hierarchy = explode('/', $this->pageID);
        $post_id = $page_hierarchy[2];

        // display the post
        if ($post = $pt->get_by_id($post_id)) {
            $this->panelHead_1 = htmlGen\post\header($post,$this->user);
        }
        else $this->panelHead_1 = 'Error retrieving post with id \''.$post_id.'\'';
    }

    public function setPanelContent_1()
    {
        $ct = new CommentTable($this->db);
        $post_id = explode('/', $this->pageID)[2];

        // display comments
        $this->panelContent_1 .= htmlGen\post_comments($ct, $post_id, $this->user);
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