<?php
include 'to_do.php';
//logout button function!!
$logout = filter_input(INPUT_POST, 'logout');
if (session_status() == PHP_SESSION_ACTIVE) {
   if (isset($logout)) {
     session_destroy();
     header ("location: login.php?logout=1");
   }
 }
?>
<html>
  <head>
    <meta charset="utf-8">
    <title>TO-DO</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://formden.com/static/cdn/bootstrap-iso.css" />
    <link rel="stylesheet" href="https://formden.com/static/cdn/font-awesome/4.4.0/css/font-awesome.min.css" />
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="style.css">
  </head>
  <body>
   <div class="container-fluid">
     <div class="col-md-3 col-md-offset-7">
       <form action="index.php" method="post">
         <?php echo "<span style=\"font-size:16px;color:#d3d3d3;\">Welcome back," . "   " . $_SESSION['login_user'] . "&nbsp&nbsp&nbsp" . "</span>"; ?>
         <input type="submit" value="Logout" name="logout" class="btn btn-danger"/>
       </form>
     </div>
   <div class="col-sm-6 col-md-4 col-md-offset-4">
     <h3 style="color:#fff;">Type your TO-DO's</h3>
     <br><br><br>
   </div>
   <br><br>
    <div class="form-group col-lg-8 col-lg-offset-2">
           <div class="col-md-3 col-sm-6 col-xs-12 col-md-offset-9">
            <form class="form-horizontal" action="index.php" method="post">
             <div class="form-group ">
              <div class="col-sm-10">
               <div class="input-group">
                <div class="input-group-addon">
                 <i class="fa fa-calendar">
                 </i>
                </div>
                <input class="form-control" id="mydate" name="mydate" type="text"/>
               </div>
              </div>
             </div>
           </div>
        <br><br>
        <div class="col-md-4 col-sm-6 col-xs-5">
        <span style="color:#FFF;font-size:12px;">Background Color</span>
        <select name="color">
            <option value="white">White</option>
            <option value="black">Black</option>
            <option value="red">Red</option>
            <option value="green">Green</option>
            <option value="blue">Blue</option>
            <option value="purple">Purple</option>
            <option value="orange">Orange</option>
        </select>
        &nbsp&nbsp&nbsp
        <span style="color:#FFF;font-size:12px;">Font Color</span>
        <select name="colortext">
            <option value="blacktext">Black</option>
            <option value="whitetext">White</option>
            <option value="redtext">Red</option>
            <option value="greentext">Green</option>
            <option value="bluetext">Blue</option>
            <option value="purpletext">Purple</option>
            <option value="orangetext">Orange</option>
        </select>
      </div>
      <br><br>
     <textarea type="text" name="todotext" rows="8" class="form-control" placeholder="Type your list"></textarea><br><br>
     <input type="submit" value="Submit" class="btn btn-success" /><br><br><br><br>
    </form>
      <br><br><br><br>
      <div class="container-fluid">
       <?php
           if ($numrow > 0 && $login_session == $rowuser) {
             while($row = $result->fetch_assoc()) {
               if ($row["todouname"] == $_SESSION['login_user']) {
              echo '<form action="index.php" method="POST">';
              echo "<table>";
              echo "<br>";
              echo "<p style=\"text-align:left;margin: 0 50px 10px;color:#fff;\">" . "<span style=\"font-size:11px;\">" .'You have something for '. '</span>' . htmlspecialchars($row["mydate"]) . "</p>";
              echo '<td class="col-md-2 mytodo '.$row['color'].'" >';
              echo '<p class="col-md-12 mytodotextt '.$row['colortext'].'">' . nl2br(htmlspecialchars($row["todotext"])) .  '</p>';
              echo "<td class=\"col-md-1\" style=\"font-size:10px;color:#d3d3d3;\">";
              echo '<input type="hidden" name="id" value="'.$row['id'].'">';
              echo "<input type='submit' value='Delete' class=\"btn btn-warning btn-xs\" style=\"float:right;\">";
              echo "<span>";
              echo "<br>";
              echo 'Posted on: ' . ' <br>' . htmlspecialchars($row['tododate']);
              echo "</span>";
              echo '</td>';
              echo '</table>';
              echo '</form>';
              }
              }
             }
        ?>
      </div>
   </div>
</body>
<!-- Date picker JS Code -->
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.4.1/js/bootstrap-datepicker.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.4.1/css/bootstrap-datepicker3.css"/>
<script>
	$(document).ready(function(){
		var date_input=$('input[name="mydate"]');
		var container=$('.bootstrap-iso form').length>0 ? $('.bootstrap-iso form').parent() : "body";
		date_input.datepicker({
			format: 'yyyy/mm/dd',
			container: container,
			todayHighlight: true,
      toggleActive: true,
			autoclose: true
		}).datepicker("setDate", "0")
	})
</script>
</html>
