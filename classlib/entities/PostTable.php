<?php

class PostTable extends TableEntity {
    function __construct($databaseConnection){
        parent::__construct($databaseConnection,'comment');  //the name of the table is passed to the parent constructor
    }
    public function insert_row($board_id, $author_id, $title, $content) {
       $query = "
            INSERT INTO post (Board, Author, Title, Content)
            VALUES ($board_id, $author_id, '$title', '$content')
       ";
        try {
            $rs = $this->db->query($query);
        }
        catch (mysqli_sql_exception $e) {
            $this->MySQLiErrorNr=$e->getCode();
            $this->MySQLiErrorMsg=$e->getMessage();
            return false;
        }
        if ($this->db->affected_rows===1 && $rs) return true;
        else return false;
    }

    public function edit_content($post_id, $new_title, $new_content) {
        $query = "
            UPDATE post p
            SET
                p.Title = '$new_title',
                p.Content = '$new_content'
            WHERE p.Id = $post_id
        ";
        try {
            $rs = $this->db->query($query);
        }
        catch (mysqli_sql_exception $e) {
            $this->MySQLiErrorNr=$e->getCode();
            $this->MySQLiErrorMsg=$e->getMessage();
            return false;
        }
        if ($this->db->affected_rows===1 && $rs) return true;
        else return false;
    }

    /**
     * @param int $post_id
     * @return Post|false
     */
    public function get_by_id($post_id) {
        // DISPLAYS DELETED BECAUSE LEFT JOIN
        $this->SQL = "
            SELECT
                p.Id as 'id',
                b.Id as 'board_id',
                b.Name as 'board_name',
                u.Id as 'author_id',
                u.Username as 'author_name',
                p.TimeCreated as 'time_created',
                p.Title as 'title',
                p.Content as 'content',
                p.Pinned as 'pinned',
                c.CommentCount AS 'comment_count'
            FROM 
                visible_post p
                LEFT JOIN
                user u ON p.Author = u.Id
                INNER JOIN
                board b ON p.Board = b.Id
                LEFT JOIN (
                    SELECT `Post`, COUNT(Id) AS `CommentCount`
                    FROM submission
                    WHERE `Type` = 1
                    GROUP BY post
                ) c ON p.Id = c.Post
            WHERE p.Id = $post_id
        ";
        try { $rs = $this->db->query($this->SQL); }
        catch (mysqli_sql_exception $e) {
            $this->MySQLiErrorNr=$e->getCode();
            $this->MySQLiErrorMsg=$e->getMessage();
            return false;
        }
        if ($rs) {
            return new Post($rs->fetch_assoc());
        }
        else return false;
    }

    public function admin_delete_by_id($post_id, $administratorship) {
        $this->SQL = "
            INSERT INTO removed_submission (Post, Comment, Administrator, Moderator, TimeRemoved)
            VALUES ($post_id, NULL, $administratorship, NULL, NOW())
        ";
        try { $this->db->query($this->SQL); }
        catch (mysqli_sql_exception $e) {
            $this->MySQLiErrorNr=$e->getCode();
            $this->MySQLiErrorMsg=$e->getMessage();
            return false;
        }
        return true;
    }

    public function self_delete_by_id($post_id) {
        $this->SQL = "
            INSERT INTO removed_submission (Post, Comment, Administrator, Moderator, TimeRemoved)
            VALUES ($post_id, NULL, NULL, NULL, NOW())
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
     * @param $board_id
     * @return \Post[]|false
     */
    public function get_by_board($board_id) {
        // DOESNT DISPLAY DELETED BECAUSE INNER JOIN
        $this->SQL = "
            SELECT
                p.Id as 'id',
                b.Id as 'board_id',
                b.Name as 'board_name',
                u.Id as 'author_id',
                u.Username as 'author_name',
                p.TimeCreated as 'time_created',
                p.Title as 'title',
                p.Content as 'content',
                p.Pinned as 'pinned',
                c.CommentCount AS 'comment_count'
            FROM 
                visible_post p
                INNER JOIN
                user u ON p.Author = u.Id
                INNER JOIN
                board b ON p.Board = b.Id
                LEFT JOIN (
                    SELECT `Post`, COUNT(Id) AS `CommentCount`
                    FROM submission
                    WHERE `Type` = 1
                    GROUP BY post
                ) c ON p.Id = c.Post
            WHERE b.Id = $board_id
            ORDER BY p.TimeCreated DESC
        ";
        try { $rs = $this->db->query($this->SQL); }
        catch (mysqli_sql_exception $e) {
            $this->MySQLiErrorNr=$e->getCode();
            $this->MySQLiErrorMsg=$e->getMessage();
            echo $this->MySQLiErrorNr;
            echo $this->MySQLiErrorMsg;
            return false;
        }
        if ($rs) {
            $posts = [];
            while($row = $rs->fetch_assoc()) {
                $posts[] = new Post($row);
            }
            return $posts;
        }
        else return false;
    }
}