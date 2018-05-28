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
                echo '<label>[</label><a href="register.php" class="likeabutton">Register</a><label>]</label>
                     <label>[</label><a href="login.php" class="likeabutton">Login</a><label>]</label>';
            }
            echo '<label>[</label><a href="javascript: deleteComment();" class="likeabutton">Delete</a><label>]</label>';
            ?>
            <form name="delForm" action="delete.php" method="post">
                <input type="hidden" name="checkArr" value=""/>
                <input type="hidden" name="currentPage" value="index.php"/>
            </form>
            <h1> Forum </h1>
        </div>
        <?php
            if(isset($_SESSION["mail"])){
                echo '<div id="form">
                    <label id="reply">Create new thread</label>
                    <form name="commForm" action="process.php" method="post" onsubmit="return validateForm()">
                    Mail: <input type="hidden" class="fields" name="mail" value="'.$_SESSION['mail'].'">'.$_SESSION['mail'].'</input>
                    <input type="text" id="field-name" class="fields" name="name" placeholder="Topic..." required>
                    <textarea rows="10" id="field-text" cols="30" wrap="soft" class="fields" name="text" placeholder="Text..." required></textarea>
                    <input type="submit" id="send-button" value="Create">
                    <label id="err">Fields cannot be empty!</label>
                    <input type="hidden" name="type" value="thread"/></form>
                    </div>';
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
                        echo '<div class="flowchild"> <input type="checkbox" class= "check" name="'.$rows["id"].'"/>
                            '.$rows["mail"].' ('.$rows["date"].') No.
                            <a href="thread.php?id='.$rows["id"].'" name="'.$rows["id"].'" class="liketext" >'.$rows["id"].'</a>
                            <label>[</label><a href="thread.php?id='.$rows["id"].'" class="likeabutton">Reply</a><label>]</label>


                            <div class="innerchild"><h2>'.$rows["name"].'</h2>
                            <pre>'.referenceComment($rows["comm"], $rows["parent"]).'</pre></div>
                            </div>';
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
