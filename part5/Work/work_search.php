<?php

if (isset($_POST['submit'])) {
    require "../../connection.php";

    try {
        $connection = new PDO($dsn, $username, $password, $options);

        $query_str = 
            "SELECT * 
            FROM work
            WHERE teamID = :teamID";

        $teamID = $_POST['teamID'];

        $stmt = $connection->prepare($query_str);
        $stmt->bindParam(':teamID', $teamID, PDO::PARAM_STR);
        $stmt->execute();

        $results = $stmt->fetchAll();

    } catch (PDOException $error) {
        echo "Database connection error: " . $error->getMessage() . "<BR>";
    }
}

?>

<h2>Find work by development team ID</h2>

<form method = "post">
    <label for = "teamID">Development Team ID</label>
    <input type = "text" name = "teamID" id = "teamID">
    <input type = "submit" name = "submit" value = "View Results">
</form>

<a href = "work_home.php">Back to work home page</a>

<?php 

if (isset($_POST['submit'])) {
    if ($results && $stmt->rowCount() > 0) { ?>
        <h2>Results</h2>

        <table>
            <thead>
                <tr>
                    <th>dFname</th>
                    <th>dLname</th>
                    <th>dDateOfBirth</th>
                    <th>teamID</th>
                    <th>expID</th>
                </tr>
            </thead>
            <tbody>
        <?php foreach ($results as $row) { ?>
            <tr>
                <td><?php echo $row['dFname']; ?></td>
                <td><?php echo $row['dLname']; ?></td>
                <td><?php echo $row['dDateOfBirth']; ?></td>
                <td><?php echo $row['teamID']; ?></td>
                <td><?php echo $row['expID']; ?></td>
            </tr>
        <?php } ?>
        </tbody>
    </table>
    <?php } else { ?>
        <blockquote>No results found for <?php echo $_POST['teamID']; ?>.</blockquote>
    <?php }
}

?>

<?php include "templates/footer.php"; ?>