<?php

class Report {
    private $id;
    public function id() { return $this->id; }
    private $post_id;
    public function post_id() { return $this->post_id; }
    private $comment_id;
    public function comment_id() { return $this->comment_id; }
    private $reporter_id;
    public function reporter_id() { return $this->reporter_id; }
    private $time_created;
    public function time_created() { return $this->time_created; }

    public function __construct($row) {
        $this->id = $row['id'];
        $this->post_id = $row['post_id'];
        $this->comment_id = $row['comment_id'];
        $this->reporter_id = $row['reporter_id'];
        $this->time_created = $row['time_created'];
    }

}



