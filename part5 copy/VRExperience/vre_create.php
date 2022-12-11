<?php
require "../../connection.php";

if (isset($_POST['submit'])) {

    try {
        $connection = new PDO($dsn, $username, $password, $options);

        $dev = explode(" ", $_POST['developer']);

        $new_vrexp = array(
            "expID"             => $_POST['expID'],
            "maintainerFName"   => $dev[0],
            "maintainerLName"   => $dev[1],
            "maintainerDOB"     => $dev[2],
            "name"              => $_POST['name'],
            "type"              => $_POST['type']
        );

        if (is_numeric($new_vrexp['expID']) && (is_null($new_vrexp['name']) || is_null($new_vrexp['type']))) {
          $query_str = "INSERT INTO VRExperience (expID, maintainerFName, maintainerLName, maintainerDOB, name, type)
                        VALUES (:expID,:maintainerFName,:maintainerLName,:maintainerDOB,:name,:type)";

          $stmt = $connection->prepare($query_str);
          $stmt->execute($new_vrexp);
        } else {
          echo "Invalid input, experience ID must be a number and / or experience name or type is missing";
        }

    } catch (PDOException $error) {
        echo "Database connection error: " . $error->getMessage() . "<BR>";
    }
}

?>

<?php include "templates/vrexp_header.php"; ?>

<?php if (isset($_POST['submit']) && $stmt) {?> 
    <blockquote><?php echo $_POST['expID']; ?> successfully added.</blockquote>
<?php } ?>

<?php
  try{
    $connection = new PDO($dsn, $username, $password, $options);

    $query_str = "SELECT fName, lName, dateOfBirth FROM developer";

    $devList = $connection->prepare($query_str);
    $devList->execute();

    $devResults = $devList->fetchAll(PDO::FETCH_ASSOC);
  } catch (PDOException $error) {
    echo "Database connection error: " . $error->getMessage() . "<BR>";
  }
?>

<h2>Add a new VR experience</h2>

<form method = "post">
    <label for = "expID">VR Experience ID</label>
    <input type = "text" name = "expID" id = "expID">

    <label for = "dev-select">Maintainer</label>
    <select name="developer" id="dev-select">
        <option selected>--Select Maintainer--</option>
        <?php foreach ($devResults as $row) : ?>
          <option value="<?php echo $row['fName']." ".$row['lName']." ".$row['dateOfBirth']; ?>"><?php echo $row['fName']." ".$row['lName']." ".$row['dateOfBirth']; ?></option>
        <?php endforeach; ?>
    </select>

    <label for = "name">VR Experience Name</label>
    <input type = "text" name = "name" id = "name">

    <label for = "type">VR Experience Type</label>
    <input type = "text" name = "type" id = "type">

    <input type = "submit" name = "submit" value = "Create">
</form>

<a href = "vrexp_home.php">Back to VR Experience home page</a>

<?php include "templates/footer.php"; ?>