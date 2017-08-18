<?php
    //DATABASE LOGIN
    $servername = "localhost";
    $username = "root";
    $password = "root";

    //PRINT ERRORS
    ini_set('display_errors', 1);

    //DATABASE CONNECT
    $conn = mysqli_connect($servername, $username, $password);

    //CHECK CONNECTION
    if (!$conn){
        die("Database Connection Failed" . mysqli_error($conn));
    }

    //CATE DATABASE TO_DO
    $sql = "CREATE DATABASE IF NOT EXISTS to_do";

    //CHECK IF DATABASE IS CREATED
    if (!mysqli_query($conn, $sql)) {
        echo "Error creating database: " . mysqli_error($conn);
    }

    //SELECT DATABASE
    $select_db = mysqli_select_db($conn, 'to_do');

    //CHECK DATABASE
    if (!$select_db){
        die("Database Selection Failed" . mysqli_error($conn));
    }

    //CREATE TABLE for data
    $tabledata = "CREATE TABLE IF NOT EXISTS to_do.data (id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,todotext TEXT NOT NULL, color TEXT NOT NULL, colortext TEXT NOT NULL, tododate TIMESTAMP DEFAULT CURRENT_TIMESTAMP, mydate DATE DEFAULT NULL, todouname VARCHAR(250) NOT NULL, done BOOLEAN DEFAULT FALSE) ";

    //TABLE QUERY for data
    if (!mysqli_query($conn, $tabledata)) {
        echo "Error creating table: " . mysqli_error($conn);
    }

    //CREATE TABLE for users
    $tableusers = "CREATE TABLE IF NOT EXISTS to_do.users (id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY, vorname VARCHAR(250) NOT NULL, nachname VARCHAR(250) NOT NULL, username VARCHAR(250) NOT NULL UNIQUE, mail VARCHAR(320) NOT NULL UNIQUE, password VARCHAR(250) NOT NULL, tm TIMESTAMP) ";

    //TABLE QUERY for users
    if (!mysqli_query($conn, $tableusers)) {
        echo "Error creating table: " . mysqli_error($conn);
      }
?>
