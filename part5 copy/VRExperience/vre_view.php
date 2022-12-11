<?php

require "../../connection.php";

try {
    $connection = new PDO($dsn, $username, $password, $options);

    $query_str = 
        "SELECT * 
        FROM VRExperience";

    $stmt = $connection->prepare($query_str);
    $stmt->execute();

    $results = $stmt->fetchAll();

} catch (PDOException $error) {
    echo "Database connection error: " . $error->getMessage() . "<BR>";
}

?>

<a href = "vrexp_home.php">Back to VR Experience home page</a>

<?php 

if ($results && $stmt->rowCount() > 0) { ?>
    <h2>All VR Experiences</h2>

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
    <blockquote>No results found for VR Expereinces.</blockquote>
<?php }

?>

<?php include "templates/footer.php"; ?>