<?php

require "../../connection.php";

if (isset($_GET['teamID'])) {
    try {
        $connection = new PDO($dsn, $username, $password, $options);
        $teamID = $_GET['teamID'];

        $query_str = "DELETE FROM developmentTeam WHERE teamID = :teamID";
        
        $stmt = $connection->prepare($query_str);
        $stmt->bindParam('teamID', $teamID);
        $stmt->execute();

        $success = "Development team successfully deleted.";
    } catch (PDOException $error) {
        echo "Database connection error: " . $error->getMessage() . "<BR>";
    }
}

try {
    $connection = new PDO($dsn, $username, $password, $options);
    
    $query_str = "SELECT * FROM developmentTeam";

    $stmt = $connection->prepare($query_str);
    $stmt->execute();

    $result = $stmt->fetchAll();
} catch (PDOException $error) {
    echo "Database connection error: " . $error->getMessage() . "<BR>";
}
?>

<a href="dt_home.php">Back to development team home</a>
        
<h2>Delete a development team</h2>

<?php if ($success) echo $success; ?>

<table>
    <thead>
        <tr>
            <th>teamID</th>
            <th>type</th>
            <th>description</th>
            <th>Delete</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($result as $row) : ?>
            <tr>
                <td><?php echo $row['teamID']; ?></td>
                <td><?php echo $row['type']; ?></td>
                <td><?php echo $row['description']; ?></td>
                <td><a href="dt_delete.php?teamID=<?php echo $row["teamID"]; ?>">Delete</a></td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<?php require "templates/footer.php"; ?>