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

    $dev_update = [
      "fName"         => $developer[0],
      "lName"         => $developer[1],
      "dateOfBirth"   => $developer[2],
      "startDate"     => $_POST['startDate']
    ];

    if (validateDate($dev_update['startDate'])){
      $query_str = "UPDATE developer
                  SET startDate = :startDate
                  WHERE fName = :fName AND lName = :lName AND dateOfBirth = :dateOfBirth";

      $stmt = $connection->prepare($query_str);

      $stmt->execute($dev_update);
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
  <blockquote><?php echo $developer[0]; ?> successfully updated.</blockquote>
<?php } ?>

<?php
  try{
    $connection = new PDO($dsn, $username, $password, $options);

    $query_str = "SELECT * FROM developer";

    $devList = $connection->prepare($query_str);
    $devList->execute();

    $devResults = $devList->fetchAll(PDO::FETCH_ASSOC);
  } catch (PDOException $error) {
    echo "Database connection error: " . $error->getMessage() . "<BR>";
  }
?>

<h2>Update a developer</h2>

<form method = "post">
    <label for = "dev-select">Developer to update</label>
    <select name="developer" id="dev-select">
        <option selected>--Select Developer--</option>
        <?php foreach ($devResults as $row) : ?>
          <option value="<?php echo $row['fName']." ".$row['lName']." ".$row['dateOfBirth']; ?>"><?php echo $row['fName']." ".$row['lName']." ".$row['dateOfBirth']; ?></option>
        <?php endforeach; ?>
    </select>
    
    <label for = "startDate">Edit developer start date</label>
    <input type = "text" name = "startDate" id = "startDate">

    <input type = "submit" name = "submit" value = "Submit">
</form>

<a href = "dev_home.php">Back to developer home</a>

<?php include "templates/footer.php"; ?>

