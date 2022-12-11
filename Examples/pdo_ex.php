<?php
error_reporting(E_ALL);
ini_set('display_errors', True);

require_once("password.php");

try {
    $pdo = new PDO("mysql:host=localhost;dbname:University", "nedavis2", $password);

    $all_data = "";

    $sql = "SELECT * FROM `instructor`;";

    $stat = $pdo -> prepare($sql);

    $stat -> execute();

    if ($stat) {
        $instrs = $stat -> fetchAll(PDO::FETCH_ASSOC);
        
    }
} catch (PDOException $error){
    echo "Database connection error: ",
    $error -> getMessage(), "<BR>";
    die;
}

?>