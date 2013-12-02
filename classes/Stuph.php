<?php
class Stuph {
//PRIVATE DATA
  private $id;
  private $timestamp;
  private $title;
  private $body;
  private $tags = array();
  public $trash;

//PUBLIC DATA
  public function __construct ($i, $tm, $bd, $tgs, $tr = 0) {
    $this->id = $i;
    $this->timestamp = $tm;
    $this->set_title($bd);
    $this->body = $bd;
    $this->trash = $tr;
    $this->tags = $tgs;
  }

  public function get_id () {
    return $this->id;
  }

  public function get_type () {
    return $this->type;
  }

  public function get_timestamp () {
    return $this->timestamp;
  }

  public function get_tags() {
    return $this->tags;
  }

  public function get_title () {
    return $this->title;
  }

  public function set_title ($body) {
    $this->title = substr($body, 0, 75) . '...';
    $this->title = strip_tags($this->title, '<b><i><u>');
  }

  public function get_body () {
    return $this->body;
  }

}
?>