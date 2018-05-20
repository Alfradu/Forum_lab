<html>
    <body>
        <div class="topbar">
            <label>[</label><a href="index.php" class="likeabutton">Forum</a><label>]</label>
            <label>[</label><a href="login.php" class="likeabutton">Login</a><label>]</label>
            <h1>Register new user</h1>
        </div>
        <div id="form-register">
            <div id="reg1">
                <form name="regForm" action="testreg.php" method="post" onsubmit="return validateRegister()">
                    <input type="email" id="mailval" class="new-forms" name="mail" placeholder="Mail..." required pattern=".*[@].*[.].*"><br>
                    <input type="password" id="passval" class="new-forms" name="pass" placeholder="Password..." required><br>
                    <input type="submit" id="new-button" value="Send">
                    <label id="err">Fields cannot be empty!</label>
                </form>
            </div>
        </div>
    </body>
</html>
