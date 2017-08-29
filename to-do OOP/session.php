<?php
session_start();

include_once ('config.php');


$user_check = $_SESSION['login_user'];


$sqluser = $conn->query("SELECT * FROM users WHERE username = '$username'");


$rowuser = $sqluser->fetch_array(MYSQLI_ASSOC);


$login_session = $rowuser['username'];


if (!isset($_SESSION['login_user'])){
  header ("Location: login.php");
}
?>
