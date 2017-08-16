<?php
session_start();
include_once ('config.php');

$user_check = $_SESSION['login_user'];

$sqluser = mysqli_query($conn,"SELECT * FROM users WHERE username = '$username'");

$rowuser = mysqli_fetch_array($sqluser,MYSQLI_ASSOC);

$login_session = $rowuser['username'];

if (!isset($_SESSION['login_user'])){
  header ("Location: login.php");
}
?>
