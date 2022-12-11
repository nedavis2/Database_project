<?php

require "../../connection.php";

if (isset($_POST['submit'])) {
    try {
        $connection = new PDO($dsn, $username, $password, $options);
        
        $developer = explode(" ", $_POST['developer']);

        $dev = [
            "fName"         => $developer[0],
            "lName"         => $developer[1],
            "dateOfBirth"   => $developer[2],
            "startDate"     => $developer[3]
        ];

        $query_str = "DELETE FROM developer WHERE fName = :fName AND lName = :lName AND dateOfBirth = :dateOfBirth AND startDate = :startDate";
        
        $stmt = $connection->prepare($query_str);
        $stmt->execute($dev);

        $success = "Developer successfully deleted.";
    } catch (PDOException $error) {
        echo "Database connection error: " . $error->getMessage() . "<BR>";
    }
}

try {
    $connection = new PDO($dsn, $username, $password, $options);
    
    $query_str = "SELECT * FROM developer";

    $stmt = $connection->prepare($query_str);
    $stmt->execute();

    $devResults = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $error) {
    echo "Database connection error: " . $error->getMessage() . "<BR>";
}
?>
        
<h2>Delete a developer</h2>

<form method = "post">
    <label for = "dev-select">Developer to delete</label>
    <select name="developer" id="dev-select">
        <option selected>--Select Developer--</option>
        <?php foreach ($devResults as $row) : ?>
          <option value="<?php echo $row['fName']." ".$row['lName']." ".$row['dateOfBirth']." ".$row['startDate']; ?>"><?php echo $row['fName'].", ".$row['lName'].", ".$row['dateOfBirth']." | Started: ".$row['startDate']; ?></option>
        <?php endforeach; ?>
    </select>

    <input type = "submit" name = "submit" value = "Delete">
</form>

<a href = "dev_home.php">Back to developer home</a>

<?php include "templates/footer.php"; ?>