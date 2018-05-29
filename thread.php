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
        <h1> Thread <?php echo $id;?></h1>
    </div>
    <?php
    if(isset($_SESSION["mail"])){
        echo '<div id="form">
        <label id="reply">Reply to thread </label>';
        echo $id;
        echo '<form name="commForm" action="process.php?id='.$id.'" method="post" onsubmit="return validateForm()">
        <label id="reply"> Mail: </label><input type="hidden" class="fields" name="mail" value="'.$_SESSION['mail'].'">'.$_SESSION['mail'].'</input>
        <input type="text" id="field-name" class="fields" name="name" placeholder="Name..." required>
        <textarea rows="10" id="field-text" cols="30" wrap="soft" class="fields" name="text" placeholder="Text..." required></textarea>
        <input type="submit" id="send-button" value="Send">
        <label id="err">Fields cannot be empty!</label>
        <input type="hidden" name="type" value="comment"/></form>';
    }
    ?>
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
                echo '<div class="flowparent"> '.$rows["mail"].' ('.$rows["date"].') No.
                <a href="javascript:addToComment('.$rows["id"].');" name="'.$rows["id"].'" class="liketext" >'.$rows["id"].'</a>
                <div class="innerchild"><h2>'.$rows['name'].'</h2><pre>'.referenceComment($rows["comm"], $rows["parent"]).'</pre></div>';
            } else {
                echo '<div class="flowchild"><input type="checkbox" class= "check" name="'.$rows["id"].'"/>
                '.$rows["name"].' '.$rows["mail"].' ('.$rows["date"].') No.
                <a href="javascript:addToComment('.$rows["id"].');" name="'.$rows["id"].'" class="liketext" >'.$rows["id"].'</a>
                <div class="innerchild"><pre>'.referenceComment($rows["comm"], $rows["parent"]).'</pre></div>';
            }
            echo '</div>';
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
