<?php
include_once ("config.php");
include_once ("session.php");



//POST INPUTS
$todotext = filter_input(INPUT_POST, 'todotext');
$mydate= filter_input(INPUT_POST, 'mydate');
$id = filter_input(INPUT_POST, 'id');
$color = filter_input(INPUT_POST, 'color');
$colortext = filter_input(INPUT_POST, 'colortext');
$textsize = filter_input(INPUT_POST, 'textsize');
$done = filter_input(INPUT_POST, 'done');
$undone = filter_input(INPUT_POST, 'undone');
$delete = filter_input(INPUT_POST, 'delete');
$share = filter_input(INPUT_POST, 'share');
$hide = filter_input(INPUT_POST, 'hide');
$logout = filter_input(INPUT_POST, 'logout');



$todotext = $conn->real_escape_string($todotext);
$mydate = $conn->real_escape_string($mydate);
$color = $conn->real_escape_string($color);
$colortext = $conn->real_escape_string($colortext);
$textsize = $conn->real_escape_string($textsize);
$lg = $conn->real_escape_string($_SESSION['login_user']);



//add data from textbox to db
if (!empty($todotext)) {
    $conn->query("INSERT INTO `to_do`.`data` (`todotext`,`todouname`,`mydate`,`color`,`colortext`,`textsize`)
                  VALUES('$todotext', '$lg', '$mydate', '$color', '$colortext', '$textsize')");
    
if ($conn->query() === FALSE){
    die("Error adding values:" . $conn->connect_error);
} else {

  header('Location: index.php');
}
exit;
}


//check for admin
$checkuser = $conn->query("SELECT usertype FROM users WHERE username = '$user_check' ");
$user = $checkuser->fetch_array(MYSQLI_ASSOC);


//DELETE BUTTON function
if (!empty($delete)){
  $id  = intval($id);
  $del = "DELETE FROM data WHERE id = '$id'";
  if ($conn->query($del) === FALSE) {
      die("Error deleting values:" . $conn->connect_error);
}
header('Location: index.php');
exit;
}


//select and order to-do text
$result = $conn->query("SELECT * FROM data ORDER BY done, mydate");
$numrow = $result->num_rows;


//Select to-do text with shareID
$sid = $conn->query("SELECT * FROM users WHERE username='".$_SESSION['login_user']."'");
$sidconv = $sid->fetch_array(MYSQLI_BOTH);
$sidresult = $sidconv['id'];

$data = $conn->query("SELECT * FROM data WHERE shareID = '$sidresult' ORDER BY mydate");
$datanum = $data->num_rows;


//SHARE FUNCTION
if (!empty($share)){
    $id  = intval($id);
    $share= $conn->query("SELECT * FROM users WHERE username = '$share'");
    $shareID = $share->fetch_assoc();
    $shareIDfinal = $shareID['id'];
    $replace = "UPDATE data SET shareID = '$shareIDfinal' WHERE id = '$id'";
    //add data to db query
    if ($conn->query($replace) === FALSE){
        die("Error deleting values:" . $conn->connect_error);
    } else {
        header('Location: index.php');
    }
    exit;
}


//HIDE SHARE BUTTON
if (!empty($hide)){
    $id  = intval($id);
    $replace = "UPDATE data SET shareID = DEFAULT WHERE id = '$id'";
    if ($conn->query($replace) === FALSE){
        die("Error deleting values:" . $conn->connect_error);
    } else {
        header('Location: index.php');
    }
    exit;
}


//Done Button Function
if (!empty($done)) {
   while($row = $result->fetch_assoc()) {
     if ($row['id'] == $id) {
  $do = "UPDATE data SET done='1' WHERE id = '$id'";
  if ($conn->query($do) === FALSE) {
      die("Error deleting values:" . $conn->connect_error);
  }
  sleep(1);
  header('Location: index.php');
  exit();
  }
  }
}


//Undone Button Function
if (!empty($undone)) {
   while($row = $result->fetch_assoc()) {
     if ($row['id'] == $id) {
    $do = "UPDATE data SET done='0' WHERE id = '$id'";
  if ($conn->query($do) === FALSE) {
      die("Error deleting values:" . $conn->connect_error);
  }
   sleep(1);
 header('Location: index.php');
  exit;
  }
  }
}


//logout button function!!
if (session_status() == PHP_SESSION_ACTIVE) {
    if (isset($logout)) {
        session_destroy();
        header ("location: login.php?logout=1");
    }
}


//Close connection with DB
mysqli_close($conn);
?>
