<?php
require '/core/config.php';

class Database {
  public $DB;


//PRIVATE FUNCTIONS
  private function resolve_data ($query) {
    $meta = $query->result_metadata();

    while ($field = $meta->fetch_field()) {
      $parameters[] = &$row[$field->name];
    }

    call_user_func_array(array($query, 'bind_result'), $parameters);
    
    $results = array();

    while ($query->fetch()) {
      $obj = new stdClass();

      foreach($row as $key => $val) {
        $obj->$key = $val;
      }

      $results[] = $obj;
    }

    return $results;
  }


//PUBLIC FUNCTIONS
  public function __construct () {
    global$DB_HOST;
    global$DB_USER;
    global$DB_PASS;
    global $DB_NAME;

    $this->DB = new mysqli($DB_HOST, $DB_USER, $DB_PASS, $DB_NAME);
  }

  public function get_stuph_data ($user_id) {
    $query = $this->DB->prepare ("
      SELECT *
      FROM stuph
      WHERE user_id = ?
      ORDER BY time DESC
    ");
    
    $query->bind_param('d', $user_id);
    $query->execute();
    
    return $this->resolve_data($query);
  }

  public function get_stuph_tags ($s_id) {
    $query = $this->DB->prepare ("
      SELECT *
      FROM tag
      WHERE t_id = ?
    ");
    
    $query->bind_param('d', $s_id);
    $query->execute();
    
    return $this->resolve_data($query);
  }

  public function add_tag ($id, $body) {
    $query = $this->DB->prepare ("
      INSERT INTO tag
      (t_id, name)
      VALUES (?, ?)
    ");
    
    $query->bind_param('ds', $id, $body);
    $query->execute();
  }

  public function delete_tag ($id, $user_id) {
    $query = $this->DB->prepare ("
      DELETE FROM tag
      WHERE id = ?
      AND t_id IN (
        SELECT s_id
        FROM stuph
        WHERE user_id = ?
      )
    ");
    
    $query->bind_param('dd', $id, $user_id);
    $query->execute();
  }

  public function get_stuph_piles ($user_id) {
    $query = $this->DB->prepare ("
      SELECT *
      FROM pile
      WHERE user_id = ?
    ");
    
    $query->bind_param('d', $user_id);
    $query->execute();
    
    return $this->resolve_data($query);
  }

  public function create_pile ($user_id, $pile, $name) {
    $query = $this->DB->prepare ("
      INSERT INTO pile
      (user_id, s_ids, name)
      VALUES (?, ?, ?)
    ");
    
    $query->bind_param('dss', $user_id, $pile, $name);
    $query->execute();
  }

  public function delete_pile ($user_id, $id) {
    $query = $this->DB->prepare ("
      DELETE FROM pile
      WHERE user_id = ?
      AND id = ?
    ");
    
    $query->bind_param('dd', $user_id, $id);
    $query->execute();
  }

  public function delete_item ($id, $user_id, $table) {
    // Delete note
    $query1 = $this->DB->prepare ("
      DELETE FROM $table
      WHERE s_id = ?
      AND user_id = ?
    ");

    $query1->bind_param('dd', $id, $user_id);
    $query1->execute();

    // Delete associated tags
    $query2 = $this->DB->prepare ("
      DELETE FROM tag
      WHERE t_id = ?
    ");

    $query2->bind_param('d', $id);
    $query2->execute();
  }

  public function update_item ($id, $user_id, $table, $column, $value) {
    $query = $this->DB->prepare ("
      UPDATE $table
      SET $column = ?
      WHERE s_id = ?
      AND user_id = ?
    ");

    $query->bind_param('sdd', $value, $id, $user_id);
    $query->execute();
  }
  public function add_item ($id, $table, $value1) {
    $query = $this->DB->prepare ("
      INSERT INTO $table
      (user_id, body)
      VALUES (?, ?)
    ");

    $query->bind_param('ds', $id, $value1);
    $query->execute();
  }

  public function search_data ($id, $data) {
    $wowc_data = $data;
    $data = '%' . $data . '%';

    $query = $this->DB->prepare ("
      SELECT *
      FROM stuph AS s
        LEFT OUTER JOIN tag AS t
          ON s.s_id = t.t_id
      WHERE s.user_id = ?
      AND (
        s.body LIKE ? OR t.name LIKE ?
      )
      GROUP BY s.s_id
      ORDER BY s.time DESC
    ");

/*
      SELECT *
      FROM stuph AS s
        LEFT OUTER JOIN tag AS t
          ON s.s_id = t.t_id
      WHERE s.user_id = ?
      AND (
        s.body LIKE ? OR t.name LIKE ? OR ? IN (
          SELECT name
          FROM pile
          WHERE user_id = ?
          AND name = ?
        )
      )
      GROUP BY s.s_id
      ORDER BY s.time DESC
*/
    
    $query->bind_param('dss', $id, $data, $data);
    $query->execute();
    
    return $this->resolve_data($query);
  }

}
?>
