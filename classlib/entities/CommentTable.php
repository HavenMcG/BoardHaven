<?php

class CommentTable extends TableEntity {
    function __construct($databaseConnection){
        parent::__construct($databaseConnection,'comment');  //the name of the table is passed to the parent constructor
    }
    public function insert_row($parent_post, $parent_comment, $text, $author) {
        $parent_post = addslashes($parent_post);
        $parent_comment = addslashes($parent_comment);
        $text = addslashes($text);
        $query = "
            INSERT INTO comment (ParentPost, ParentComment, Text, Author)
            VALUES ($parent_post, $parent_comment, '$text', $author)
        ";
        try {
            $rs = $this->db->query($query);
        }
        catch (mysqli_sql_exception $e) {
            return false;
        }
        //check the insert query worked:
        if ($this->db->affected_rows===1 && $rs) { return TRUE; }
        else { return FALSE; }
    }

    public function edit_content($comment_id, $new_content) {
        $new_content = addslashes($new_content);
        $query = "
            UPDATE comment
            SET Text = '$new_content'
            WHERE Id = $comment_id
        ";
        try { $rs = $this->db->query($query); }
        catch (mysqli_sql_exception $e) { return false; }
        if ($this->db->affected_rows===1 && $rs) return true;
        else return false;
    }

    /**
     * @param int $comment_id
     * @return Comment|false
     */
    public function get_by_id($comment_id) {
        $this->SQL = "
            SELECT
                comment.Id as 'id',
                comment.ParentPost as 'parent_post',
                comment.ParentComment as 'parent_comment',
                comment.Text as 'text',
                comment.TimeCreated as 'time_created',
                user.Id as 'author_id',
                user.Username as 'author_name'
            FROM comment INNER JOIN user
            ON comment.Author = user.Id
            WHERE comment.Id = $comment_id
        ";
        try { $rs = $this->db->query($this->SQL); }
        catch (mysqli_sql_exception $e) {
            $this->MySQLiErrorNr=$e->getCode();
            $this->MySQLiErrorMsg=$e->getMessage();
            return false;
        }
        if ($rs) {
            return new Comment($rs->fetch_assoc());
        }
        else return false;
    }

    public function admin_delete_by_id($comment_id, $administratorship) {
        $this->SQL = "
            INSERT INTO removed_submission (Post, Comment, Administrator, Moderator, TimeRemoved)
            VALUES (NULL, $comment_id, $administratorship, NULL, NOW())
        ";
        try { $this->db->query($this->SQL); }
        catch (mysqli_sql_exception $e) {
            $this->MySQLiErrorNr=$e->getCode();
            $this->MySQLiErrorMsg=$e->getMessage();
            return false;
        }
        return true;
    }

    public function self_delete_by_id($comment_id) {
        $this->SQL = "
            INSERT INTO removed_submission (Post, Comment, Administrator, Moderator, TimeRemoved)
            VALUES (NULL, $comment_id, NULL, NULL, NOW())
        ";
        try { $this->db->query($this->SQL); }
        catch (mysqli_sql_exception $e) {
            $this->MySQLiErrorNr=$e->getCode();
            $this->MySQLiErrorMsg=$e->getMessage();
            return false;
        }
        return true;
    }

    /**
     * @param int $comment_id
     * @return mysqli_result|false
     */
    public function get_comment_comments($comment_id) {
        $this->SQL = "
            SELECT
                c.Id as 'id',
                c.ParentPost as 'parent_post',
                c.ParentComment as 'parent_comment',
                c.Text as 'text',
                c.TimeCreated as 'time_created',
                u.Id as 'author_id',
                u.Username as 'author_name'
            FROM visible_comment c LEFT JOIN user u
            ON c.Author = u.Id
            WHERE c.ParentComment = $comment_id;
        ";
        try { $rs = $this->db->query($this->SQL); }
        catch (mysqli_sql_exception $e) {
            $this->MySQLiErrorNr=$e->getCode();
            $this->MySQLiErrorMsg=$e->getMessage();
            return false;
        }
        return $rs;
    }

    /**
     * @param int $post_id
     * @return mysqli_result|false
     */
    public function get_post_comments($post_id) {
        $this->SQL = "
            SELECT
                c.Id as 'id',
                c.ParentPost as 'parent_post',
                c.ParentComment as 'parent_comment',
                c.Text as 'text',
                c.TimeCreated as 'time_created',
                u.Id as 'author_id',
                u.Username as 'author_name'
            FROM visible_comment c LEFT JOIN user u
            ON c.Author = u.Id
            WHERE c.ParentPost = $post_id;
        ";
        try { $rs = $this->db->query($this->SQL); }
        catch (mysqli_sql_exception $e) {
            $this->MySQLiErrorNr=$e->getCode();
            $this->MySQLiErrorMsg=$e->getMessage();
            return false;
        }
        return $rs;
    }
}