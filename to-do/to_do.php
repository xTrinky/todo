<?php
include_once ("config.php");
include_once ("session.php");

$todotext = filter_input(INPUT_POST, 'todotext');
$mydate= filter_input(INPUT_POST, 'mydate');
$id = filter_input(INPUT_POST, 'id');
$color = filter_input(INPUT_POST, 'color');
$colortext = filter_input(INPUT_POST, 'colortext');

//add data to db
if (!empty($_POST['todotext'])) {
$insert = 'INSERT INTO `to_do`.`data` (`todotext`,`todouname`,`mydate`,`color`,`colortext`)
VALUES ("'.mysqli_real_escape_string($conn, $todotext).'",
"'.mysqli_real_escape_string($conn, $_SESSION['login_user']).'",
"'.mysqli_real_escape_string($conn, $mydate).'",
"'.mysqli_real_escape_string($conn, $color).'",
"'.mysqli_real_escape_string($conn, $colortext).'"
)';
//add data to db query
if (!mysqli_query($conn,$insert)){
  echo "Error adding values: " . mysqli_error($conn);
} else {

  header('Location: index.php');
}
exit;
}

//DELETE BUTTON function
if (!empty($id)){
  $id  = intval($id);
  $del = "DELETE FROM data WHERE id = '$id'";
  if (!mysqli_query($conn, $del)) {
      echo "Error creating table: " . mysqli_error($conn);
}
header('Location: index.php');
exit;
}
//look for usernames
$query = mysqli_query($conn, "SELECT * FROM users WHERE uname='$username'");
//order text
$sqldata = "SELECT * FROM data ORDER BY mydate";
$result = mysqli_query($conn, $sqldata);
$numrow = mysqli_num_rows($result);

mysqli_close($conn);
?>
