<?php

class BoardTable extends TableEntity {
    function __construct($databaseConnection){
        parent::__construct($databaseConnection,'board');  //the name of the table is passed to the parent constructor
    }

    /**
     * @param int $board_id
     * @return Board|false
     */
    public function get_by_id($board_id) {
        $this->SQL = "
            SELECT
                b.Id as 'id',
                b.Name as 'name',
                u.Id as 'founder_id',
                u.Username as 'founder_name',
                b.TimeCreated as 'time_created',
                b.Rules as 'rules'
            FROM 
                board b
                INNER JOIN
                user u ON b.Founder = u.Id
            WHERE b.Id = $board_id
        ";
        try { $rs = $this->db->query($this->SQL); }
        catch (mysqli_sql_exception $e) {
            $this->MySQLiErrorNr=$e->getCode();
            $this->MySQLiErrorMsg=$e->getMessage();
            return false;
        }
        if ($rs) {
            return new Board($rs->fetch_assoc());
        }
        else return false;
    }

    /**
     * @param string $board_name
     * @return false|int
     */
    public function get_id_by_name($board_name) {
        $this->SQL = "
            SELECT b.Id
            FROM board b
            WHERE b.Name='$board_name'
        ";
        try { $rs = $this->db->query($this->SQL); }
        catch (mysqli_sql_exception $e) {
            $this->MySQLiErrorNr=$e->getCode();
            $this->MySQLiErrorMsg=$e->getMessage();
            return false;
        }
        if ($row = $rs->fetch_assoc()) {
            return $row['Id'];
        }
        else return false;
    }

    /**
     * @return \Board[]|false
     */
    public function get_all() {
        $this->SQL = "
            SELECT
                b.Id as 'id',
                b.Name as 'name',
                u.Id as 'founder_id',
                u.Username as 'founder_name',
                b.TimeCreated as 'time_created',
                b.Rules as 'rules'
            FROM 
                board b
                INNER JOIN
                user u ON b.Founder = u.Id
        ";
        try { $rs = $this->db->query($this->SQL); }
        catch (mysqli_sql_exception $e) {
            $this->MySQLiErrorNr=$e->getCode();
            $this->MySQLiErrorMsg=$e->getMessage();
            return false;
        }
        if ($rs) {
            $boards = [];
            while ($row = $rs->fetch_assoc()) {
                $boards[] = new Board($row);
            }
            return $boards;
        }
        else return false;
    }

    /**
     * @param string $name
     * @param int $founder_id
     * @param string $rules
     * @return bool
     */
    public function insert_row($name, $founder_id, $rules) {
        $this->SQL = "
            INSERT INTO board (Name, Founder, Rules) VALUES
            ('$name', $founder_id, '$rules')
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