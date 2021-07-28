<?php
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
?>
<!DOCTYPE html>
<html>
  <head>
    <title>Machine Test</title>
  </head>
  <body>   

  <h3>b) Throttles requests from a REFERRER when the number of requests exceeds X/sec, where X is configurable.</h3> 
        <form method="post" action="">
        <h3><a href="throttler.php?refLink">It's a referrer link. Click here</a></h3>
        </form>
        <h5>Note : Default set value is 5/10 seconds. You can configure both values within the code.</h5> 
  </body>
</html>