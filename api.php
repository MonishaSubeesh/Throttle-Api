<?php
// LIBRARY
require "library.php";

// JSON RESPONSE TO ALL ACTIONS
function respond ($status, $message, $more=null, $http=null) {
  if ($http !== null) { http_response_code($http); }
    exit(json_encode([
      "status" => $status,
      "message" => $message,
      "more" => $more
  ]));
}

if(isset($_POST['req'])){
  // HANDLE ALL REQUEST
  switch ($_POST['req']) {
    //BAD REQUEST
    default:
      respond(false, "Invalid request", null, null, 400);
      break;

    // GET ALL USERS
    case "getall":
      $user = $USR->getall();
      respond(true, "OK", $user);
      break;
    
    // SAVE USER
    case "save":
      $pass = $USR->save(
        $_POST['name'],$_POST['email'], $_POST['password'],
        isset($_POST['id']) ? $_POST['id'] : null
      );
      respond($pass, $pass?"OK":$USR->error);
      break;

    // GET USER DETAILS
    case "get":

      $user = $USR->get($_POST['id']);
      respond(true, "OK", $user);
      break;
    
    // DELETE USER
    case "del":
      $pass = $USR->del($_POST['id']);
      respond($pass, $pass?"OK":$USR->error);
      break;
    }

  }