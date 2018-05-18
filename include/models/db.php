<?php
function getDb() {
    $db = new PDO("mysql:host=localhost;dbname=db", 'root', 'root');
    //$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    return $db;
}
function makeUser($salt){
    $hashed_pass = sha1($_POST['pass'].$salt);
    $sql = "INSERT INTO user (mail, pass, salt) VALUES (:mail, :hashpass, :salt)";
    try {
        $stmt = getDb()->prepare($sql);
        $stmt->execute([
            ':mail' => $_POST['mail'],
            ':hashpass' => $hashed_pass,
            ':salt' => $salt
        ]);
        return $stmt;
    } catch (PDOException $e) {
         handle_sql_errors($sql, $e->getMessage());
    }
}
function createPost($tempID){
    $sql = "INSERT INTO comments (name, mail, comm, parent) VALUES (:name, :mail, :comm, :tempId)";
    try {
        $stmt = getDb()->prepare($sql);
        $stmt->execute([
            ':name'    => $_POST['name'],
            ':mail'    => $_POST['mail'],
            ':comm'    => $_POST['text'],
            ':tempId'  => $tempID
        ]);
        return $stmt;
    } catch (PDOException $e) {
         handle_sql_errors($sql, $e->getMessage());
    }
}
function getMaxId(){
    $sql = "SELECT MAX(id) AS p_id FROM comments";
    try {
        $stmt = getDb()->prepare($sql);
        $stmt->execute();
        return $stmt;
    } catch (PDOException $e) {
         handle_sql_errors($sql, $e->getMessage());
    }
}
function getUsers(){
    $sql = "SELECT * from user";
    try {
        $stmt = getDb()->prepare($sql);
        $stmt->execute();
        return $stmt;
    } catch (PDOException $e) {
         handle_sql_errors($sql, $e->getMessage());
    }
}
function getComments(){
    $sql = "SELECT * from comments";
    try {
        $stmt = getDb()->prepare($sql);
        $stmt->execute();
        return $stmt;
    } catch (PDOException $e) {
         handle_sql_errors($sql, $e->getMessage());
    }
}
function updatePass(){
    $sql = "UPDATE user SET pass='$token' WHERE mail= :mail";
    try {
        $stmt = getDb()->prepare($sql);
        $stmt->execute([
            ':mail' => $_POST['mail']
        ]);
        return $stmt;
    } catch (PDOException $e) {
         handle_sql_errors($sql, $e->getMessage());
    }
}
function handle_sql_errors($query, $error_message) {
    echo '"'.$query.'"';
    echo '<br>';
    echo $error_message;
    die;
}
?>
