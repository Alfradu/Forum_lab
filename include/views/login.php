<html>
    <body>
        <div class="topbar">
            <label>[</label><a href="index.php" class="likeabutton">Forum</a><label>]</label>
            <label>[</label><a href="register.php" class="likeabutton">Register</a><label>]</label>
            <h1>Log in</h1>
        </div>
        <div id="form-login">
            <div id="login1">
                <form name="regForm" action="testlogin.php" method="post" onsubmit="return validateLogin()">
                    <input type="email" class="new-forms" name="mail" placeholder="Mail..." required pattern=".*[@].*[.].*"><br>
                    <input type="password" id="passval" class="new-forms" name="pass" placeholder="Password..." required><br>
                    <input type="submit" id="new-button" value="Send">
                    <label id="err">Fields cannot be empty!</label>
                </form>
            </div>
            <div id="login2">
                <form name="sendMail" action="sendMail.php" method="post">
                    <input type="email" class="new-forms" name="mail" placeholder="Mail..." required pattern=".*[@].*[.].*"><br>
                    <input type="submit" id="mail-button" value="Reset password">
                </form>
            </div>
        </div>
    </body>
</html>
