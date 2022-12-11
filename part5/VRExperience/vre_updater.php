<?php

require "../../connection.php";

if (isset($_POST['submit'])) {
  try {
    $connection = new PDO($dsn, $username, $password, $options);

    $devloper = explode(" ", $_POST['developer']);

    $new_experience = [
      "newExpID"        => $_POST['newExpID'],
      "oldExpID"        => $_POST['oldExpID'],
      "maintainerFName" => $devloper[0],
      "maintainerLName" => $devloper[1],
      "maintainerDOB"   => $devloper[2],
      "name"            => $_POST['name'],
      "type"            => $_POST['type']
    ];

    if (is_null($new_experience['name']) || is_null($new_experience['type'])) {
      $query_str = "UPDATE VRExperience
                      SET expID = :newExpID,
                        maintainerFName = :maintainerFName,
                        maintainerLName = :maintainerLName,
                        maintainerDOB = :maintainerDOB,
                        name = :name,
                        type = :type
                      WHERE expID = :oldExpID";

      $stmt = $connection->prepare($query_str);
      $stmt->execute($new_experience);
      
    } else {
      echo "Invalid input, experience name or type is missing";
    }
  } catch (PDOException $error) {
    echo "Database connection error: " . $error->getMessage() . "<BR>";
  }
}
?>

<?php
  try{
    $connection = new PDO($dsn, $username, $password, $options);

    $query_str = "SELECT expID FROM VRExperience ORDER BY expID";

    $vreList = $connection->prepare($query_str);
    $vreList->execute();

    $vreResults = $vreList->fetchAll(PDO::FETCH_ASSOC);
  } catch (PDOException $error) {
    echo "Database connection error: " . $error->getMessage() . "<BR>";
  }
?>

<?php
  try{
    $connection = new PDO($dsn, $username, $password, $options);

    $query_str = "SELECT fName, lName, dateOfBirth FROM developer ORDER BY fName, lName";

    $devList = $connection->prepare($query_str);
    $devList->execute();

    $devResults = $devList->fetchAll(PDO::FETCH_ASSOC);
  } catch (PDOException $error) {
    echo "Database connection error: " . $error->getMessage() . "<BR>";
  }
?>

<?php include "templates/vrexp_header.php"; ?>

<h2>Update a vr experience</h2>

<form method="post">
  <label for="experience-select">Select Experience</label>
  <select name="oldExpID" id="experience-select">
    <option selected>--Select Experience--></option>
    <?php foreach ($vreResults as $row) : ?>
      <option value="<?php echo $row['expID']; ?>"><?php echo $row['expID']; ?></option>
    <?php endforeach; ?>
  </select>
  
  <label for="experience-select">Update experience ID</label>
  <select name="newExpID" id="experience-select">
    <option selected>--Select Experience--></option>
    <?php foreach ($vreResults as $row) : ?>
      <option value="<?php echo $row['expID']; ?>"><?php echo $row['expID']; ?></option>
    <?php endforeach; ?>
  </select>

  <label for="dev-select">Devloper</label>
  <select name="developer" id="dev-select">
    <option selected>--Select Developer--></option>
    <?php foreach ($devResults as $row) : ?>
      <option value="<?php echo $row['fName']." ".$row['lName']." ".$row['dateOfBirth']; ?>"><?php echo $row['fName']." ".$row['lName']." ".$row['dateOfBirth']; ?></option>
    <?php endforeach; ?>
  </select>
  
  <label for="name">Name</label>
  <input type="text" name="name" id="name">

  <label for="type">Type</label>
  <input type="text" name="type" id="type">

  <input type="submit" name="submit" value="Update">
</form>

<a href = "vrexp_home.php">Back to vr experience home</a>

<?php include "templates/footer.php"; ?>