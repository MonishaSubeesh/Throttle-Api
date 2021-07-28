<?php
require "api.php";
$all_users = $USR->getall();
?>
<!DOCTYPE html>
<html>
  <head>
    <title>Machine Test</title>
  </head>
  <body>   

  <h3>a) Normally serves the requested resource</h3> 
  <h4><a href="remoteurl.php?remote">Click here to load results</a></h4>
  <h4><a href="remoteurl.php">Click here to load Google</a></h4>
    
  <h3>CRUD operations</h3> 

    <!-- GET USER DETAILS -->
    <form method="post" action="api.php">
      <input type="hidden" name="req" value="get" readonly />
      <select name="id" width="100%">
      <?php
      $no = 1;
      foreach ($all_users as $all_user) {
      ?>
        <option value="<?=$all_user['user_id']?>"><?=$all_user['user_name']?></option>
      <?php
      }
      ?>
      </select>
      <input type="submit" value="GET USER DETAILS"/>
    </form><br/>

    <!-- ADD NEW USER -->
    <form method="post" action="api.php">
      <input type="hidden" name="req" value="save" readonly />
      <input type="text" name="name" required />
      <input type="email" name="email" required />
      <input type="text" name="password" required />
      <input type="submit" value="ADD NEW USER"/>
    </form><br/>

    <!-- UPDATE USER -->
    <form method="post" action="api.php">
      <input type="hidden" name="req" value="save" readonly />
      <select name="id" width="100%">
      <?php
      $no = 1;
      foreach ($all_users as $all_user) {
        //if($all_user['user_id'] != 1){
      ?>
        <option value="<?=$all_user['user_id']?>"><?=$all_user['user_name']?></option>
      <?php
        //}
      }
      ?>
      </select>
      <input type="text" name="name" required />
      <input type="email" name="email" required />
      <input type="text" name="password"  required />
      <input type="submit" value="UPDATE USER"/>
    </form><br/>

    <!-- DELETE USER -->
    <form method="post" action="api.php">
      <input type="hidden" name="req" value="del" readonly />
      <select name="id" width="100%">
      <?php
      $no = 1;
      foreach ($all_users as $all_user) {
        //if($all_user['user_id'] != 1){
      ?>
        <option value="<?=$all_user['user_id']?>"><?=$all_user['user_name']?></option>
      <?php
        //}
      }
      ?>
      </select>
      <input type="submit" value="DELETE USER"/>
    </form><br/>

    <h3>All API Users</h3> 
    <table style="width:30%" border="1">
      <tr>
        <th>No</th>
        <th>Name</th>
        <th>Email</th>
      </tr>
    <?php
    $no = 1;
    foreach ($all_users as $all_user) {
    ?>
      <tr>
        <td><?php print $no;?></td>
        <td><?php print $all_user['user_name'];?></td>
        <td><?php print $all_user['user_email'];?></td>
      </tr>
    <?php
    $no++;
    }
    ?>
    </table>
    <h3>b) Throttles requests from a REFERRER when the number of requests exceeds X/sec, where X is configurable.</h3> 
    <a href="throttler.php?refLink">Click here</a><br/>
  </body>
</html>