<?php
    include_once ("session.php");
    include_once ("config.php");


    //$id = filter_input(INPUT_GET, 'id');
    $id = $_GET['id'];


    $pquery = mysqli_query($conn, "SELECT * FROM `data` WHERE id='$id' ");
    $rowpass = mysqli_fetch_array($pquery,MYSQLI_ASSOC);


    if (isset($_POST['submit'])){
        $edit = $_POST['edit'];
        $editcolor = $_POST['color'];
        $editcolortext = $_POST['colortext'];
        $editdate = $_POST['mydate'];
        $replace = "UPDATE `data` SET todotext = '$edit', color= '$editcolor', colortext = '$editcolortext', mydate = '$editdate' WHERE id = '$id' ";
        //add data to db query
        if (!mysqli_query($conn,$replace)){
            echo "Error adding values: " . mysqli_error($conn);
        } else {

            header('Location: index.php');
        }
        exit;
    }
?>

<html xmlns="http://www.w3.org/1999/html">
<head>
    <head>
        <meta charset="utf-8">
        <title>Edit</title>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
        <link rel="stylesheet" href="https://formden.com/static/cdn/bootstrap-iso.css" />
        <link rel="stylesheet" href="https://formden.com/static/cdn/font-awesome/4.4.0/css/font-awesome.min.css" />
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
        <script src="inc/sweetalert.min.js"></script>
        <link href="https://fonts.googleapis.com/css?family=Berkshire+Swash" rel="stylesheet">
        <link rel="stylesheet" href="inc/style.css">
        <link rel="stylesheet" href="inc/sweetalert.css" />
        <link rel="stylesheet" href="inc/animate.css" />
    </head>
</head>
<body>
    <div class="col-sm-6 col-md-4 col-md-offset-4">
       <h1 style="color:#fff;font-family: 'Berkshire Swash';">Edit your TO-DO</h1>
       <br><br><br>
    </div>

    
    <br><br>
    

    <div class="form-group col-lg-8 col-lg-offset-2">

        <form action="<?php $url ?>" method="POST">

            <div class="col-md-3 col-sm-6 col-xs-12 col-md-offset-9">
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

            
        <div class="col-md-5 col-sm-6 col-xs-5">



            <select name="color">
                <option value="<?php echo $rowpass['color'] ?>">Background Color</option>
                <option value="white">White</option>
                <option value="black">Black</option>
                <option value="red">Red</option>
                <option value="green">Green</option>
                <option value="blue">Blue</option>
                <option value="purple">Purple</option>
                <option value="orange">Orange</option>
            </select>


            &nbsp&nbsp&nbsp


            <select name="colortext">
                <option value="<?php echo $rowpass['colortext'] ?>">Text Color</option>
                <option value="blacktext">Black</option>
                <option value="whitetext">White</option>
                <option value="redtext">Red</option>
                <option value="greentext">Green</option>
                <option value="bluetext">Blue</option>
                <option value="purpletext">Purple</option>
                <option value="orangetext">Orange</option>
            </select>


            &nbsp&nbsp&nbsp


            <select name="textsize">
                <option>Text Size</option>
                <option value="t2">14px</option>
                <option value="t4">18px</option>
                <option value="t5">20px</option>
                <option value="t6">22px</option>
                <option value="t7">24px</option>
            </select>
        </div>

            
        <br><br>

            
        <?php $url = "edit.php?id=".$id; $colors = $rowpass['textsize'] .' '. $rowpass['colortext'] . ' ' . $rowpass['color']; ?>
         <textarea type="text" name="edit" rows="8" class="form-control <?php echo $colors ?>" placeholder="Type your list">
                <?php echo $rowpass['todotext'] ?>
         </textarea><br><br>
            <input type="submit" value="Submit" name="submit" class="btn btn-success" />
    </form>
    </div>

</body>

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
        }).datepicker("setDate", "<?php echo $rowpass['mydate'] ?>")
    });
 </script>
</html>