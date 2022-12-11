<?php

require "../../connection.php";

if (isset($_POST['submit'])) {
    try {
        $connection = new PDO($dsn, $username, $password, $options);
        
        $exp = explode(" ", $_POST['experience']);

        $exp = [
            "expID"             => $exp[0],
            "maintainerFName"   => $exp[1],
            "maintainerLName"   => $exp[2],
            "maintainerDOB"     => $exp[3],
            "name"              => $exp[4],
            "type"              => $exp[5]
        ];

        $query_str = "DELETE FROM VRExperience WHERE expID = :expID AND maintainerFName = :maintainerFName AND maintainerLName = :maintainerLName AND maintainerDOB = :maintainerDOB AND name = :name AND type=:type";
        
        $stmt = $connection->prepare($query_str);
        $stmt->execute($exp);

        $success = "Experience successfully deleted.";
    } catch (PDOException $error) {
        echo "Database connection error: " . $error->getMessage() . "<BR>";
    }
}

try {
    $connection = new PDO($dsn, $username, $password, $options);
    
    $query_str = "SELECT * FROM VRExperience";

    $stmt = $connection->prepare($query_str);
    $stmt->execute();

    $vreResults = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $error) {
    echo "Database connection error: " . $error->getMessage() . "<BR>";
}
?>
        
<h2>Delete an experience</h2>

<form method = "post">
    <label for = "exp-select">Experience to delete</label>
    <select name="experience" id="exp-select">
        <option selected>--Select Experience--</option>
        <?php foreach ($vreResults as $row) : ?>
          <option value="<?php echo $row['expID']." ".$row['maintainerFName']." ".$row['maintainerLName']." ".$row['maintainerDOB']." ".$row['name']." ".$row['type']; ?>"><?php echo $row['expID']." ".$row['name'].", ".$row['type']; ?></option>
        <?php endforeach; ?>
    </select>

    <input type = "submit" name = "submit" value = "Delete">
</form>

<a href = "vrexp_home.php">Back to experience home</a>

<?php include "templates/footer.php"; ?>