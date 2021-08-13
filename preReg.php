<?php

require_once 'db.php';
require_once 'phpqrcode/qrlib.php';

if(isset($_POST['submit'])){

    $fname = trim($_POST['fName']);
    $lname = trim($_POST['lName']);
    $phone = trim($_POST['phone']);
    $email = trim($_POST['email']);
    $title = $_POST['title'];
    $compName = $_POST['comName'];
    $jobTitle = $_POST['jobTitle'];
    $compAddress = $_POST['comAddress'];
    $city = $_POST['city'];
    $nationality = $_POST['nationality'];
    $resid = $_POST['resid'];
    $hearedBy = $_POST['hearedBy'];
    $bussiness = $_POST['business'];
    $interest = $_POST['interest'];
    $qrID = uniqid();
    
    
    $formErrors;
  
    if(empty($email)){
        
        $formErrors [] = "email is required";
    } 

    if(! filter_var($email, FILTER_VALIDATE_EMAIL) && !empty($email)){

        $formErrors [] = "email is not valid";
    }

    
    if(empty($phone)){
        
        $formErrors [] = "phone empty";
    } 
    
    
   if(empty($formErrors)){

    try{
       
        $log = $db->query("SELECT email FROM visiters WHERE email = '$email';");

     if($log->rowCount() == 0){
        $stmt = $db->prepare("INSERT INTO visiters (firstName,lastName,phone,email,title,compName,jobTitle,
        compAddress,city,nationality,residence,hearedBy,businessNature,interest,qrCode) 
        VALUES(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)");

        
    
        $stmt->execute([

            $fname,
            $lname,
            $phone,
            $email,
            $title,
            $compName,
            $jobTitle,
            $compAddress,
            $city,
            $nationality,
            $resid,
            $hearedBy,
            $bussiness,
            $interest,
            $qrID
    ]);

    $count = $stmt->rowCount();

    if($count > 0){

        /// qr code show 
        $path = "QrCodes/";
        $file = $path .$qrID.".png";
        // $txt .= "Name: " . $fname . " " . $lname ."\n\r";
        // $txt .= "Email: " .$email."\n\r";
        // $txt .= "Phone " .$phone."\n\r";
         //// contact info
         $codeContents  = 'BEGIN:VCARD'."\n";
         $codeContents .= 'FN:'.$fname.  " " . $lname . "\n";
         $codeContents .= 'ID:'.$qrID."\n";
         $codeContents .= 'TEL;WORK;VOICE:'.$phone."\n";
         $codeContents .= 'ORG:'.$compName."\n";
         $codeContents .= 'END:VCARD';      
         QRcode::png($codeContents, $file, 'M', 5, 1);
         echo '<div><img src="'.$file.'"></div>';


        /// send email with qr code
        $subject = 'Erbil international fair';
        $from = "noreply@gmail.com";
        $to = "abdrhf@gmail.com";
        $headers = "From: ".$from. "\r\n";
        $headers .= "MIME-Version: 1.0\r\n";
        $headers .= "Content-Type: text/html; charset=UTF-8\r\n";
        $msg ='

        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <meta http-equiv="X-UA-Compatible" content="IE=edge">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>you Qr</title>
            <style>
                .container {
                    margin: 0 auto;
                }
            </style>
        </head>
        <body>
            <div class="container">
          <p style="color: red;">hello world</p>
         <table>
         <tr>
        <th>Your QR Code for Erbil International Fair</th>
         </tr>
        <tr>
         <td><img src="https://erbilfairr.000webhostapp.com/QrCodes/'.$qrID.'.png" alt="QrCode" width="150" height="150"></td>
        </tr>
         </table>
        </div>
        </body>
        </html>';
       
        mail($to,$subject,$msg,$headers);
    
    }

     }else{

         $formErrors  [] =  'email is already registerd';
     }


}catch(PDOException $e){

    echo "ERROR" .$e->getMessage();
}
   
}

}


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>register now</title>
    <style>
        form input{
            display:block;
        }
    </style>
</head>
<body>
    
    <form action="" method="post">
        <input type="text" name ="fName" placeHolder="first name" >
        <input type="text" name ="lName" placeHolder="last name" >
        <input type="text" name ="email" placeHolder="email" >
        <input type="text" name ="phone" placeHolder="phone" >
        <input type="text" name ="title" placeHolder="title" >
        <input type="text" name ="comName" placeHolder="company name" >
        <input type="text" name ="jobTitle" placeHolder="job title" >
        <input type="text" name ="comAddress" placeHolder="company address">
        <input type="text" name ="city" placeHolder="city" >
        <input type="text" name ="nationality" placeHolder="nationality" >
        <input type="text" name ="resid" placeHolder="conutry of redidence" >
        <input type="text" name ="hearedBy" placeHolder="heared by">
        <input type="text" name ="interest" placeHolder="interest">
        <input type="text" name ="business" placeHolder="nature of business" >
        <input type="submit" name ="submit" value="submit">
    </form>


    

    <?php
    
  if(isset($formErrors)){
    foreach ($formErrors as $err){

        echo "<div class'danger'>" . $err . "</div>";
    }
  }
    
?>

</body>
</html>

