<?php

require "../../connection.php";

try {
    $connection = new PDO($dsn, $username, $password, $options);

    $query_str = 
        "SELECT * 
        FROM user";

    $stmt = $connection->prepare($query_str);
    $stmt->execute();

    $results = $stmt->fetchAll();

} catch (PDOException $error) {
    echo "Database connection error: " . $error->getMessage() . "<BR>";
}

?>

<a href = "user_home.php">Back to users home page</a>

<?php 

if ($results && $stmt->rowCount() > 0) { ?>
    <h2>All users</h2>

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
            </tr>
        </thead>
        <tbody>
    <?php foreach ($results as $row) { ?>
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
        </tr>
    <?php } ?>
    </tbody>
</table>
<?php } else { ?>
    <blockquote>No results found for users.</blockquote>
<?php }

?>

<?php include "templates/footer.php"; ?>