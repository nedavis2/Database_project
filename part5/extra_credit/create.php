<?php

if (isset($_POST['submit'])) {
    require "../connection.php";

    try {
        $connection = new PDO($dsn, $username, $password, $options);

        $new_user = array(
            "fName"         => $_POST['fName'],
            "lName"         => $_POST['lName'],
            "dateOfBirth"   => $_POST['dateOfBirth'],
            "email"         => $_POST['email'],
            "streetAddr"    => $_POST['streetAddr'],
            "city"          => $_POST['city'],
            "state"         => $_POST['state'],
            "country"       => $_POST['country'],
            "zip"           => $_POST['zip']
        );

        $query_str = "INSERT INTO user VALUES (:fName,:lName,:dateOfBirth,:email,:streetAddr,:city,:state,:country,:zip)";

        $stmt = $connection->prepare($query_str);
        $stmt->execute($new_user);

    } catch (PDOException $error) {
        echo "Database connection error: " . $error->getMessage() . "<BR>";
    }
}

?>

<?php include "templates/header.php"; ?>

<?php if (isset($_POST['submit']) && $stmt) {?> 
    <blockquote><?php echo $_POST['fName']; ?> successfully added.</blockquote>
<?php } ?>

<h2>Add a new user</h2>

<form method = "post">
    <label for = "fName">First Name</label>
    <input type = "text" name = "fName" id = "fName">

    <label for = "lName">Last Name</label>
    <input type = "text" name = "lName" id = "lName">

    <label for = "dateOfBirth">Date of Birth</label>
    <input type = "text" name = "dateOfBirth" id = "dateOfBirth">

    <label for = "email">Email Address</label>
    <input type = "text" name = "email" id = "email">

    <label for = "streetAddr">Street Address</label>
    <input type = "text" name = "streetAddr" id = "streetAddr">

    <label for = "city">City</label>
    <input type = "text" name = "city" id = "city">

    <label for = "state">State</label>
    <input type = "text" name = "state" id = "state">

    <label for = "country">Country</label>
    <input type = "text" name = "country" id = "country">

    <label for = "zip">ZIP Code</label>
    <input type = "text" name = "zip" id = "zip">

    <input type = "submit" name = "submit" value = "Submit">
</form>

<a href = "index.php">Back to home</a>

<?php include "templates/footer.php"; ?>