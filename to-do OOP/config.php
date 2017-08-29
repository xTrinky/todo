<?php
    //PRINT ERRORS
    ini_set('display_errors', 1);
    ini_set('error_reporting', E_ALL);



    //DATABASE LOGIN INFO
    $servername = "localhost";
    $username = "root";
    $password = "root";



    //DATABASE CONNECT
    $conn = new mysqli($servername, $username, $password);

    if ($conn->connect_error){
        die("Database Connection Failed" . $conn->connect_error);
    }



    //CATE DATABASE TO_DO
    $sql = "CREATE DATABASE IF NOT EXISTS to_do";

    if ($conn->query($sql) === FALSE) {
        die("Database Connection Failed" . $sql->connect_error);
    }



    //SELECT DATABASE
    $conn->select_db("to_do");

    if ($conn->connect_error){
        die("Database Selection Failed" . $mysqli->connect_error);
    }



    //CREATE TABLE for data
    $tabledata = "CREATE TABLE IF NOT EXISTS to_do.data (id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,todotext TEXT NOT NULL, color TEXT NOT NULL, colortext TEXT NOT NULL, textsize TEXT NOT NULL, tododate TIMESTAMP DEFAULT CURRENT_TIMESTAMP, mydate DATE DEFAULT NULL, todouname VARCHAR(250) NOT NULL, done BOOLEAN DEFAULT FALSE, shareID INT(6) UNSIGNED , KEY `shareID` (`shareID`), FOREIGN KEY (shareID) REFERENCES users(id)) ";

    if ($conn->query($tabledata) === FALSE) {
        die("Error creating table:" . $tabledata->error);
    }



    //CREATE TABLE for users
    $tableusers = "CREATE TABLE IF NOT EXISTS to_do.users (id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY, usertype VARCHAR(250) DEFAULT 'user', vorname VARCHAR(250) NOT NULL, nachname VARCHAR(250) NOT NULL, username VARCHAR(250) NOT NULL UNIQUE, mail VARCHAR(320) NOT NULL UNIQUE, password VARCHAR(250) NOT NULL, tm TIMESTAMP) ";

    if ($conn->query($tableusers) === FALSE) {
        die("Error creating table:" . $tableusers->error);
      }
?>
