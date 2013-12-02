<?php
require_once 'classes/Database.php';
require_once 'classes/Stuph.php';

Class User extends Database {
  private $user_id;
  private $email;
  private $zip; //Used as key for location information
  
  // Array of 'Stuph'
  private $stuph = array();
  public $stuph_size = 0;
  private $trash = array();
  public $trash_size = 0;

  // Array of pile ids
  private $piles = array();

  public function __construct($email, $uid, $z) {
    // instantiate parent class
    parent::__construct();

    $this->user_id = $uid;
    $this->email = $email;
    $this->zip = $z;

    $this->set_stuph();
    $this->set_piles();
  }

  public function trash_item ($id) {
    parent::update_item($id,
                        $this->user_id,
                       'stuph',
                       'trash',
                       1
                      );

    $this->set_stuph();
  }

  public function restore_item ($id) {
    parent::update_item($id,
                        $this->user_id,
                       'stuph',
                       'trash',
                       0
                      );

    $this->set_stuph();
  }

  public function delete_item ($id) {
    parent::delete_item($id, $this->user_id, 'stuph');

    $this->set_stuph();
  }

  public function add_item ($body) {
    global $session;

    parent::add_item($this->user_id, 'stuph', $body);

    $this->set_stuph();

    $session->redirect('/home');
  }

  public function update_item ($id, $body) {
    global $session;

    parent::update_item($id, $this->user_id, 'stuph', 'body', $body);

    $this->set_stuph();

    $session->redirect('/home');
  }

  public function add_tag ($id, $body) {
    global $session;

    parent::add_tag($id, $body);

    $this->set_stuph();

    $session->redirect("/add/$id");
  }

  public function rm_tag ($id) {
    parent::delete_tag($id, $this->user_id);

    $this->set_stuph();
  }

  public function search ($data) {
    /**
     * clear the array. this is so that we do not get duplicate
     * items on trash_item(). this happens after the object has been
     * instantiated
     */
    $this->stuph = array();
    $this->stuph_size = 0;

    $data = parent::search_data($this->user_id, $data);

    foreach ($data as $item) {
      $tags = parent::get_stuph_tags($item->s_id);

      $this->stuph[++$this->stuph_size] = new Stuph($item->s_id,
                                                    $item->time,
                                                    $item->body,
                                                    $tags,
                                                    $item->trash
                                                   );
    }
  }

  public function create_pile ($pile, $name) {
    global $session;

    // Serialize the array for the database.
    $pile = serialize($pile);

    parent::create_pile($this->user_id, $pile, $name);

    $session->redirect('/home');
  }

  public function delete_pile ($id) {
    global $session;

    parent::delete_pile($this->user_id, $id);

    $session->redirect('/home');
  }

  public function set_piles () {
    $data = parent::get_stuph_piles($this->user_id);

    foreach ($data as $pile) {
      // Unserialize database value
      $pile->s_ids = unserialize($pile->s_ids);

      // Turn the array into a string of form "'56', '56', '56', ..."
      /*$pile->s_ids = implode("', '", $pile->s_ids);
      $pile->s_ids = "'" . $pile->s_ids . "'";*/
      
      // Add to piles array under the id of the pile.
      $this->piles[] = $pile;
    }
  }

  public function get_piles () {
    return $this->piles;
  }

  public function set_stuph () {
    /**
     * clear the array. this is so that we do not get duplicate
     * items on trash_item(). this happens after the object has been
     * instantiated
     */
    $this->stuph = array();
    $this->stuph_size = 0;
    $this->trash = array();
    $this->trash_size = 0;

    $data = parent::get_stuph_data($this->user_id);

    foreach ($data as $item) {
      $tags = parent::get_stuph_tags($item->s_id);

      if ($item->trash) {
        $this->trash[++$this->trash_size] = new Stuph($item->s_id,
                                                      $item->time,
                                                      $item->body,
                                                      $tags
                                                     );
      }
      else {
        $this->stuph[++$this->stuph_size] = new Stuph($item->s_id,
                                                      $item->time,
                                                      $item->body,
                                                      $tags
                                                     );
      } 
    }
  }

  public function get_stuph () {
    return $this->stuph;
  }

  public function get_trash () {
    return $this->trash;
  }

  public function get_email () {
    return $this->email;
  }

  public function get_user_id () {
    return $this->user_id;
  }

  public function get_zip () {
    return $this->zip;
  }

}
?>
