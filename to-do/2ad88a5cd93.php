<html>
<head>
    <head>
        <meta charset="utf-8">
        <title>Admin panel</title>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
        <link rel="stylesheet" href="https://formden.com/static/cdn/bootstrap-iso.css" />
        <link rel="stylesheet" href="https://formden.com/static/cdn/font-awesome/4.4.0/css/font-awesome.min.css" />
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
        <script src="inc/sweetalert.min.js"></script>
        <link rel="stylesheet" href="inc/style.css">
        <link rel="stylesheet" href="inc/sweetalert.css" />
        <link rel="stylesheet" href="inc/animate.css" />
    </head>
</head>
<body>


<?php
include "config.php";
include "session.php";


$id = filter_input(INPUT_POST, 'id');
$deletedata = filter_input(INPUT_POST, 'deletedata');
$deleteusers = filter_input(INPUT_POST, 'deleteusers');


if (!empty($deletedata)){
    $id  = intval($id);
    $del = "DELETE FROM data WHERE id = '$id'";
    if (!mysqli_query($conn, $del)) {
        echo "Error deleting table: " . mysqli_error($conn);
    }
    header('Location: 2ad88a5cd93.php');
    exit;
}


if (!empty($deleteusers)){
    $id  = intval($id);
    $del = "DELETE FROM users WHERE id = '$id'";
    if (!mysqli_query($conn, $del)) {
        echo "Error deleting table: " . mysqli_error($conn);
    }
    header('Location: 2ad88a5cd93.php');
    exit;
}


$checkuser = mysqli_query($conn, "SELECT usertype FROM users WHERE username = '$user_check' ");
$user = mysqli_fetch_array($checkuser,MYSQLI_ASSOC);


//CHECK FOR ADMIN OR MOD
if ( $user['usertype'] == 'administrator' or $user['usertype'] == 'moderator' ){
    echo '<br><h4>Welcome back, ' . $user_check . '</h4>
           <a href="index.php">
              <input type=\'submit\' value=\'back to index\' class="btn btn-primary btn-xs">
          </a><br>';


 //ADMIN DELETE BUTTON tittle
       if ($user['usertype'] == 'administrator') {
            $deltitle = "<th>" .'DELETE'. "</th>";
       }

//USERS TABLE
$query = "SELECT * FROM users";
$result = mysqli_query($conn,$query);


echo "<h1>USERS</h1><br><br>";


echo '<table class="table">';
echo "<tr><th>ID</th><th>USERTYPE</th><th>VORNAME</th><th>NACHNAME</th><th>USERNAME</th><th>MAIL</th><th>PASSWORD</th><th>TM</th>". $deltitle  ."</tr>";


while($row = mysqli_fetch_array($result)){
    echo "<tr><td>" . $row['id'] . "</td><td>" . $row['usertype'] . "</td><td>" . $row['vorname'] . "</td><td>" . $row['nachname'] . "</td><td>" . $row['username'] . "</td><td>" . $row['mail'] . "</td><td>" . $row['password'] . "</td><td>" . $row['tm'] . "</td>";


    if ($user['usertype'] == 'administrator') {
        echo '<td>';
        echo '<form action="2ad88a5cd93.php" method="POST">';
        echo '<input type="hidden" name="id" value="' . $row['id'] . '">';
        echo '<input type="hidden" name="deleteusers" value="1">';
        echo "<input type='submit' value='Delete' class=\"btn btn-danger btn-xs warning\" >";
        echo '</form>';
        echo '</td>';
        echo '</tr>';
    }
}


echo "</table>";


//DATA TABLE
$query2 = "SELECT * FROM data";
$result2 = mysqli_query($conn,$query2);


echo "<h1>DATA</h1><br><br>";


echo '<table class="table">';
echo "<tr><th>ID</th><th>TODOTEXT</th><th>COLOR</th><th>COLORTEXT</th><th>TEXTSIZE</th><th>TODODATE</th><th>MYDATE</th><th>TODOUNAME</th><th>DONE</th><th>SHARE ID</th>". $deltitle  ."</tr>";


while($row = mysqli_fetch_array($result2)){
    echo "<tr><td>" . $row['id'] . "</td><td style=\"max-width:400px;overflow-wrap: break-word;\">" . $row['todotext'] . "</td><td>" . $row['color'] . "</td><td>" . $row['colortext'] . "</td><td>" . $row['textsize'] . "</td><td>" . $row['tododate'] . "</td><td>" . $row['mydate'] . "</td><td>" . $row['todouname'] . "</td><td>" . $row['done'] . "</td><td>" . $row['shareID'] . "</td>";


    if ($user['usertype'] == 'administrator') {
        echo '<td>';
        echo '<form action="2ad88a5cd93.php" method="POST">';
        echo '<input type="hidden" name="id" value="' . $row['id'] . '">';
        echo '<input type="hidden" name="deletedata" value="1">';
        echo "<input type='submit' value='Delete' class=\"btn btn-danger btn-xs warning\" >";
        echo '</form>';
        echo '</td>';
        echo '</tr>';
    }
}


echo "</table>";


//CLOSE CONNECTION WITH DB
mysqli_close($conn);
}else{
    //IF THE USERTYPE IS NOT ADMINISTRATOR
    header('Location: index.php');
    exit();
}
?>

</body>
<script>
$( ".warning" ).click(function(event) {
var $this = $(this);
event.preventDefault();
swal({
title: "Are you sure?",
text: "You will not be able to recover this TO-DO!",
type: "warning",
showCancelButton: true,
confirmButtonColor: "#DD6B55",
confirmButtonText: "Yes, delete it!",
closeOnConfirm: false
},
function(){
// swal("Deleted!", "Your imaginary file has been deleted.", "success");
$this.closest('form').submit();
});
});
</script>
</html>