<?php
class Users {
  
  // CONSTRUCTOR - CONNECT TO DATABASE
  private $pdo = null;
  private $stmt = null;
  public $error = "";
  function __construct () {
    try {
      $this->pdo = new PDO(
        "mysql:host=".DB_HOST.";dbname=".DB_NAME.";charset=".DB_CHARSET, 
          DB_USER, DB_PASSWORD, [
          PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
          PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
        ]
      );
    } catch (Exception $ex) { die($ex->getMessage()); }
  }

  // DESTRUCTOR - CLOSE DATABASE CONNECTION
  function __destruct () {
    if ($this->stmt!==null) { $this->stmt = null; }
    if ($this->pdo!==null) { $this->pdo = null; }
  }

  // FUNCTION - SQL QUERY
  function query ($sql, $data) {
    try {
      $this->stmt = $this->pdo->prepare($sql);
      $this->stmt->execute($data);
      return true;
    } catch (Exception $ex) {
      $this->error = $ex->getMessage();
      return false;
    }
  }

  // GETALL USERS
  function getall () { 
    if ($this->query(
      "SELECT * FROM `api_users` ORDER BY `user_email`", []
    )) { return $this->stmt->fetchAll(); }
    return false;
  }

  // ADD/UPDATE USER
  function save ($name, $email, $pass, $id=null) {
    if ($id===null) {
      return $this->query(
        "INSERT INTO `api_users` (`user_name`,`user_email`, `user_password`) VALUES (?,?,?)",
        [$name, $email, password_hash($pass, PASSWORD_BCRYPT)]
      );
    } else {
      return $this->query(
        "UPDATE `api_users` SET `user_name`=?, `user_email`=?, `user_password`=? WHERE `user_id`=?", 
        [$name, $email, password_hash($pass, PASSWORD_BCRYPT), $id]
      );
    }
  }

  // GET USER DETAILS
  function get ($id) { 
    if ($this->query(
      "SELECT * FROM `api_users` WHERE `user_".(is_numeric($id)?"id":"email")."`=?", [$id]
    )) { return $this->stmt->fetch(); }
    return false;
  }
  
  // DELETE USER
  function del ($id) {
    return $this->query(
      "DELETE FROM `api_users` WHERE `user_id`=?", [$id]
    );
  }
}

//DATABASE SETTINGS
define('DB_HOST', 'localhost');
define('DB_NAME', 'my_api');
define('DB_CHARSET', 'utf8');
define('DB_USER', 'root');
define('DB_PASSWORD', '');

//START
session_start();
$USR = new Users();