<?php

class Comment {
    private $id;
    public function id() { return $this->id; }
    private $parent_post;
    public function parent_post() { return $this->parent_post; }
    private $parent_comment;
    public function parent_comment() { return $this->parent_comment; }
    private $text;
    public function text() { return $this->text; }
    private $time_created;
    public function time_created() { return $this->time_created; }
    private $author_id;
    public function author_id() { return $this->author_id; }
    private $author_name;
    public function author_name() { return $this->author_name; }

    public function __construct($row) {
        $this->id = $row['id'];
        $this->parent_post = $row['parent_post'];
        $this->parent_comment = $row['parent_comment'];
        $this->text = $row['text'];
        $this->time_created = $row['time_created'];
        $this->author_id = $row['author_id'];
        $this->author_name = $row['author_name'];
    }

}



