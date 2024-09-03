<?php


class AdminPost extends PanelModel
{
    function __construct($user, $db, $postArray, $pageTitle, $pageHead, $pageID)
    {
        $this->modelType = 'AdminPost';
        parent::__construct($user, $db, $postArray, $pageTitle, $pageHead, $pageID);
    }

    public function setPanelHead_1()
    {
        $pt = new PostTable($this->db);
        $ct = new CommentTable($this->db);
        $rt = new ReportTable($this->db);
        $ut = new UserTable($this->db);
        $page_hierarchy = explode('/', $this->pageID);
        $post_id = $page_hierarchy[2];
        $post = $pt->get_by_id($post_id);

        // handle forms
        if (isset($this->postArray['btn-submit-post-comment'])) {
            if ($this->userLoggedIn) {
                $content = addslashes($this->postArray['content']);
                $ct->insert_row($post_id, 'NULL', $content, $this->user->id());
            }
        }
        if (isset($this->postArray['btn-submit-post-report'])) {
            if ($this->userLoggedIn) {
                $rt->insert_row($post_id, 'NULL', $this->user->id());
            }
        }
        if (isset($this->postArray['btn-delete-post'])) {
            if ($this->userLoggedIn) {
                $is_owner = $this->user->id() === $post->author_id();
                $is_admin = $this->user->is_admin();
                if ($is_owner) {
                    if ($pt->self_delete_by_id($post_id)) {
                        header('Location: '.$_SERVER['PHP_SELF'].'?pageID=b/'.$post->board_name());
                    }
                }
                else if ($is_admin) {
                    $administratorship = $ut->get_active_administratorship($this->user->id());
                    if ($pt->admin_delete_by_id($post_id, $administratorship)) {
                        header('Location: '.$_SERVER['PHP_SELF'].'?pageID=b/'.$post->board_name());
                    }
                }
            }
        }

        // display the post
        if ($post = $pt->get_by_id($post_id)) {
            $this->panelHead_1 = htmlGen\post\header($post,$this->user);
        }
        else $this->panelHead_1 = 'Error retrieving post with id \''.$post_id.'\'';
    }

    public function setPanelContent_1()
    {
        $ct = new CommentTable($this->db);
        $ut = new UserTable($this->db);
        $post_id = explode('/', $this->pageID)[2];

        // handle forms
        if (isset($this->postArray['btn-submit-comment-comment'])) {
            if ($this->userLoggedIn) {
                $parent_comment = $this->postArray['parent-comment'];
                $text = $this->postArray['text'];
                $ct->insert_row('NULL', $parent_comment, $text, $this->user->id());
            }
        }
        if (isset($this->postArray['btn-edit-comment'])) {
            if ($this->userLoggedIn) {
                $is_owner = $this->user->id() == $ct->get_by_id($this->postArray['id'])->author_id();
                if ($is_owner) {
                    $id = $this->postArray['id'];
                    $content = $this->postArray['content'];
                    $ct->edit_content($id, $content);
                }
            }
        }
        if (isset($this->postArray['btn-delete-comment'])) {
            if ($this->userLoggedIn) {
                $comment_id = $this->postArray['id'];
                $is_owner = $this->user->id() == $ct->get_by_id($comment_id)->author_id();
                $is_admin = $this->user->is_admin();
                if ($is_owner) {
                    $ct->self_delete_by_id($comment_id);
                }
                else if ($is_admin) {
                    $administratorship = $ut->get_active_administratorship($this->user->id());
                    $ct->admin_delete_by_id($comment_id, $administratorship);
                }
            }
        }
        if (isset($this->postArray['btn-submit-comment-report'])) {
            if ($this->userLoggedIn) {
                $rt = new ReportTable($this->db);
                $comment_id = $this->postArray['report-comment-id'];
                $rt->insert_row('NULL', $comment_id, $this->user->id());
            }
        }

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