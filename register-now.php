<?php

require_once 'backend.php';

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>IREIF</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="main">
        <section class="background-backbone">
            <div class="foreground-backbone">
                <div class="left-backbone">
                    <img src="Images/image6.svg" alt="" class="heading-img">
                    <div class="heading-text">
                        <h1>Welcome to IREIF ERBIL!</h1>
                        <p>Please fill this form to register to IREIF Conferance, It will take around <b>5 min</b> to finish the registration steps.</p>
                        <!-- <img src="Images/Group225.svg" alt="" class="bg-img"> -->
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
                  <!-- <img src="Images/Group225.svg" alt="bulding" class="img_bg" /> -->
                </div>
            </div>
            <div class="overhead-backbone">
                <form id="regForm" method="post" action="">
                    <div class="setps-background">
                        <div class="steps">
                            <div class="step">
                                <span class="circle-round"><p class="dis-num">1</p></span>
                                <p class="info">Personal Information</p>
                                <hr>
    
                            </div>
                            <div class="step">
                                <span class="circle-round"><p class="dis-num">2</p></span>
                                <p class="info">Professional Information</p>
                                <hr>
                            </div>
                            <div class="step">
                                <span class="circle-round"><p class="dis-num">3</p></span>
                                <p class="info">Final Step</p>  
                            </div>
                        </div>
                    </div>
                    <div class="body-overhead-backbone">
                        <div class="header-info">
                            <h3>Register to in to IREIF ERBIL</h3>
                            <p><b>Event Timing:</b> September 07th-10th, 2021<br><b>Event Address:</b> Erbil International Fair Ground<span class="required-right required-star">(*=Required)</span></p>
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
                            <div class="tab form-1">
                                <div class="title-input">
                                    <label for="">Title <span class="required-star">*</span></label>
                                    <br>
                                    <select name="title" id="" required>
                                        <option value="mr" >Mr.</option>
                                        <option value="mrs" >Mrs.</option>
                                        <option value="miss" >Miss</option>
                                        <option value="eng" >Eng.</option>
                                        <option value="dr" >Dr.</option>
                                        <option value="proff" >Proff.</option>


                                    </select>
                                </div>
                                <div class="info-inputs">
                                    <div>
                                        <label for="">First name <span class="required-star">*</span></label>
                                        <br>
                                        <input type="text"  required placeholder="Enter your user name"  name="fName">
                                    </div>
                                    <div>
                                        <label for="">Last name <span class="required-star">*</span></label>
                                        <br>
                                        <input type="text"  required placeholder="Enter your last name" name="lName" id="">
                                    </div>
                                </div>
                                <div class="email-input" >
                                    <label for="" id="validate">Email <span class="required-star">*</span></label>
                                    <br>
                                    <input type="email" id="email"  required placeholder="Ex. user@company.com" name="email"  onkeyup="validateemail();">
                                </div>

                            </div>
                            <div class="tab form-2">
                                <div class="email-input">
                                    <label for="">Mobile <span class="required-star">*</span></label>
                                    <br>
                                    <input type="tel" required  placeholder="Ex. 009647XXXXXXXX" name="phone" id="">
                                </div>
                                <div class="info-inputs">
                                    <div>
                                        <label for="">Address</label>
                                        <br>
                                        <input type="text"  placeholder="Enter company address" name="comAddress" value = "" id="">
                                    </div>
                                    <div>
                                        <label for="">City</label>
                                        <br>
                                        <input type="text"  placeholder="Enter your residance city" name="city" value = "" id="">
                                    </div>
                                </div>
                                <div class="info-inputs">
                                    <div>
                                        <label for="">Nationality</label>
                                        <br>
                                        <input type="text"  placeholder="Your nationality here" name="nationality" value = "" id="">
                                    </div>
                                    <div>
                                        <label for="">Country of Residence</label>
                                        <br>
                                        <input type="text"  placeholder="country of residence here" name="resid" value = "" id="">
                                    </div>
                                </div>
                            </div>
                            <div class="tab form-3">
                                <div class="info-inputs">
                                    <div>
                                        <label for="">Company Name</label>
                                        <br>
                                        <input type="text"  placeholder="Company name here" name="comName" value = "" id="">
                                    </div>
                                    <div>
                                        <label for="">Job Title</label>
                                        <br>
                                        <input type="text"  placeholder="Enter your Job Title" name="jobTitle"  value = "" id="">
                                    </div>
                                </div>
                                <div class="background-input">
                                    <p><b>I am Interested in</b></p>
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
                                <div class="tab form-4">
                                    <div class="email-input">
                                        <label for="">Please write any othe other info you want to add</label>
                                        <br>
                                        <input type="text" name="otherInfo" placeholder="Your answer" id="">
                                    </div>
                                </div>
                            </div>
                            <div class="next-step-button" id="toSubmit">
                            <button type="button"  id="nextBtn" class="nextButton arrow-bu" onclick="nextPrev(1)">Next</button>
                            </div>
                            <a href="javascript:void(0)" class="back-step-button" id="prevBtn" onclick="nextPrev(-1)">Back</a>

                        </div>
                        
                    </div>
                </form>
            </div>
        </section>

        <?php
            if(isset($qrImg)){
                
                echo ' 
                <section class="qrFrame">
        <div class="backk qrBox">
        <div class="bottom-backbonee">
            <div class="body-overhead-backbonee">
                <div class="qr">
                     <img src="'.$file.'" width="170" height="170">
                </div>
                <p class="par-result">You can now <b>Print or Save an image of this QR code,</b> to be able to enter the event hall directly!</p>
                <div class="next-step-buttone">
                    <a href="'.$file.'" download="IREIF" id="nextBtn" class="nextButtone">Save QR Image</a>
                </div>
                <a href="register-now.php" class="back-step-buttone" id="prevBtn">Close</a>
            </div>
        </div>
      </div>
      </section>
        
                
                ';
            }
        ?>
    </div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script type="text/javascript" src="JS/in.js"></script>
    
</body>
</html>