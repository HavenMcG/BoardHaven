<?php

class ReportTable extends TableEntity {
    function __construct($databaseConnection){
        parent::__construct($databaseConnection,'report');  //the name of the table is passed to the parent constructor
    }


    /**
     * @return \Report[]|false
     */
    public function get_all() {
        $this->SQL = "
            SELECT
                r.Id as 'id',
                r.Post as 'post_id',
                r.Comment as 'comment_id',
                r.Reporter as 'reporter_id',
                r.TimeCreated as 'time_created'
            FROM 
                report r
        ";
        try { $rs = $this->db->query($this->SQL); }
        catch (mysqli_sql_exception $e) {
            $this->MySQLiErrorNr=$e->getCode();
            $this->MySQLiErrorMsg=$e->getMessage();
            return false;
        }
        if ($rs) {
            $reports = [];
            while ($row = $rs->fetch_assoc()) {
                $reports[] = new Report($row);
            }
            return $reports;
        }
        else return false;
    }

    /**
     * @param int $post_id
     * @param int $comment_id
     * @param int $reporter_id
     * @return bool
     */
    public function insert_row($post_id, $comment_id, $reporter_id) {
        $this->SQL = "
            INSERT INTO report (Post, Comment, Reporter) VALUES
            ($post_id, $comment_id, $reporter_id)
        ";
        try {
            $rs = $this->db->query($this->SQL);
        }
        catch (mysqli_sql_exception $e) {
            $this->MySQLiErrorNr=$e->getCode();
            $this->MySQLiErrorMsg=$e->getMessage();
            return false;
        }
        if ($this->db->affected_rows===1 && $rs) return true;
        else return false;
    }
}