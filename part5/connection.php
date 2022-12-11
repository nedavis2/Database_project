<?php
try  {
    require_once("dbconfig.php"); //database access details

    //Populate these four variables
    $host = "localhost";//Domain name of database server
    $dbname = "nedavis2";//name of your database
    $username = "nedavis2";//SQL user
    $options = null;

    configure($host, $username, $password, $options, $dbname, $dsn);

    $connection = new PDO($dsn, $username, $password, $options); //create database connection and get handler

} catch(PDOException $error) {
    //if connection failed, print error and exit;
    echo "Database connection error: " . $error->getMessage() . "<BR>";
    die;
}
?>
