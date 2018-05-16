<?php
function getDb() {
    $db = new PDO("mysql:host=localhost;dbname=db", 'root', 'root');
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    return $db;
}
function prep($db, $sql, $arr=[]) {
    try {
        $stmt = $db->prepare($sql);
        if (count($arr) > 0){
            $stmt->execute($arr);
        } else {
            $stmt->execute();
        }
        return $stmt;
    } catch (PDOException $e) {
         handle_sql_errors($sql, $e->getMessage());
    }
}
function handle_sql_errors($query, $error_message) {
    echo $query;
    echo '<br>';
    echo $error_message;
    die;
}
?>
