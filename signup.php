
<?php
session_start();
if(isset($_SESSION['ERR_VALIDATION'])) {
    $ERR_VALIDATION = $_SESSION['ERR_VALIDATION'];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up Page</title>
    <link rel="stylesheet" href="style.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=DM+Sans:ital,opsz,wght@0,9..40,100..1000;1,9..40,100..1000&display=swap" rel="stylesheet">
</head>
<body>
    <main>
        <div class="main_signup_page">
            <header>
                <div class="header_sample">
                    <div class="image_logo_container">
                        <img src="images/dotdotdot_logo.png" alt="dotdotdot_logo">
                    </div>
                </div>
            </header>

            <section>
                <div class="section_form">
                    <div class="section_form_header">
                        <h1>Create new Account</h1>
                    <a href="signin.php">Already Registered? Log in here.</a>
                    </div>
                    <form action="registrationFormHandler.php" method="POST" novalidate>
                        <div class="form_container">
                            <div class="form_card_container">
                                <label for="nameLabel">name</label>
                                <?php if(isset($ERR_VALIDATION['ERR_NAME_TO_SHORT'])){
                                    echo "<p id='ERROR_MSG_VALIDATION_DESIGN'>{$ERR_VALIDATION['ERR_NAME_TO_SHORT']}</p>";
                                }?>
                                <input type="text" name="namePhp" id="nameLabel" placeholder="Carlos Buclares" maxlength="11">
                            </div>
                            <div class="form_card_container">
                                <label for="emailLabel">email</label>
                                <?php if(isset($ERR_VALIDATION['user_exist'])){
                                    echo "<p id='ERROR_MSG_VALIDATION_DESIGN'>{$ERR_VALIDATION['user_exist']}</p>";
                                }elseif(isset($ERR_VALIDATION['ERR_EMAIL_INVALID'])){
                                    echo "<p id='ERROR_MSG_VALIDATION_DESIGN'>{$ERR_VALIDATION['ERR_EMAIL_INVALID']}</p>";
                                }?>
                                <input type="email" name="emailPhp" id="emailLabel" placeholder="jc.buclares@example.com" maxlength="320">
                            </div>
                            <div class="form_card_container">
                                <label for="passwordLabel">password</label>
                            <?php 
                            if(isset($ERR_VALIDATION['ERR_PASSWORD_TOO_SHORT'])){
                                    echo "<p id='ERROR_MSG_VALIDATION_DESIGN'>{$ERR_VALIDATION['ERR_PASSWORD_TOO_SHORT']}</p>";
                                }elseif(isset($ERR_VALIDATION['ERR_PASSWORD_NO_LETTER'])) {
                                    echo "<p id='ERROR_MSG_VALIDATION_DESIGN'>{$ERR_VALIDATION['ERR_PASSWORD_NO_LETTER']}</p>";
                                }
                                elseif(isset($ERR_VALIDATION['ERR_PASSWORD_NO_NUMBER'])) {
                                    echo "<p id='ERROR_MSG_VALIDATION_DESIGN'>{$ERR_VALIDATION['ERR_PASSWORD_NO_NUMBER']}</p>";
                                }
                                elseif(isset($ERR_VALIDATION['ERR_PASSWORD_NO_CHAR'])) {
                                    echo "<p id='ERROR_MSG_VALIDATION_DESIGN'>{$ERR_VALIDATION['ERR_PASSWORD_NO_CHAR']}</p>";
                                }?>
                                <input type="password" name="passwordPhp" id="passwordLabel" placeholder="******" maxlength="20">
                            </div>
                            <div class="form_card_container">
                                <label for="CpasswordLabel">confirm password</label>
                                <?php if(isset($ERR_VALIDATION['ERR_PASSWORD_NOT_MATCH'])){echo "<p id='ERROR_MSG_VALIDATION_DESIGN'>{$ERR_VALIDATION['ERR_PASSWORD_NOT_MATCH']}</p>";}?>
                                <input type="password" name="CpasswordPhp" id="CpasswordLabel" placeholder="******" maxlength="20">
                            </div>
                        </div>
                        <div class="submit_container">
                            <button name="signup">sign up</button>
                        </div>
                        <div class="input_field_missing_container_msg" style="text-align: center;"><?php if(isset($ERR_VALIDATION['ERR_MISSING_INPUT'])){echo "<p id='ERROR_MSG_VALIDATION_DESIGN'>{$ERR_VALIDATION['ERR_MISSING_INPUT']}</p>";}?></div>
                    </form>
                </div>
            </section>

        </div>
    </main>
</body>
</html>

<?php
// unsets the ERR_VALIDATION so that if site is refreshed, the error message is removed
if(isset($_SESSION['ERR_VALIDATION'])) {
    unset($_SESSION['ERR_VALIDATION']);
}
?>