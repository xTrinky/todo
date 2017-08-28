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



//add data from textbox to db
if (!empty($todotext)) {
$insert = 'INSERT INTO `to_do`.`data` (`todotext`,`todouname`,`mydate`,`color`,`colortext`,`textsize`)
VALUES ("'.mysqli_real_escape_string($conn, $todotext).'",
"'.mysqli_real_escape_string($conn, $_SESSION['login_user']).'",
"'.mysqli_real_escape_string($conn, $mydate).'",
"'.mysqli_real_escape_string($conn, $color).'",
"'.mysqli_real_escape_string($conn, $colortext).'",
"'.mysqli_real_escape_string($conn, $textsize).'"
)';
    
if (!mysqli_query($conn,$insert)){
  echo "Error adding values: " . mysqli_error($conn);
} else {

  header('Location: index.php');
}
exit;
}


//check for admin
$checkuser = mysqli_query($conn, "SELECT usertype FROM users WHERE username = '$user_check' ");
$user = mysqli_fetch_array($checkuser,MYSQLI_ASSOC);


//DELETE BUTTON function
if (!empty($delete)){
  $id  = intval($id);
  $del = "DELETE FROM data WHERE id = '$id'";
  if (!mysqli_query($conn, $del)) {
      echo "Error deleting table: " . mysqli_error($conn);
}
header('Location: index.php');
exit;
}


//select and order to-do text
$sqldata = "SELECT * FROM data ORDER BY done, mydate";
$result = mysqli_query($conn, $sqldata);
$numrow = mysqli_num_rows($result);


//Select to-do text with shareID
$sid = mysqli_query($conn, "SELECT * FROM users WHERE username='".$_SESSION['login_user']."'");
$sidconv = mysqli_fetch_assoc($sid);
$sidresult = $sidconv['id'];

$data = mysqli_query($conn, "SELECT * FROM data WHERE shareID = '$sidresult' ORDER BY mydate");
$datanum = mysqli_num_rows($data);


//SHARE FUNCTION
if (!empty($share)){
    $id  = intval($id);
    $share= mysqli_query($conn, "SELECT * FROM users WHERE username = '$share'");
    $shareID = mysqli_fetch_assoc($share);
    $shareIDfinal = $shareID['id'];
    $replace = "UPDATE data SET shareID = '$shareIDfinal' WHERE id = '$id'";
    //add data to db query
    if (!mysqli_query($conn,$replace)){
        echo "Error adding values: " . mysqli_error($conn);
    } else {

        header('Location: index.php');
    }
    exit;
}


//HIDE SHARE BUTTON
if (!empty($hide)){
    $id  = intval($id);
    $replace = "UPDATE data SET shareID = DEFAULT WHERE id = '$id'";
    if (!mysqli_query($conn,$replace)){
        echo "Error adding values: " . mysqli_error($conn);
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
  if (!mysqli_query($conn,$do)) {
    echo "Error inserting in table" . mysqli_error($conn);
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
  if (!mysqli_query($conn,$do)) {
    echo "Error inserting in table" . mysqli_error($conn);
  }
   sleep(1);
 header('Location: index.php');
  exit;
  }
  }
}


//logout button function!!
$logout = filter_input(INPUT_POST, 'logout');
if (session_status() == PHP_SESSION_ACTIVE) {
    if (isset($logout)) {
        session_destroy();
        header ("location: login.php?logout=1");
    }
}


//Close connection with DB
mysqli_close($conn);
?>
