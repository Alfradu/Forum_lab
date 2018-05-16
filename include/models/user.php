<?php
function makeUser() {
    return "INSERT INTO user (mail, pass, salt) VALUES (:mail, :hashpass, :salt)";
}
function createPost() {
    return "INSERT INTO comments (name, mail, comm, parent) VALUES (:name, :mail, :comm, :tempId)";
}
function getUsers() {
    return "SELECT * from user";
}
?>
