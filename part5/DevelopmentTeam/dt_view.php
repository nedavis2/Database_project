<?php

require "../../connection.php";

try {
    $connection = new PDO($dsn, $username, $password, $options);

    $query_str = 
        "SELECT * 
        FROM developmentTeam";

    $stmt = $connection->prepare($query_str);
    $stmt->execute();

    $results = $stmt->fetchAll();

} catch (PDOException $error) {
    echo "Database connection error: " . $error->getMessage() . "<BR>";
}

?>

<a href = "dt_home.php">Back to developers home page</a>

<?php 

if ($results && $stmt->rowCount() > 0) { ?>
    <h2>All development teams</h2>

    <table>
        <thead>
            <tr>
                <th>teamID</th>
                <th>type</th>
                <th>description</th>
            </tr>
        </thead>
        <tbody>
    <?php foreach ($results as $row) { ?>
        <tr>
            <td><?php echo $row['teamID']; ?></td>
            <td><?php echo $row['type']; ?></td>
            <td><?php echo $row['description']; ?></td>
        </tr>
    <?php } ?>
    </tbody>
</table>
<?php } else { ?>
    <blockquote>No results found for development teams.</blockquote>
<?php }

?>

<?php include "templates/footer.php"; ?>