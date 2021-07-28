# API

Implement a basic API throttling system which serves HTTP(S) requests which
a. Normally serves the requested resource
b. Throttles requests from a REFERRER when the number of requests
exceeds X/sec, where X is configurable.
c. CRUD basic functions.

PHP 5.3 is a minimum requirement as anonymous functions are used.

## Normally serves the requested resource

```php

	// init the resource
	$ch = curl_init();

	curl_setopt_array(
		$ch, array(
		CURLOPT_URL => 'http://dummy.restapiexample.com/api/v1/employee/2',
		CURLOPT_RETURNTRANSFER => true
	));

	$output = curl_exec($ch);
	echo $output;

	// close
	curl_close($ch);
	

```

## Throttles requests from a REFERRER

```php

	session_start();
    //Max http requests a referrer can make
    const maxrequest = 5;
    //the period in which it limits(60 = 1 minutes)
    const period = 10; 
    if(isset($_GET['refLink'])){

    $init_time = date("Y-m-d H:i:s");
    if( !isset( $_SESSION['FIRST_REQUEST_TIME'] ) ){
            $_SESSION['FIRST_REQUEST_TIME'] = $init_time;
    }
    $first_request_time = $_SESSION['FIRST_REQUEST_TIME'];
    $expire_time = date( "Y-m-d H:i:s", strtotime( $first_request_time )+( period ) );
    if( !isset( $_SESSION['REQ_COUNT'] ) ){
            $_SESSION['REQ_COUNT'] = 0;
    }
    $req_count = $_SESSION['REQ_COUNT'];
    $req_count++;
    //echo $req_count;
    if( $init_time > $expire_time ){//Expired
            $req_count = 1;
            $first_request_time = $init_time;
    }
    $_SESSION['REQ_COUNT'] = $req_count;
    $_SESSION['FIRST_REQUEST_TIME'] = $first_request_time;
    header('X-RateLimit-Limit: '.maxrequest);
    header('X-RateLimit-Remaining: ' . ( maxrequest-$req_count ) );
    // Sleep for a while (requestsInSeconds should be 1 or higher)
    $time_to_sleep = 999999999 / maxrequest; 
    time_nanosleep(0, $time_to_sleep);
    if( $req_count > maxrequest){                
            //Too many requests                
            echo "<h1>Too many requests within the period!</h1>";
            http_response_code( 429 );
    }

    }

```

## CRUD OPERATIONS
`````php

Handled using following files:

* library.php
* api.php

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

`````