<?php
include 'include/bootstrap.php';

if(!isset($_GET["id"])){
    header("Location: index.php");
}

$stmt = getcomments();
$id = $_GET["id"]
?>

<html>
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
            echo '<label>[</label><a href="javascript: deleteComment();" class="likeabutton">Delete</a><label>]</label>';
            ?>
            <form name="delForm" action="delete.php" method="post">
                <input type="hidden" name="checkArr" value=""/>
                <?php
                echo '<input type="hidden" name="currentPage" value="thread.php?id='.$id.'"/>';
                ?>
            </form>
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
                    echo '<input type="email" class="fields" name="mail" placeholder="Mail..." required pattern=".*[@].*[.].*"><br>';
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
                            echo '<div class="flowparent"><label style="color:#b294ac">'.$rows["name"]."</label> ".$rows["mail"]." (".$rows["date"].") No.";
                            echo '<a href="javascript:addToComment('.$rows["id"].');" name="'.$rows["id"].'" class="liketext" >'.$rows["id"].'</a> <br><br>';
                        } else {
                            echo '<div class="flowchild"><input type="checkbox" class= "check" name="'.$rows["id"].'"/> ';
                            echo $rows["name"]." ".$rows["mail"]." (".$rows["date"].") No.";
                            echo '<a href="javascript:addToComment('.$rows["id"].');" name="'.$rows["id"].'" class="liketext" >'.$rows["id"].'</a> <br><br>';
                        }
                        // if ($rows["comm"][0] == '>') //fix so entire text doesnt turn green
                        // {
                        //     echo '<div class="innerchild">';
                        //     echo '<span style="color:#789922">'.$rows["comm"].'</span>';
                        //     echo '</div>';
                        // }
                        // else
                        // {
                        //     echo '<div class="innerchild">'.$rows["comm"].'</div>';
                        // }
                        //Add functionality to upvote
                        echo '<div class="innerchild"><pre>'.referenceComment($rows["comm"], $rows["parent"]).'</pre></div>';
                        echo '</div><br>';
                    }
                }
            ?>
        </div>
        <a name="bottomOfPage"></a>
        <?php
        echo '<label>[</label><a href="thread.php?id='.$id.'#topOfPage" class="likeabutton">Top</a><label>]</label>';
        ?>
    </body>
</html>
