<?php
include 'include/bootstrap.php';

if(isset($_SESSION["mail"])){
    header("Location: index.php");
}
?>
<html>
    <head>
        <title>Registration</title>
        <meta charset="UTF-8">
        <link rel="stylesheet" href="assets/css/style.css">
        <script src="assets/js/script.js"></script>
    </head>
    <body>
        <div class="topbar">
            <label>[</label><a href="index.php" class="likeabutton">Forum</a><label>]</label>
            <label>[</label><a href="login.php" class="likeabutton">Login</a><label>]</label>
            <h1>Register new user</h1>
        </div>
        <div id="form-register">
            <div id="reg1">
                <form name="regForm" action="testreg.php" method="post" onsubmit="return validateRegister()">
                    <input type="email" id="mailval" class="new-forms" name="mail" placeholder="Mail..." required pattern="*.[@].*.[.].*"><br>
                    <input type="password" id="passval" class="new-forms" name="pass" placeholder="Password..." required><br>
                    <input type="submit" id="new-button" value="Send">
                    <label id="err">Fields cannot be empty!</label>
                </form>
            </div>
        </div>
    </body>
</html>
