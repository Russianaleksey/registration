<?php
session_start();

// initializing variables
$username = "";
$firstname = "";
$lastname = "";
$course = "";
$sponsor = "";
$email = "";
$email_c = "";
$errors = array();

// connect to the database
$db = mysqli_connect('localhost', 'aleksey', 'admin', 'test');

// REGISTER USER
if (isset($_POST['g-recaptcha-response']) && !empty($_POST['g-recaptcha-response'])) {
    $secret = '6LeeIcYUAAAAAHIhHh6u1bjhJajJ3wRfmIxVwx4a';
    $verifyResponse = file_get_contents('https://www.google.com/recaptcha/api/siteverify?secret=' . $secret . '&response=' . $_POST['g-recaptcha-response']);
    $responseData = json_decode($verifyResponse);
    if ($responseData->success) {
        $succMsg = 'Your contact request have submitted successfully.';
    } else {
        $errMsg = 'Robot verification failed, please try again.';
    }
}
// REGISTER USER
if (isset($_POST['reg_user'])) {
    // receive all input values from the form
    $username = mysqli_real_escape_string($db, $_POST['username']);
    $password_1 = mysqli_real_escape_string($db, $_POST['password_1']);
    $password_2 = mysqli_real_escape_string($db, $_POST['password_2']);
    $firstname = mysqli_real_escape_string($db, $_POST['firstname']);
    $lastname = mysqli_real_escape_string($db, $_POST['lastname']);
    $sponsor = mysqli_real_escape_string($db, $_POST['sponsor']);
    $course = mysqli_real_escape_string($db, $_POST['course']);
    $email = mysqli_real_escape_string($db, $_POST['email']);
    $email_c = mysqli_real_escape_string($db, $_POST['email_c']);
    $gender = $_POST['gender'];

    // form validation: ensure that the form is correctly filled ...
    // by adding (array_push()) corresponding error unto $errors array
    if (empty($username)) {
        array_push($errors, "Username is required");
    }
    if (empty($password_1)) {
        array_push($errors, "Password is required");
    }
    if ($password_1 != $password_2) {
        array_push($errors, "The two passwords do not match");
    }
    if ($email !== $email_c) {
        array_push($errors, "The emails entered do not match");
    }
    if (empty($email) || empty($email_c)) {
        array_push($errors, "Please enter an email");
    }

    // first check the database to make sure 
    // a user does not already exist with the same username and/or email
    $user_check_query = "SELECT * FROM voter_data WHERE username='$username' LIMIT 1";
    $result = mysqli_query($db, $user_check_query);
    $user = mysqli_fetch_assoc($result);

    if ($user) { // if user exists
        if ($user['username'] === $username) {
            array_push($errors, "Username already exists");
        }
    }

    // Finally, register user if there are no errors in the form
    if (count($errors) == 0) {
        $password = md5($password_1); //encrypt the password before saving in the database

        $unique_id = uniqid();
        $query = "INSERT INTO voter_data (voter_id, username, password, firstname, lastname, sponsor, course, sex, email) 
  			  VALUES('$unique_id','$username', '$password', '$firstname', '$lastname', '$sponsor', '$course', '$gender', '$email')";
        mysqli_query($db, $query);
        $_SESSION['username'] = $username;
        $_SESSION['success'] = "You are now logged in";
        header('location: index.php');
    }
}
if (isset($_POST['login_user'])) {
    $username = mysqli_real_escape_string($db, $_POST['username']);
    $password = mysqli_real_escape_string($db, $_POST['password']);

    if (empty($username)) {
        array_push($errors, "Username is required");
    }
    if (empty($password)) {
        array_push($errors, "Password is required");
    }

    if (count($errors) == 0) {
        $password = md5($password);
        $query = "SELECT * FROM voter_data WHERE username='$username' AND password='$password'";
        $results = mysqli_query($db, $query);
        if (mysqli_num_rows($results) == 1) {
            $_SESSION['username'] = $username;
            $_SESSION['success'] = "You are now logged in";
            header('location: index.php');
        } else {
            array_push($errors, "Wrong username/password combination");
        }
    }
}

if (isset($_POST['reset-password'])) {
    $email = mysqli_real_escape_string($db, $_POST['email']);

    $query = "SELECT * FROM voter_data WHERE email='$email'";
    $results = mysqli_query($db, $query);

    if (empty($email)) {
        array_push($errors, "Please enter an email");
    } else if (mysqli_num_rows($results) <= 0) {
        array_push($errors, "Sorry, but a user with that email is not registered in our system");
    }

    $token = bin2hex(random_bytes(50));

    if (count($errors) == 0) {
        $sql = "REPLACE INTO password_resets(email, token) VALUES ('$email', '$token')";
        $results = mysqli_query($db, $sql);

        $to = $email;
        $subject = "Voter Password Reset";
        $msg = "Hi there, click on this <a href=\"new_password.php?token=" . $token . "\">link</a> to reset your password on our site";
        $msg = wordwrap($msg, 70);
        $headers = "From: admin@localhost.com";
        mail($to, $subject, $msg, $headers);
        header('location: pending.php?email=' . $email);
    }
}

if (isset($_POST['new_password'])) {
    $new_pass = mysqli_real_escape_string($db, $_POST['new_pass']);
    $new_pass_c = mysqli_real_escape_string($db, $_POST['new_pass_c']);
    $token = $_POST['token'];

    if (empty($new_pass) || empty($new_pass_c)) array_push($errors, "Password is required");
    if ($new_pass !== $new_pass_c) array_push($errors, "Password do not match");
    if (count($errors) == 0) {
        // select email address of user from the password_reset table 
        $sql = "SELECT email FROM password_resets WHERE token='$token' LIMIT 1";
        $results = mysqli_query($db, $sql);
        $email = mysqli_fetch_assoc($results)['email'];

        if ($email) {
            $new_pass = md5($new_pass);
            $sql = "UPDATE voter_data SET password='$new_pass' WHERE email='$email'";
            $results = mysqli_query($db, $sql);
            header('location: index.php');
        }
    }
}
