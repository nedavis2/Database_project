<?php

require "../../connection.php";

try {
    $connection = new PDO($dsn, $username, $password, $options);

    $query_str = 
        "SELECT * 
        FROM developer";

    $stmt = $connection->prepare($query_str);
    $stmt->execute();

    $results = $stmt->fetchAll();

} catch (PDOException $error) {
    echo "Database connection error: " . $error->getMessage() . "<BR>";
}

?>

<a href = "dev_home.php">Back to developers home page</a>

<?php 

if ($results && $stmt->rowCount() > 0) { ?>
    <h2>All developers</h2>

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
    <blockquote>No results found for developers.</blockquote>
<?php }

?>

<?php include "templates/footer.php"; ?>