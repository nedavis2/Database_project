<?php

require "../../connection.php";

if (isset($_POST['submit'])) {
    try {
        $connection = new PDO($dsn, $username, $password, $options);
        
        $work = explode(" ", $_POST['work']);

        $work = [
            "dFname"        => $work[0],
            "dLname"        => $work[1],
            "dDateOfBirth"  => $work[2],
            "teamID"        => $work[3],
            "expID"         => $work[4]
        ];

        $query_str = "DELETE FROM work WHERE dFname = :dFname AND dLname = :dLname AND dDateOfBirth = :dDateOfBirth AND teamID = :teamID AND expID = :expID";
        
        $stmt = $connection->prepare($query_str);
        $stmt->execute($work);

        $success = "Work successfully deleted.";
    } catch (PDOException $error) {
        echo "Database connection error: " . $error->getMessage() . "<BR>";
    }
}

try {
    $connection = new PDO($dsn, $username, $password, $options);
    
    $query_str = "SELECT * FROM work";

    $stmt = $connection->prepare($query_str);
    $stmt->execute();

    $workResults = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $error) {
    echo "Database connection error: " . $error->getMessage() . "<BR>";
}
?>
        
<h2>Delete work</h2>

<form method = "post">
    <label for = "work-select">Work being deleted</label>
    <select name="work" id="work-select">
        <option selected>--Select Work--</option>
        <?php foreach ($workResults as $row) : ?>
            <option value="<?php echo $row['dFname']." ".$row['dLname']." ".$row['dDateOfBirth']." ".$row['teamID']." ".$row['expID']; ?>"><?php echo "dFname: ".$row['dFname']." | Team: ".$row['teamID']." | Experience: ".$row['expID']; ?></option>
        <?php endforeach; ?>
    </select>

    <input type = "submit" name = "submit" value = "Delete">
</form>

<a href = "work_home.php">Back to work home</a>

<?php include "templates/footer.php"; ?>