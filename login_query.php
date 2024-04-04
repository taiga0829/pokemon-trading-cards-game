<?php
session_start();

$username = $_POST["username"];
$password = $_POST["password"];
// 1. Open the file that contains user database

$users = json_decode(file_get_contents("users.json"), true);

// 2. See if username from parameters is in the users database
$user_from_db = current(array_filter($users, function ($element) use ($username) {
    return $element["username"] == $username;
})); // we use current to return the first element from the filtered array 
// 3. If it contains the user then check that the password in the parameters is correct
// 4. Redirect back to the index.php if user credentials are correct, otherwise back to login.php
if (isset($user_from_db) && $user_from_db["password"] == $password) {
    header("Location: index.php");
    // 5. On correct credentials, store user in the session
    $_SESSION["user"] = $user_from_db["username"];
} else {
    header("Location: login.php");
}
?>