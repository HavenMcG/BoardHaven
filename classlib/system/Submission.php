<?php

class Submission {
    private $type;
    public function type() { return $this->type; }
    private $id;
    public function id() { return $this->id; }
    private $author_id;
    public function author_id() { return $this->author_id; }
    private $author_name;
    public function author_name() { return $this->author_name; }
    private $time_created;
    public function time_created() { return $this->time_created; }
    private $title;
    public function title() { return $this->title; }
    private $content;
    public function content() { return $this->content; }
    private $post_id;
    public function post_id() { return $this->post_id; }
    private $board_id;
    public function board_id() { return $this->board_id; }
    private $board_name;
    public function board_name() { return $this->board_name; }


    public function __construct($row) {
        $this->type = $row['type'];
        $this->id = $row['id'];
        $this->author_id = $row['author_id'];
        $this->author_name = $row['author_name'];
        $this->time_created = $row['time_created'];
        $this->title = $row['title'];
        $this->content = $row['content'];
        $this->post_id = $row['post_id'];
        $this->board_id = $row['board_id'];
        $this->board_name = $row['board_name'];
    }
}