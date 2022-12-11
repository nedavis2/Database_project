<?php

require "../../connection.php";

try {
    $connection = new PDO($dsn, $username, $password, $options);

    $query_str = 
        "SELECT * 
        FROM work";

    $stmt = $connection->prepare($query_str);
    $stmt->execute();

    $results = $stmt->fetchAll();

} catch (PDOException $error) {
    echo "Database connection error: " . $error->getMessage() . "<BR>";
}

?>

<a href = "work_home.php">Back to work home page</a>

<?php 

if ($results && $stmt->rowCount() > 0) { ?>
    <h2>All work</h2>

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
    <blockquote>No results found for work.</blockquote>
<?php }

?>

<?php include "templates/footer.php"; ?>