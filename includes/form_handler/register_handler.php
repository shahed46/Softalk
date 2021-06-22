<?php

$fname = ""; 
$lname = ""; 
$em = ""; 
$em2 = ""; 
$password = ""; 
$password2 = ""; 
$date = ""; 
$error_array = array(); //Holds error messages

if(isset($_POST['register_button'])){

    //Registration form values

    //First name
    $fname = strip_tags($_POST['reg_fname']); //Remove html tags
    $fname = str_replace(' ', '', $fname);//remove spaces
    $fname = ucfirst(strtolower($fname)); 
    $_SESSION['reg_fname'] = $fname; 
    //Last name
    $lname = strip_tags($_POST['reg_lname']); 
    $lname = str_replace(' ', '', $lname); 
    $lname = ucfirst(strtolower($lname)); 
    $_SESSION['reg_lname'] = $lname; 

    //email
    $em = strip_tags($_POST['reg_email']); 
    $em = str_replace(' ', '', $em); 
    $em = ucfirst(strtolower($em)); 
    $_SESSION['reg_email'] = $em; 

    //email 2
    $em2 = strip_tags($_POST['reg_email2']); 
    $em2 = str_replace(' ', '', $em2); 
    $em2 = ucfirst(strtolower($em2)); 
    $_SESSION['reg_email2'] = $em2; 

    //Password
    $password = strip_tags($_POST['reg_password']); 
    $password2 = strip_tags($_POST['reg_password2']); 

    $date = date("Y-m-d"); //Current date

    if($em == $em2) {
        //Check if email is in valid format 
        if(filter_var($em, FILTER_VALIDATE_EMAIL)) {

            $em = filter_var($em, FILTER_VALIDATE_EMAIL);

            //Check if email already exists 
            $e_check = mysqli_query($con, "SELECT email FROM users WHERE email='$em'");

            //Count the number of rows returned
            $num_rows = mysqli_num_rows($e_check);

            if($num_rows > 0) {
                array_push($error_array, "Email already in use<br>");
            }

        }
        else {
            array_push($error_array, "Invalid email format<br>");
        }


    }
    else {
        array_push($error_array, "Emails don't match<br>");
    }


    if(strlen($fname) > 25 || strlen($fname) < 2) {
        array_push($error_array, "Your first name must be between 2 and 25 characters<br>");
    }

    if(strlen($lname) > 25 || strlen($lname) < 2) {
        array_push($error_array,  "Your last name must be between 2 and 25 characters<br>");
    }

    if($password != $password2) {
        array_push($error_array,  "Your passwords do not match<br>");
    }
    else {
        if(preg_match('/[^A-Za-z0-9]/', $password)) {
            array_push($error_array, "Your password can only contain english characters or numbers<br>");
        }
    }

  


    if(empty($error_array)) {
        $password = md5($password); //Encrypting password before sending to database

        //Generating  username 
        $username = strtolower($fname . "_" . $lname);
        $check_username_query = mysqli_query($con, "SELECT username FROM users WHERE username='$username'");


        $i = 0; 
        //if username exists add number to username
        while(mysqli_num_rows($check_username_query) != 0) {
            $i++; 
            $username = $username . "_" . $i;
            $check_username_query = mysqli_query($con, "SELECT username FROM users WHERE username='$username'");
        }

        

      
            $profile_pic = "assets/images/profile_pic/defaults/download.png";
    

        $query = mysqli_query($con, "INSERT INTO users VALUES ('', '$fname', '$lname', '$username', '$em', '$password', '$date', '$profile_pic', '0', '0', 'no', ',')");

       array_push($error_array, "<span style='color: #14C800;'>You're all set! Goahead and login!</span><br>");

        //Clear session variables 
        $_SESSION['reg_fname'] = "";
        $_SESSION['reg_lname'] = "";
        $_SESSION['reg_email'] = "";
        $_SESSION['reg_email2'] = "";
    }

}

?>