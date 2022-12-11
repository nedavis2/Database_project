<?php

require "../../connection.php";

if (isset($_POST['submit'])) {
  try {
    $connection = new PDO($dsn, $username, $password, $options);

    $new_user = [
      "fName"         => $_POST['fName'],
      "lName"         => $_POST['lName'],
      "dateOfBirth"   => $_POST['dateOfBirth'],
      "email"         => $_POST['email'],
      "streetAddr"    => $_POST['streetAddr'],
      "city"          => $_POST['city'],
      "state"         => $_POST['state'],
      "country"       => $_POST['country'],
      "zip"           => $_POST['zip']
    ];

    $newFName = $new_user['fName'];
    $newLName = $new_user['lName'];
    $newDOB = $new_user['dateOfBirth'];
    $email = $new_user['email'];
    $streetAddr = $new_user['streetAddr'];
    $city = $new_user['city'];
    $state = $new_user['state'];
    $country = $new_user['country'];
    $zip = $new_user['zip'];

    $oldFName = $_POST['oldFName'];
    $oldLName = $_POST['oldLName'];
    $oldDOB = $_POST['oldDateOfBirth'];

    $query_str = "UPDATE user
                  SET fName = :newFName,
                      lName = :newLName,
                      dateOfBirth = :newDateOfBirth,
                      email = :email,
                      streetAddr = :streetAddr,
                      city = :city,
                      state = :state,
                      country = :country,
                      zip = :zip
                  WHERE fName = :oldFName AND lName = :oldLName AND dateOfBirth = :oldDateOfBirth";

    $stmt = $connection->prepare($query_str);

    $stmt->bindParam('newFName', $newFName, PDO::PARAM_STR);
    $stmt->bindParam('newLName', $newLName, PDO::PARAM_STR);
    $stmt->bindParam('newDateOfBirth', $newDOB, PDO::PARAM_STR);
    $stmt->bindParam('email', $email, PDO::PARAM_STR);
    $stmt->bindParam('streetAddr', $streetAddr, PDO::PARAM_STR);
    $stmt->bindParam('city', $city, PDO::PARAM_STR);
    $stmt->bindParam('state', $state, PDO::PARAM_STR);
    $stmt->bindParam('country', $country, PDO::PARAM_STR);
    $stmt->bindParam('zip', $zip, PDO::PARAM_STR);

    $stmt->bindParam('oldFName', $oldFName, PDO::PARAM_STR);
    $stmt->bindParam('oldLName', $oldLName, PDO::PARAM_STR);
    $stmt->bindParam('oldDateOfBirth', $oldDOB, PDO::PARAM_STR);

    $stmt->execute();

  } catch (PDOException $error) {
    echo "Database connection error: " . $error->getMessage() . "<BR>";
  }
}

if (isset($_GET['fName'],$_GET['lName'],$_GET['dateOfBirth'])) {
  try{
    $connection = new PDO($dsn, $username, $password, $options);
    $fName = $_GET['fName'];
    $lName = $_GET['lName'];
    $dateOfBirth = $_GET['dateOfBirth'];

    $query_str = "SELECT * FROM user WHERE fName = :fName AND lName = :lName AND dateOfBirth = :dateOfBirth";

    $stmt = $connection->prepare($query_str);
    $stmt->bindParam('fName', $fName);
    $stmt->bindParam('lName', $lName);
    $stmt->bindParam('dateOfBirth', $dateOfBirth);
    $stmt->execute();

    $user = $stmt->fetch(PDO::FETCH_ASSOC);
  } catch (PDOException $error) {
    echo "Database connection error: " . $error->getMessage() . "<BR>";
  }
} else {
    echo "Something went wrong!";
    exit;
}
?>

<?php include "templates/user_header.php"; ?>

<?php if (isset($_POST['submit']) && $stmt) {?> 
  <?php header("Location: user_update.php"); ?>
<?php } ?>

<h2>Update a user</h2>

<form method="post">
  <?php foreach ($user as $key => $value) : ?>  
    <label for="<?php echo $key; ?>"><?php echo ucfirst($key); ?></label>
    <input type="text" name="<?php echo $key; ?>" id="<?php echo $key; ?>" value="<?php echo $value; ?>">
  <?php endforeach; ?>
  <input type="submit" name ="submit" value="Submit">
  <input type="hidden" name="oldFName" value="<?php echo $user['fName']; ?>">
  <input type="hidden" name="oldLName" value="<?php echo $user['lName']; ?>">
  <input type="hidden" name="oldDateOfBirth" value="<?php echo $user['dateOfBirth']; ?>">
</form>

<a href = "user_update.php">Back to user editor</a>

<?php include "templates/footer.php"; ?>