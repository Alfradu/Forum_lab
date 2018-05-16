<?php
function getDb() {
    $db = new PDO("mysql:host=localhost;dbname=db", 'root', 'root');
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    return $db;
}
function prep($db, $sql) {
    try {
        $stmt = $db->prepare($sql);
        $stmt->execute();
        $db = NULL;
        return $stmt;
    } catch (PDOException $e) {
         handle_sql_errors($sql, $e->getMessage());
    }
}
function handle_sql_errors($query, $error_message) {
    echo '<pre>';
    echo $query;
    echo '</pre>';
    echo $error_message;
    die;
}
?>
