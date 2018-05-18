<?php
include 'include/bootstrap.php';

if(!isset($_GET["id"])){
    header("Location: index.php");
}
//Hide or show reply field
//if(!isset($_SESSION["ReplyVisibility"])){
//    $_SESSION["ReplyVisibility"] = false;
//}

$stmt = getcomments();
$id = $_GET["id"]
?>

<html>
    <head>
        <title>Forum</title>
        <meta charset="UTF-8">
        <link rel="stylesheet" href="assets/css/style.css">
        <script src="assets/js/script.js"></script>
    </head>
    <body>
        <div class="topbar">
            <?php
            echo '<label>[</label><a href="index.php" class="likeabutton">Return</a><label>]</label>';
            if(isset($_SESSION["mail"])){
                echo '<label>[</label><a href="logout.php" class="likeabutton">Logout</a><label>]</label>';
            } else {
                echo '<label>[</label><a href="register.php" class="likeabutton">Register</a><label>]</label>';
                echo '<label>[</label><a href="login.php" class="likeabutton">Login</a><label>]</label>';
            }
            ?>
            <h1> Forum </h1>
        </div>
        <div id="form">
            <label id="reply">Reply to thread</label>
            <?php
            echo $id;
            echo '<form name="commForm" action="process.php?id='.$id.'" method="post" onsubmit="return validateForm()">';
            ?>
                <?php
                if(isset($_SESSION["mail"])){
                    echo 'Mail: <input type="hidden" class="fields" name="mail" value="'.$_SESSION['mail'].'">'.$_SESSION['mail'].'</input><br>';
                } else {
                    echo '<input type="email" class="fields" name="mail" placeholder="Mail..." required pattern="*.[@].*.[.].*"><br>';
                }
                ?>
                <input type="text" id="field-name" class="fields" name="name" placeholder="Name..." required><br>
                <textarea rows="10" id="field-text" cols="30" wrap="soft" class="fields" name="text" placeholder="Text..." required></textarea><br>
                <input type="submit" id="send-button" value="Send">
                <label id="err">Fields cannot be empty!</label>
                <input type="hidden" name="type" value="comment"/>
            </form>
        </div>
        <a name="topOfPage"></a>
        <?php
        echo '<label>[</label><a href="thread.php?id='.$id.'#bottomOfPage" class="likeabutton">Bottom</a><label>]</label>';
        ?>
        <div id="flow">
            <?php
                while($rows = $stmt->fetch()){
                    if ($rows["parent"] == $id){
                        if ($rows["parent"] == $rows["id"]){
                            echo '<div class="flowparent"><input type="checkbox" name="box"/> <label style="color:#b294ac">'.$rows["name"]."</label> ".$rows["mail"]." (".$rows["date"].") No.";
                            echo '<a href="javascript:addToComment('.$rows["id"].');" name="'.$rows["id"].'" class="liketext" >'.$rows["id"].'</a> <br><br>';
                        } else {
                            echo '<div class="flowchild"><input type="checkbox" name="box"/> '.$rows["name"]." ".$rows["mail"]." (".$rows["date"].") No.";
                            echo '<a href="javascript:addToComment('.$rows["id"].');" name="'.$rows["id"].'" class="liketext" >'.$rows["id"].'</a> <br><br>';
                        }
                        if ($rows["comm"][0] == '>') //fix so entire text doesnt turn green
                        {
                            //$arr = explode('')
                            echo '<div class="innerchild"><span style="color:#789922">'.$rows["comm"].'</span></div>';
                        }
                        else
                        {
                            echo '<div class="innerchild">'.$rows["comm"].'</div>';
                        }
                        //Add functionality for replying to a post
                        //Add functionality for deleting posts or threads
                        //Add functionality to upboat
                        //Remove fields for nonloggedin people
                        echo '</div><br>';
                    }
                };
            ?>
        </div>
        <a name="bottomOfPage"></a>
        <?php
        echo '<label>[</label><a href="thread.php?id='.$id.'#topOfPage" class="likeabutton">Top</a><label>]</label>';
        ?>
    </body>
</html>
