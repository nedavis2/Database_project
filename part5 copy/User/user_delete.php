<?php

require "../../connection.php";

if (isset($_GET['fName'],$_GET['lName'],$_GET['dateOfBirth'])) {
    try {
        $connection = new PDO($dsn, $username, $password, $options);
        $fName = $_GET['fName'];
        $lName = $_GET['lName'];
        $dateOfBirth = $_GET['dateOfBirth'];

        $query_str = "DELETE FROM user WHERE fName = :fName AND lName = :lName AND dateOfBirth = :dateOfBirth";
        
        $stmt = $connection->prepare($query_str);
        $stmt->bindParam('fName', $fName);
        $stmt->bindParam('lName', $lName);
        $stmt->bindParam('dateOfBirth', $dateOfBirth);
        $stmt->execute();

        $success = "User successfully deleted.";
    } catch (PDOException $error) {
        echo "Database connection error: " . $error->getMessage() . "<BR>";
    }
}

try {
    $connection = new PDO($dsn, $username, $password, $options);
    
    $query_str = "SELECT * FROM user";

    $stmt = $connection->prepare($query_str);
    $stmt->execute();

    $result = $stmt->fetchAll();
} catch (PDOException $error) {
    echo "Database connection error: " . $error->getMessage() . "<BR>";
}
?>

<a href="user_home.php">Back to users home</a>
        
<h2>Delete a user</h2>

<?php if ($success) echo $success; ?>

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
            <th>Delete</th>
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
                <td><a href="user_delete.php?fName=<?php echo $row["fName"]; ?>&lName=<?php echo $row['lName']; ?>&dateOfBirth=<?php echo $row['dateOfBirth']; ?>">Delete</a></td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<?php require "templates/footer.php"; ?>