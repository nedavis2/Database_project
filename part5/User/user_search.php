<?php

if (isset($_POST['submit'])) {
    require "../../connection.php";

    try {
        $connection = new PDO($dsn, $username, $password, $options);

        $query_str = 
            "SELECT * 
            FROM user
            WHERE lName = :lName";

        $state = $_POST['lName'];

        $stmt = $connection->prepare($query_str);
        $stmt->bindParam(':lName', $state, PDO::PARAM_STR);
        $stmt->execute();

        $results = $stmt->fetchAll();

    } catch (PDOException $error) {
        echo "Database connection error: " . $error->getMessage() . "<BR>";
    }
}

?>

<h2>Find user by last name</h2>

<form method = "post">
    <label for = "lName">Last Name</label>
    <input type = "text" name = "lName" id = "lName">
    <input type = "submit" name = "submit" value = "View Results">
</form>

<a href = "user_home.php">Back to users home page</a>

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
        <blockquote>No results found for <?php echo $_POST['lName']; ?>.</blockquote>
    <?php }
}

?>

<?php include "templates/footer.php"; ?>