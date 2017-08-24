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

//add data to db
if (!empty($todotext)) {
$insert = 'INSERT INTO `to_do`.`data` (`todotext`,`todouname`,`mydate`,`color`,`colortext`,`textsize`)
VALUES ("'.mysqli_real_escape_string($conn, $todotext).'",
"'.mysqli_real_escape_string($conn, $_SESSION['login_user']).'",
"'.mysqli_real_escape_string($conn, $mydate).'",
"'.mysqli_real_escape_string($conn, $color).'",
"'.mysqli_real_escape_string($conn, $colortext).'",
"'.mysqli_real_escape_string($conn, $textsize).'"
)';
//add data to db query
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

//order text
$sqldata = "SELECT * FROM data ORDER BY done && mydate";
$result = mysqli_query($conn, $sqldata);
$numrow = mysqli_num_rows($result);

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
//Close connection with DB
mysqli_close($conn);
?>
