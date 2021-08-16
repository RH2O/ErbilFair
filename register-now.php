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
    $hearedBy = isset($_POST['hearedBy']) ? $_POST['hearedBy'] : "";
    $bussiness = isset($_POST['business']) ? $_POST['business'] : "";
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
         $qrImg = 'yes';


        /// send email with qr code
        $subject = 'IREIF QR Code';
        $from = "noreply@gmail.com";
        $to = $email;
        $headers = "From: ".$from. "\r\n";
        $headers .= "MIME-Version: 1.0\r\n";
        $headers .= "Content-Type: text/html; charset=UTF-8\r\n";
        $headers .= "Reply-To:".$from."\r\n";
        $headers .= "Return-Path:".$from."\r\n";
        $headers .= "CC: ".$from."\r\n";
        $headers .= "BCC: hidden@example.com\r\n";

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
         <td><img src="https://loyalshow.com/ireif-erbil/QrCodes/'.$qrID.'.png" alt="QrCode" width="150" height="150"></td>
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
    <title>Document</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="icofont/icofont.min.css">
</head>

<body>
    <div class="main">
        <section class="background-backbone">
            <div class="foreground-backbone">
                <div class="left-backbone">
                    <img src="Images/image 6.svg" alt="" class="heading-img">
                    <div class="heading-text">
                        <h1>Welcome to IREIF ERBIL!</h1>
                        <p>Please fill this form to register to IREIF Conferance, It will take around <b>5 min</b> to
                            finish the registration steps.</p>
                        <img src="Images/Group 225.svg" alt="" class="bg-img">
                    </div>
                </div>
                <div class="right-backbone">
                </div>
            </div>
            <div class="bg">
                <!-- logo  -->
                <div class="logo_container">
                    <img src="Images/image 6.svg" alt="" class="form_logo" />
                </div>

                <!-- img -->
                <div class="img_container">
                    <img src="Images/Group 225.svg" alt="bulding" class="img_bg" />
                </div>
            </div>
            <div class="overhead-backbone">
                <form id="regForm" method="post" action="register-now.php">
                    <div class="setps-background">
                        <div class="steps">
                            <div class="step">
                                <span class="circle-round">1</span>
                                <p class="info">Personal Information</p>
                                <hr>
                            </div>
                            <div class="step">
                                <span class="circle-round">2</span>
                                <p class="info">Professional Information</p>
                                <hr>
                            </div>
                            <div class="step">
                                <span class="circle-round">3</span>
                                <p class="info">Final Step</p>
                            </div>
                        </div>
                    </div>
                    <div class="body-overhead-backbone">
                        <div class="header-info">
                            <h3>Register to in to IREIF ERBIL</h3>
                            <p><b>Event Timing:</b> September 07th-10th, 2021<br><b>Event Address:</b> Erbil
                                International Fair Ground<span class="required-right required-star">(*=Required)</span>
                            </p>
                            <p>
                                <?php
                                    if(isset($formErrors)){

                                        foreach ($formErrors as $err){

                                            echo "<div style='color:red'>" . $err . "</div>";
                                        }
                                    }
                                ?>
                            </p>
                        </div>
                        <div class="body-inputs">
                            <div class="tab">
                                <div class="title-input">
                                    <label for="">Title <span class="required-star">*</span></label>
                                    <br>
                                    <select name="title" id="" required>

                                        <option value="Mr.">Mr.</option>
                                        <option value="mrs.">Mrs.</option>
                                        <option value="Miss">Miss</option>
                                        <option value="Eng.">Eng.</option>
                                        <option value="Dr.">Dr.</option>
                                        <option value="proff.">proff.</option>

                                    </select>
                                </div>
                                <div class="info-inputs">
                                    <div>
                                        <label for="">First name <span class="required-star">*</span></label>
                                        <br>
                                        <input type="text" required placeholder="Enter your user name" name="fName"
                                            id="">
                                    </div>
                                    <div>
                                        <label for="">Last name <span class="required-star">*</span></label>
                                        <br>
                                        <input type="text" required placeholder="Enter your last name" name="lName"
                                            id="">
                                    </div>
                                </div>
                                <div class="email-input">
                                    <label for="">Email <span class="required-star">*</span></label>
                                    <br>
                                    <input type="email" required placeholder="Ex. user@company.com" name="email" id="">
                                </div>

                            </div>
                            <div class="tab">
                                <div class="email-input">
                                    <label for="">Mobile <span class="required-star">*</span></label>
                                    <br>
                                    <input type="tel" placeholder="Ex. 009647XXXXXXXX" name="phone" id="">
                                </div>
                                <div class="info-inputs">
                                    <div>
                                        <label for="">Address</label>
                                        <br>
                                        <input type="text" placeholder="Enter company address" name="comAddress" value = " " id="">
                                    </div>
                                    <div>
                                        <label for="">City</label>
                                        <br>
                                        <input type="text" placeholder="Enter your residance city" name="city" value = " " id="">
                                    </div>
                                </div>
                                <div class="info-inputs">
                                    <div>
                                        <label for="">Nationality</label>
                                        <br>
                                        <input type="text" placeholder="Your nationality here" name="nationality" value = " " id="">
                                    </div>
                                    <div>
                                        <label for="">Country of Residence</label>
                                        <br>
                                        <input type="text" placeholder="country of residence here" name="resid" value = " " id="">
                                    </div>
                                </div>
                            </div>
                            <div class="tab">
                                <div class="info-inputs">
                                    <div>
                                        <label for="">Company Name</label>
                                        <br>
                                        <input type="text" placeholder="Company name here"  name="comName" value = " " id="">
                                    </div>
                                    <div>
                                        <label for="">Job Title</label>
                                        <br>
                                        <input type="text" placeholder="Enter your Job Title" name="jobTitle"  value = " " id="">
                                    </div>
                                </div>
                                <div class="background-input">
                                    <p><b>Iam interested in</b></p>
                                    <div class="overhead-checkbox">
                                        <div>
                                            <input type="checkbox" name="interest[]" value="Exhibiting" id="">
                                            <label for="">Exhibiting</label>
                                        </div>
                                        <div>
                                            <input type="checkbox" name="interest[]" value="Visiting Exhibition" id="">
                                            <label for="">Visiting Exhibition</label>
                                        </div>
                                        <div>
                                            <input type="checkbox" name="interest[]" value="Attending Conferences"
                                                id="">
                                            <label for="">Attending Conferences</label>
                                        </div>
                                        <div>
                                            <input type="checkbox" name="interest[]" value="Sponsoring" id="">
                                            <label for="">Sponsoring</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="tab">
                                <div class="background-input">
                                    <p><b>Please indicate the nature of your business </b><span
                                            class="required-star">*</span></p>
                                    <div class="overhead-radio">
                                        <div>
                                            <input type="radio" name="business" value="developer" id="">
                                            <label for="">Developer</label>
                                        </div>
                                        <div>
                                            <input type="radio" name="business" value="investor" id="">
                                            <label for="">Investor</label>
                                        </div>
                                        <div>
                                            <input type="radio" name="business" value="Architect / Designer / Planner"
                                                id="">
                                            <label for="">Architect / Designer / Planner</label>
                                        </div>
                                        <div>
                                            <input type="radio" name="business" value="Consultant" id="">
                                            <label for="">Consultant</label>
                                        </div>
                                        <div>
                                            <input type="radio" name="business"
                                                value="Engineer / Construction / Contractor" id="">
                                            <label for="">Engineer / Construction / Contractor</label>
                                        </div>
                                        <div>
                                            <input type="radio" name="business" value="Government" id="">
                                            <label for="">Government</label>
                                        </div>
                                        <div>
                                            <input type="radio" name="business" value="Retailer" id="">
                                            <label for="">Retailer</label>
                                        </div>
                                        <div>
                                            <input type="radio" name="business" value="Media" id="">
                                            <label for="">Media</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="tab">
                                <div class="background-input">
                                    <p><b>How did you hear about the event?</b></p>
                                    <div class="overhead-radio">
                                        <div>
                                            <input type="radio" name="hearedBy" value="Email" id="">
                                            <label for="">Email</label>
                                        </div>
                                        <div>
                                            <input type="radio" name="hearedBy" value="SMS" id="">
                                            <label for="">SMS</label>
                                        </div>
                                        <div>
                                            <input type="radio" name="hearedBy" value="Brochure" id="">
                                            <label for="">Brochure</label>
                                        </div>
                                        <div>
                                            <input type="radio" name="hearedBy" value="our website" id="">
                                            <label for="">Our Website</label>
                                        </div>
                                        <div>
                                            <input type="radio" name="hearedBy" value="phone call" id="">
                                            <label for="">Phone Call</label>
                                        </div>
                                        <div>
                                            <input type="radio" name="hearedBy" value="Facebook" id="">
                                            <label for="">Facebook</label>
                                        </div>
                                        <div>
                                            <input type="radio" name="hearedBy" value="Twitter" id="">
                                            <label for="">Twitter</label>
                                        </div>
                                        <div>
                                            <input type="radio" name="hearedBy" value="Linkedin" id="">
                                            <label for="">Linkedin</label>
                                        </div>
                                        <div>
                                            <input type="radio" name="hearedBy" value="Other website" id="">
                                            <label for="">Other Website</label>
                                        </div>
                                        <div>
                                            <input type="radio" name="hearedBy" value="Outdoor advertising" id="">
                                            <label for="">Outdoor advertising</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="tab">
                                <div class="email-input">
                                    <label for="">Please write any othe other info you want to add</label>
                                    <br>
                                    <input type="text" name="" value = " " placeholder="Your answer" id="">
                                </div>
                            </div>
                        </div>
                        <div class="next-step-button" id="toSubmit">
                            <button type="button" id="nextBtn" onclick="nextPrev(1)">Next</button>
                        </div>

                        <button class="back-step-button" type="button" id="prevBtn" onclick="nextPrev(-1)">Back</button>
                    </div>

            </div>
            </form>
    </div>
    </section>

         <?php
            if(isset($qrImg)){
                
                echo ' 
                <section class="qrFrame">
                    <div class="qrBox">
                        <img src="'.$file.'" width="170" height="170">
                        <p>please Screenshot this QR Code here or in your email,to be able to enter the event hall directly</p>
                        <a class="closeQr" href="register-now.php">close</a>
                    </div>
                </section>';
            }
        ?>
    
    </div>


    <script type="text/javascript" src="JS/in.js"></script>

</body>

</html>


