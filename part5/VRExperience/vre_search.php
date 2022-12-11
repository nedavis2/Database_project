<?php

if (isset($_POST['submit'])) {
    require "../../connection.php";

    try {
        $connection = new PDO($dsn, $username, $password, $options);

        $query_str = 
            "SELECT * 
            FROM VRExperience
            WHERE expID = :expID";

        $expID = $_POST['expID'];

        $stmt = $connection->prepare($query_str);
        $stmt->bindParam(':expID', $expID, PDO::PARAM_STR);
        $stmt->execute();

        $results = $stmt->fetchAll();

    } catch (PDOException $error) {
        echo "Database connection error: " . $error->getMessage() . "<BR>";
    }
}

?>

<h2>Find VR Experience by ID number</h2>

<form method = "post">
    <label for = "expID">VR Experience ID number</label>
    <input type = "text" name = "expID" id = "expID">
    <input type = "submit" name = "submit" value = "View Results">
</form>

<a href = "vrexp_home.php">Back to vr experience's home page</a>

<?php 

if (isset($_POST['submit'])) {
    if ($results && $stmt->rowCount() > 0) { ?>
        <h2>Results</h2>

        <table>
            <thead>
                <tr>
                    <th>expID</th>
                    <th>maintainerFName</th>
                    <th>maintainerLName</th>
                    <th>maintainerDOB</th>
                    <th>name</th>
                    <th>type</th>
                </tr>
            </thead>
            <tbody>
        <?php foreach ($results as $row) { ?>
            <tr>
                <td><?php echo $row['expID']; ?></td>
                <td><?php echo $row['maintainerFName']; ?></td>
                <td><?php echo $row['maintainerLName']; ?></td>
                <td><?php echo $row['maintainerDOB']; ?></td>
                <td><?php echo $row['name']; ?></td>
                <td><?php echo $row['type']; ?></td>
            </tr>
        <?php } ?>
        </tbody>
    </table>
    <?php } else { ?>
        <blockquote>No results found for <?php echo $_POST['expID']; ?>.</blockquote>
    <?php }
}

?>

<?php include "templates/footer.php"; ?>