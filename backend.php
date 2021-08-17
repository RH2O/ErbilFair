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
    $otherInfo = $_POST['otherInfo'];
    $interest = isset($_POST['interest']) ? $_POST['interest'] : [];
    $interest = implode(",", $interest);
    $qrID = uniqid();
    $qrImg;
    
    $formErrors;
    
    if(empty($email)){
        
        $formErrors [] = "email is required";
    } 

    if(! filter_var($email, FILTER_VALIDATE_EMAIL) && !empty($email)){

        $formErrors [] = "email is not valid";
    }


    function validate_phone_number($phone)
{
     // Allow +, - and . in phone number
     $filtered_phone_number = filter_var($phone, FILTER_SANITIZE_NUMBER_INT);
     // Remove "-" from number
     $phone_to_check = str_replace("-", "", $filtered_phone_number);
     // Check the lenght of number
     if (strlen($phone_to_check) < 10 || strlen($phone_to_check) > 16) {
        return false;
     } else {
       return true;
     }
}
    

    if(validate_phone_number($phone) != true ) {
        
        $formErrors [] = "phone number is not valid";
    }
    
    
   if(empty($formErrors)){

    try{
       
        $log = $db->query("SELECT email FROM visiters WHERE email = '$email';");

     if($log->rowCount() == 0){
        $stmt = $db->prepare("INSERT INTO visiters (firstName,lastName,phone,email,title,compName,jobTitle,
        compAddress,city,nationality,residence,otherInfo,interest,qrCode) 
        VALUES(?,?,?,?,?,?,?,?,?,?,?,?,?,?)");

        
    
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
            $otherInfo,
            $interest,
            $qrID
    ]);

    $count = $stmt->rowCount();

    if($count > 0){

        /// qr code show 
        $path = "QrCodes/";
        $file = $path .$qrID.".png";
        
         //// contact info
        //  $codeContents  = 'BEGIN:VCARD'."\n";
        //  $codeContents .= 'FN:'.$fname.  " " . $lname . "\n";
        //  $codeContents .= 'ID:'.$qrID."\n";
        //  $codeContents .= 'TEL;WORK;VOICE:'.$phone."\n";
        //  $codeContents .= 'ORG:'.$compName."\n";
        //  $codeContents .= 'END:VCARD';    
        


        $addressLabel     = $compAddress;
        $addressPobox     = '';
        $addressExt       = '';
        $addressStreet    = '';
        $addressTown      = $city;
        $addressRegion    = '';
        $addressPostCode  = '';
        $addressCountry   = $resid;

          // we building raw data
        $codeContents  = 'BEGIN:VCARD'."\n";
        $codeContents .= 'VERSION:2.1'."\n";
        $codeContents .= 'N:'.ucwords($fname).  " " . ucwords($lname) . "\n";
        $codeContents .= 'ORG:'.$compName."\n";
        $codeContents .= 'TEL;WORK;VOICE:'.$phone."\n";
        
        $codeContents .= 'ADR;TYPE=work;'.
            'LABEL="'.$addressLabel.'":'
            .$addressPobox.';'
            .$addressExt.';'
            .$addressStreet.';'
            .$addressTown.';'
            .$addressPostCode.';'
            .$addressCountry."\n";
       
         $codeContents .= 'EMAIL:'.$email."\n";
         $codeContents .= 'END:VCARD';
        
        QRcode::png($codeContents, $file, 'M', 5, 1);
        


        /// send email with qr code
        $subject = 'IREIF QR Code';
        $from = "info@loyalshow.com";
        $to = $email;
        $headers = "From: ".$from. "\r\n";
        $headers .= "MIME-Version: 1.0\r\n";
        $headers .= "Content-Type: text/html; charset=UTF-8\r\n";
        $headers .= "Reply-To:".$from."\r\n";
        $headers .= "Return-Path:".$from."\r\n";
      
        $msg ='

        <!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <meta http-equiv="X-UA-Compatible" content="IE=edge">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <style>
                    @import url("https://fonts.googleapis.com/css2?family=Poppins&display=swap");
                
                body{
                    margin: 0px;
                    padding: 0px;
                    box-sizing: border-box;
                    margin: auto;
                    font-family: "Poppins", sans-serif;
                    text-align: center;
                }
                section{
                    width: 500px;
                    box-sizing: border-box;
                    margin: auto;
                
                    text-align: center;
                    position: relative;
                }
                .par-result{
                    margin: auto;
                    font-size: 0.75rem;
                    margin-top: 20px;
                    width: 85%;
                    text-align: center;
                    margin-bottom: 40px;
                }
                .head-result{
                    font-size: 1.375rem;
                    margin-bottom: 31px;
                }
                .top-backbonee{
                    background-color: #3C3D59;
                    width: 100%;
                    height: 150px;
                }
                .logoe{
                    width:73%;
                    margin: auto;
                    text-align: center;
                }
                .logoe img{
                    width: 34%;
                    text-align: center;
                    justify-content: center;
                    background-color: #fff;
                    box-shadow: 5px 5px #D8D8DE;
        
                    padding: 20px 22%; 
        
                }
                .body-overhead-backbonee{
                    width: 73%;
                    margin: auto;
                    margin-top: 40px;
                    text-align: center;
                }
                .bottom-backbonee{
                    width: 100%;
                    position: absolute;
                    top: 20px;
                }    
                .qr{
                    width: 43%;
                    text-align: center;
                    justify-content: center;
                    margin: auto;
                }
                .qr img{
                    width: 100%;
                    text-align: center;
                    justify-content: center;
                }
                .bakg{
                    width: 100%;
                    height: 50px;
                    background-color: #3C3D59;
                    margin-bottom: 20px;
                }
            </style>
        </head>
        <body>
            <section>
                <div class="top-backbonee">
        
                </div>
                <div class="bottom-backbonee">
                    <div class="body-overhead-backbonee">
                        <div class="logoe">
                        <img src="https://loyalshow.com/ireif/testy2/Images/frame240.svg" alt="">
                        </div>
                        <h3 class="head-result">Thank you for Registering to IREIF ERBIL</h3>
                        <div class="qr">
                            <img src="https://loyalshow.com/ireif/testy2/QrCodes/'.$qrID.'.png" alt="">
                        </div>
                        <div> <p class="par-result">You can now <b>Print or Save an image of this QR code,</b> to be able to enter the event hall directly!</p></div>
                    </div>
                    <div class="bakg">
        
                    </div>
                </div>
            </section>
        </body>
        </html>

       ';
       
        mail($email,$subject,$msg,$headers);
        $qrImg = 'yes';
        
    }

     }else{

         $formErrors  [] =  'email has already registerd';
     }


}catch(PDOException $e){

    echo "ERROR" .$e->getMessage();
}
   
}

}