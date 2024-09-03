<?php

class SubmissionTable extends TableEntity {
    function __construct($databaseConnection){
        parent::__construct($databaseConnection,'submission');  //the name of the table is passed to the parent constructor
    }
    public function get_user_submissions($userId) {

        //Type, Id, Author, TimeCreated, Title, Content, AdminPost, AdminBoard
        $this->SQL = "
            SELECT
                submission.Type as type,
                submission.Id as id,
                submission.Author as author_id,
                user.Username as author_name,
                submission.TimeCreated as time_created,
                submission.Title as title,
                submission.Content as content,
                submission.Post as post_id,
                submission.Board as board_id,
                board.Name as board_name
            FROM submission
            INNER JOIN board ON submission.Board = board.Id
            INNER JOIN user ON submission.Author = user.Id
            WHERE submission.Author = '$userId'
            ORDER BY submission.TimeCreated DESC
        ";
        $rs = $this->db->query($this->SQL);
        return $rs;
    }

    /**
     * @param int $type
     * @param int $id
     * @return \Submission|false
     */
    public function get_by_type_id($type, $id) {
        $this->SQL = "
            SELECT
                submission.Type as type,
                submission.Id as id,
                submission.Author as author_id,
                user.Username as author_name,
                submission.TimeCreated as time_created,
                submission.Title as title,
                submission.Content as content,
                submission.Post as post_id,
                submission.Board as board_id,
                board.Name as board_name
            FROM submission
            INNER JOIN board ON submission.Board = board.Id
            INNER JOIN user ON submission.Author = user.Id
            WHERE submission.Id = $id AND submission.Type = $type
            ORDER BY submission.TimeCreated DESC
        ";
        try { $rs = $this->db->query($this->SQL); }
        catch (mysqli_sql_exception $e) {
            $this->MySQLiErrorNr=$e->getCode();
            $this->MySQLiErrorMsg=$e->getMessage();
            return false;
        }
        if ($row = $rs->fetch_assoc()) {
            return new Submission($row);
        }
        else return false;
    }
}