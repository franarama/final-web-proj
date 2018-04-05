<?php
$conn = mysqli_connect('localhost', 'framunnow7', 'framunnow7424', 'COMP3540_framunno');

function insert_new_user($username, $password, $email) {
    global $conn;
    
    if (does_exist($username))
        return false;
    else {
        $sql = "insert into Users_Proj values (NULL, '$username', '$password', '$email', 	NULL)";
        $result = mysqli_query($conn, $sql);
        return $result;
    }
}

function is_valid($username, $password) {
    global $conn;
    
    $sql = "select * from Users_Proj where (username = '$username' and password = '$password')";
    $result = mysqli_query($conn, $sql);
    if (mysqli_num_rows($result) > 0)
        return true;
    else
        return false;
}

function does_exist($username) {
    global $conn;
    
    $sql = "select * from Users_Proj where (username = '$username')";
    $result = mysqli_query($conn, $sql);
    if (mysqli_num_rows($result) > 0)
        return true;
    else
        return false;
}

?>