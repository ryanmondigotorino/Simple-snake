<?php

class BackEnd {
  
  /**
   * 
   * Initialize all functions
   * 
   */

  public static $table = 'players';

  public function index() {
    if ($_SERVER['REQUEST_METHOD'] === 'GET') {
      BackEnd::get();
    }
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
      BackEnd::insert();
    }
    if ($_SERVER['REQUEST_METHOD'] === 'PATCH') {

    }
  }

  public function get() {
    $conn = self::dbConnection();
    $sql = "SELECT MAX(score) FROM ".self::$table.";";
    $result = $conn->query($sql);
    $users = [];
    if ($result->num_rows > 0) {
      while($row = $result->fetch_assoc()) {
        $users[] = $row;
      }

    }
    echo $users[0]['MAX(score)'];
  }

  public function insert() {
    try {
      $params = $_POST;
      $conn = self::dbConnection();
      $insert = [];
      $cntr = 0;
      foreach(self::columns() as $columnName => $values) {
        if ($values !== null) {
          $insert['columnName'][$cntr] = $columnName;
          $insert['values'][$cntr] = ($columnName === 'score') ? (int) $params[$columnName] : ((isset($params[$columnName]) ? '\''.$params[$columnName].'\'' : $values));
          $cntr++;
        }
      }
      $column = implode(", ",$insert['columnName']);
      $value = implode(", ",$insert['values']);
      $data = [
        'column' => $column,
        'value' => $value,
      ];
      $sql = BackEnd::saveData($data);  
      if ($conn->query($sql) === TRUE) {
        echo "New record created successfully";
      } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
      }
    } catch (\Exception $error) {
      echo $error;
    }
  }

  public static function columns() {
    $data = [
      'name' => 'name',
      'score' => 0,
      'ipAddress' => "'".$_SERVER['REMOTE_ADDR']."'",
      'createdAt' => time(),
      'updatedAt' => null,
      'deletedAt' => null
    ];
    return $data;
  }

  public function saveData($data) {
    return "INSERT INTO players (".$data['column'].") VALUES(".$data['value'].")";
  }

  public static function dbConnection() {
    $servername = "localhost";
    $username = "root";
    $password = "root";
    $dbname = "snake";
    $conn = new mysqli($servername, $username, $password, $dbname);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    return $conn;
  }
};

BackEnd::index();