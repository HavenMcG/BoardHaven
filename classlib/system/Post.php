<?php

class Post {
    private $id;
    public function id() { return $this->id; }
    private $board_id;
    public function board_id() { return $this->board_id; }
    private $board_name;
    public function board_name() { return $this->board_name; }
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
    private $pinned;
    public function pinned() { return $this->pinned; }
    private $comment_count;
    public function comment_count() { return $this->comment_count; }

    public function __construct($row) {
        $this->id = $row['id'];
        $this->board_id = $row['board_id'];
        $this->board_name = $row['board_name'];
        $this->author_id = $row['author_id'];
        $this->author_name = $row['author_name'];
        $this->time_created = $row['time_created'];
        $this->title = $row['title'];
        $this->content = $row['content'];
        $this->pinned = $row['pinned'];
        $this->comment_count = $row['comment_count'];
        if ($this->comment_count==NULL) $this->comment_count = 0;
    }

}



