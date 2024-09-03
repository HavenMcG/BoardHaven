<?php

class Board {
    private $id;
    public function id() { return $this->id; }
    private $name;
    public function name() { return $this->name; }
    private $founder_id;
    public function founder_id() { return $this->founder_id; }
    private $founder_name;
    public function founder_name() { return $this->founder_name; }
    private $time_created;
    public function time_created() { return $this->time_created; }
    private $rules;
    public function rules() { return $this->rules; }

    public function __construct($row) {
        $this->id = $row['id'];
        $this->name = $row['name'];
        $this->founder_id = $row['founder_id'];
        $this->founder_name = $row['founder_name'];
        $this->time_created = $row['time_created'];
        $this->rules = $row['rules'];
    }

}



