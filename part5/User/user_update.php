<?php

/**
 * List all users with a link to edit
 */

require "../../connection.php";

try {
    $connection = new PDO($dsn, $username, $password, $options);

    $query_str = "SELECT * FROM user;";

    $stmt = $connection->prepare($query_str);
    $stmt->execute();

    $result = $stmt->fetchAll();
} catch (PDOException $error) {
    echo "Database connection error: " . $error->getMessage() . "<BR>";
}
?>

<a href="user_home.php">Back to users home</a>
        
<h2>Update users</h2>

<table>
    <thead>
        <tr>
            <th>fName</th>
            <th>lName</th>
            <th>dateOfBirth</th>
            <th>email</th>
            <th>streetAddr</th>
            <th>city</th>
            <th>state</th>
            <th>country</th>
            <th>zip</th>
            <th>Edit</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($result as $row) : ?>
            <tr>
                <td><?php echo $row['fName']; ?></td>
                <td><?php echo $row['lName']; ?></td>
                <td><?php echo $row['dateOfBirth']; ?></td>
                <td><?php echo $row['email']; ?></td>
                <td><?php echo $row['streetAddr']; ?></td>
                <td><?php echo $row['city']; ?></td>
                <td><?php echo $row['state']; ?></td>
                <td><?php echo $row['country']; ?></td>
                <td><?php echo $row['zip']; ?></td>
                <td><a href="user_updater.php?fName=<?php echo $row["fName"]; ?>&lName=<?php echo $row['lName']; ?>&dateOfBirth=<?php echo $row['dateOfBirth']; ?>">Edit</a></td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<?php require "templates/footer.php"; ?>