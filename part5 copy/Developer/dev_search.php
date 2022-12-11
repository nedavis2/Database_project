<?php

if (isset($_POST['submit'])) {
    require "../../connection.php";

    try {
        $connection = new PDO($dsn, $username, $password, $options);

        $query_str = 
            "SELECT * 
            FROM developer
            WHERE fName = :fName";

        $fName = $_POST['fName'];

        $stmt = $connection->prepare($query_str);
        $stmt->bindParam(':fName', $fName, PDO::PARAM_STR);
        $stmt->execute();

        $results = $stmt->fetchAll();

    } catch (PDOException $error) {
        echo "Database connection error: " . $error->getMessage() . "<BR>";
    }
}

?>

<h2>Find developer by first name</h2>

<form method = "post">
    <label for = "fName">First Name</label>
    <input type = "text" name = "fName" id = "fName">
    <input type = "submit" name = "submit" value = "View Results">
</form>

<a href = "dev_home.php">Back to developer home page</a>

<?php 

if (isset($_POST['submit'])) {
    if ($results && $stmt->rowCount() > 0) { ?>
        <h2>Results</h2>

        <table>
            <thead>
                <tr>
                    <th>fName</th>
                    <th>lName</th>
                    <th>dateOfBirth</th>
                    <th>startDate</th>
                </tr>
            </thead>
            <tbody>
        <?php foreach ($results as $row) { ?>
            <tr>
                <td><?php echo $row['fName']; ?></td>
                <td><?php echo $row['lName']; ?></td>
                <td><?php echo $row['dateOfBirth']; ?></td>
                <td><?php echo $row['startDate']; ?></td>
            </tr>
        <?php } ?>
        </tbody>
    </table>
    <?php } else { ?>
        <blockquote>No results found for <?php echo $_POST['fName']; ?>.</blockquote>
    <?php }
}

?>

<?php include "templates/footer.php"; ?>