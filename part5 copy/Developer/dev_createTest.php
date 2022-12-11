<?php

function validateDate($date, $format = 'Y-m-d') {
    $d = DateTime::createFromFormat($format, $date);
    return $d && $d->format($format) == $date;
}

require "../../connection.php";

if (isset($_POST['submit'])) {

    try {
        $connection = new PDO($dsn, $username, $password, $options);

        $developer = explode(" ", $_POST['developer']);

        if (validateDate($dev_update['startDate'])) {
            $query_str = "INSERT INTO developer (fName, lName, dateOfBirth, startDate)
                        VALUES (:fName,:lName,:dateOfBirth,:startDate)";

            $stmt = $connection->prepare($query_str);
            $stmt->execute($new_developer); 
        } else {
            echo "Invalid start date, must be in YYYY-MM-DD format";
        }

    } catch (PDOException $error) {
        echo "Database connection error: " . $error->getMessage() . "<BR>";
    }
}

?>

<?php include "templates/dev_header.php"; ?>

<?php if (isset($_POST['submit']) && $stmt) {?>
    <blockquote><?php echo $developer[0]; ?> successfully added.</blockquote>
<?php } ?>

<?php
    try {
        $connection = new PDO($dsn, $username, $password, $options);

        $query_str = "SELECT u.fName, u.lName, u.dateOfBirth FROM user u 
                      LEFT JOIN developer d  
                      ON (u.fName = d.fName AND u.lName = d.lName AND u.dateOfBirth = d.dateOfBirth)  
                      WHERE d.fName IS NULL AND d.lName IS NULL AND d.dateOfBirth IS NULL  
                      ORDER BY fName, lName";

        $userList = $connection->prepare($query_str);
        $userList->execute();

        $userResults = $userList->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $error) {
    echo "Database connection error: " . $error->getMessage() . "<BR>";
    }
?>

<h2>Add a new developer</h2>

<form method = "post">
    <label for = "user-select">New Developer</label>

    <select name="developer" id="user-select">
        <option selected>--Select User--</option>
        <?php foreach ($userResults as $row) : ?>
            <option value="<?php echo $row['fName']." ".$row['lName']." ".$row['dateOfBirth']; ?>"><?php echo $row['fName']." ".$row['lName']." ".$row['dateOfBirth']; ?></option>
        <?php endforeach; ?>
    </select>
    <br>

    <label for = "startDate">Enter developer start date</label>
    <input type = "text" name = "startDate" id = "startDate">

    <input type = "submit" name = "submit" value = "Create">
</form>

<a href = "dev_home.php">Back to developers home page</a>

<?php include "templates/footer.php"; ?>