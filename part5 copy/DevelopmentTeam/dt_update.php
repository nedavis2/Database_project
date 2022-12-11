<?php

/**
 * List all users with a link to edit
 */

require "../../connection.php";

try {
    $connection = new PDO($dsn, $username, $password, $options);

    $query_str = "SELECT * FROM developmentTeam;";

    $stmt = $connection->prepare($query_str);
    $stmt->execute();

    $result = $stmt->fetchAll();
} catch (PDOException $error) {
    echo "Database connection error: " . $error->getMessage() . "<BR>";
}
?>

<a href="dt_home.php">Back to development team home</a>
        
<h2>Update development teams</h2>

<table>
    <thead>
        <tr>
            <th>teamID</th>
            <th>type</th>
            <th>description</th>
            <th>Edit</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($result as $row) : ?>
            <tr>
                <td><?php echo $row['teamID']; ?></td>
                <td><?php echo $row['type']; ?></td>
                <td><?php echo $row['description']; ?></td>
                <td><a href="dt_updater.php?teamID=<?php echo $row["teamID"]; ?>">Edit</a></td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<?php require "templates/footer.php"; ?>