<?php

if (isset($_POST['submit'])) {
    require "../../connection.php";

    try {
        $connection = new PDO($dsn, $username, $password, $options);

        $new_devTeam = array(
            "teamID"        => $_POST['teamID'],
            "type"          => $_POST['type'],
            "description"   => $_POST['description']
        );

        $query_str = "INSERT INTO developmentTeam (teamID, type, description)
                        VALUES (:teamID,:type,:description)";

        $stmt = $connection->prepare($query_str);
        $stmt->execute($new_devTeam);

    } catch (PDOException $error) {
        echo "Database connection error: " . $error->getMessage() . "<BR>";
    }
}

?>

<?php include "templates/dt_header.php"; ?>

<?php if (isset($_POST['submit']) && $stmt) {?> 
    <blockquote><?php echo $_POST['teamID']; ?> successfully added.</blockquote>
<?php } ?>

<h2>Add a new development team</h2>

<form method = "post">
    <label for = "teamID">Team ID Number</label>
    <input type = "text" name = "teamID" id = "teamID">

    <label for = "type">Type of Team</label>
    <input type = "text" name = "type" id = "type">

    <label for = "description">Description of Team</label>
    <input type = "text" name = "description" id = "description">

    <input type = "submit" name = "submit" value = "Create">
</form>

<a href = "dt_home.php">Back to development team home page</a>

<?php include "templates/footer.php"; ?>