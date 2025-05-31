<?php
require_once "dbconnection.php";
session_start();

// Execute for Sign-up Button
if($_SERVER['REQUEST_METHOD'] === "POST" && isset($_POST['signup'])) {
    $GET_NAME = $_POST["namePhp"];
    $GET_EMAIL=filter_input(INPUT_POST, 'emailPhp', FILTER_SANITIZE_EMAIL);
    $GET_PASSWORD = $_POST["passwordPhp"];
    $GET_CONFIRMEDPASSWORD = $_POST["CpasswordPhp"];
    $GET_HASHEDPASSWORD = password_hash($GET_PASSWORD, PASSWORD_DEFAULT);

    // VALIDATIONS
    //This array will store all the validation messsages
    $ERR_VALIDATION = [];

    //Checks if one of the input field is empty
    if(empty($GET_NAME) || empty($GET_EMAIL) || empty($GET_PASSWORD) || empty($GET_CONFIRMEDPASSWORD)) {
        $ERR_VALIDATION['ERR_MISSING_INPUT'] = 'some of the input fields are missing';
    }

    //Checks if one of the name is too short (minimum of 3)
    if(strlen($GET_NAME < 4)) {
        $ERR_VALIDATION['ERR_NAME_TO_SHORT'] = 'name is too short (min 3)';
    }
    //Checks email if its VALID
    if(!filter_var($GET_EMAIL, FILTER_VALIDATE_EMAIL)) {
        $ERR_VALIDATION['ERR_EMAIL_INVALID'] = 'invalid email format';
    }

    //Checks if the password is too short (minimum of 6)
    if(strlen($GET_PASSWORD) < 7) {
        $ERR_VALIDATION['ERR_PASSWORD_TOO_SHORT'] = 'Password is too short';
    }
    //Checks if the password contains any letters
    if (!preg_match("/[a-z]/i", $GET_PASSWORD)) {
    $ERR_VALIDATION['ERR_PASSWORD_NO_LETTER'] = 'Password must contain at least one letter';
    }
    //Checks if the password contains any number
    if (!preg_match("/[0-9]/", $GET_PASSWORD)) {
        $ERR_VALIDATION['ERR_PASSWORD_NO_NUMBER'] = 'Password must contain at least one number';
    }
    //Checks if the password contains any special characters
    if (!preg_match("/[\W]/", $GET_PASSWORD)) {
        $ERR_VALIDATION['ERR_PASSWORD_NO_CHAR'] = 'Password must contain at least one special character';
    }
    //Checks if password and comfirmed password value is match
    if($GET_PASSWORD !== $GET_CONFIRMEDPASSWORD) {
        $ERR_VALIDATION['ERR_PASSWORD_NOT_MATCH'] = 'Password did not match';
    }

    // Checks the email if it exist already in the database
    $stmt =$pdo->prepare('SELECT * FROM usersinformation WHERE email = :email');
    $stmt->execute(['email'=>$GET_EMAIL]);
    if($stmt->fetch()) {
        $ERR_VALIDATION['user_exist'] = 'Email is already registered';
    }

    //Checks if the ERROR VALIDATION it confirmed, it will redirect back to the signup.php
    if(!empty($ERR_VALIDATION)) {
        $_SESSION['ERR_VALIDATION'] = $ERR_VALIDATION;
        header("Location: signup.php");
        exit();
    }

    //Handling Form Excecution (Putting the input data's inside the XAMPP database)
    $stmt = $pdo->prepare('INSERT INTO usersinformation (Name,email,password_HASHED) VALUES (:user_name,:user_email,:user_password);');

    $stmt->execute([
        'user_name' => $GET_NAME,
        'user_email' => $GET_EMAIL,
        'user_password' => $GET_HASHEDPASSWORD
    ]);
    header("Location: signin.php");
    exit();
}

// Execute for Sign-in Button
 if($_SERVER['REQUEST_METHOD'] === "POST" && isset($_POST['signin'])) {
    $GET_EMAIL= filter_input(INPUT_POST, 'emailPhp', FILTER_SANITIZE_EMAIL);
    $GET_PASSWORD = $_POST["passwordPhp"];

    if(!filter_var($GET_EMAIL, FILTER_VALIDATE_EMAIL)) {
        $ERR_VALIDATION['ERR_EMAIL_INVALID'] = 'Invalid email format';
    }

    if(empty($GET_PASSWORD)) {
        $ERR_VALIDATION['ERR_PASSWORD_EMPTY'] = 'Password cannot be empty';
    }

    if(!empty($ERR_VALIDATION)) {
        $_SESSION['ERR_VALIDATION'] = $ERR_VALIDATION;
        header("Location: signin.php");
        exit();
    }

    $stmt = $pdo->prepare("SELECT * FROM usersinformation WHERE email = :users_email;");
    $stmt->execute(['users_email'=>$GET_EMAIL]);$user=$stmt->fetch();

    if($user && password_verify($GET_PASSWORD, $user['password_HASHED'])) {
        $_SESSION['user'] = [
            'id'=>$user['id'],
            'name'=>$user['Name'],
            'email'=>$user['email'],
            'created_at'=>$user['account_datecreated']
        ];
        header(("Location: homePage.php"));
        exit();
    }else {
        $ERR_VALIDATION['ERR_LOGIN_FAILED'] = 'invalid email or password';
        $_SESSION['ERR_VALIDATION'] = $ERR_VALIDATION;
        header('Location: signin.php');
        exit();
    }
} 