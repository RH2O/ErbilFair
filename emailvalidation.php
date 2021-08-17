<?php

require "db.php";

$email= $_POST['email'];

$email = isset($_POST['email']) ? $_POST['email'] : " ";
    $log = $db->query("SELECT email FROM visiters WHERE email = '$email';");

    if($log->rowCount() == 0){

        echo 'Email <span class="required-star">*</span>';

    }else{

        echo '<span style="color:red">Email has already registerd</span>';
    }
?> 
