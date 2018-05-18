<?php
include 'include/bootstrap.php';

$stmt = getcomments();
?>
<html>
    <body>
        <div class="topbar">
            <?php
            if(isset($_SESSION["mail"])){
                echo '<label>[</label><a href="logout.php" class="likeabutton">Logout</a><label>]</label>';
            } else {
                echo '<label>[</label><a href="register.php" class="likeabutton">Register</a><label>]</label>';
                echo '<label>[</label><a href="login.php" class="likeabutton">Login</a><label>]</label>';
            }
            ?>
            <h1> Forum </h1>
        </div>
        <?php
            if(isset($_SESSION["mail"])){
                echo '<div id="form">';
                echo '<label id="reply">Create new thread</label>';
                echo '<form name="commForm" action="process.php" method="post" onsubmit="return validateForm()">';
                echo 'Mail: <input type="hidden" class="fields" name="mail" value="'.$_SESSION['mail'].'">'.$_SESSION['mail'].'</input><br>';
                echo '<input type="text" id="field-name" class="fields" name="name" placeholder="Topic..." required><br>';
                echo '<textarea rows="10" id="field-text" cols="30" wrap="soft" class="fields" name="text" placeholder="Text..." required></textarea><br>';
                echo '<input type="submit" id="send-button" value="Create">';
                echo '<label id="err">Fields cannot be empty!</label>';
                echo '<input type="hidden" name="type" value="thread"/></form></div>';
            }
        ?>
        <a name="topOfPage"></a>
        <?php
        echo '<label>[</label><a href="index.php#bottomOfPage" class="likeabutton">Bottom</a><label>]</label>';
        ?>
        <div id="flow">
            <?php
                while($rows = $stmt->fetch()){
                    if ($rows["parent"] == $rows["id"]){
                        echo '<div class="flowchild"><input type="checkbox" name="box"/> <label style="color:#b294ac">'.$rows["name"]."</label> ".$rows["mail"]." (".$rows["date"].") No.";
                        echo '<a href="thread.php?id='.$rows["id"].'" name="'.$rows["id"].'" class="liketext" >'.$rows["id"].'</a> ';
                        echo '<label>[</label><a href="thread.php?id='.$rows["id"].'" class="likeabutton">Reply</a><label>]</label> <br><br>';
                    if ($rows["comm"][0] == '>')
                    {
                        echo '<div class="innerchild"><span style="color:#789922">'.$rows["comm"].'</span></div>';
                    }
                    else
                    {
                        echo '<div class="innerchild">'.$rows["comm"].'</div>';
                    }
                    echo '</div><br>';
                    }
                }
            ?>
        </div>
        <a name="bottomOfPage"></a>
        <?php
        echo '<label>[</label><a href="index.php#topOfPage" class="likeabutton">Top</a><label>]</label>';
        ?>
    </body>
</html>
