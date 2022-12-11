<?php

require "../../connection.php";

if (isset($_POST['submit'])) {
  try {
    $connection = new PDO($dsn, $username, $password, $options);

    $new_devTeam = [
      "teamID"        => $_POST['teamID'],
      "type"          => $_POST['type'],
      "description"   => $_POST['description']
    ];

    $newTeamID = $new_devTeam['teamID'];
    $type = $new_devTeam['type'];
    $description = $new_devTeam['description'];

    $oldTeamID = $_POST['oldTeamID'];

    $query_str = "UPDATE developmentTeam
                  SET teamID = :newTeamID,
                      type = :type,
                      description = :description
                  WHERE teamID = :oldTeamID";

    $stmt = $connection->prepare($query_str);

    $stmt->bindParam('newTeamID', $newTeamID, PDO::PARAM_INT);
    $stmt->bindParam('type', $type, PDO::PARAM_STR);
    $stmt->bindParam('description', $description, PDO::PARAM_STR);

    $stmt->bindParam('oldTeamID', $oldTeamID, PDO::PARAM_INT);

    $stmt->execute();

  } catch (PDOException $error) {
    echo "Database connection error: " . $error->getMessage() . "<BR>";
  }
}

if (isset($_GET['teamID'])) {
  try{
    $connection = new PDO($dsn, $username, $password, $options);
    $teamID = $_GET['teamID'];

    $query_str = "SELECT * FROM developmentTeam WHERE teamID = :teamID";

    $stmt = $connection->prepare($query_str);
    $stmt->bindParam('teamID', $teamID);
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

<?php include "templates/dt_header.php"; ?>

<?php if (isset($_POST['submit']) && $stmt) {?> 
  <?php header("Location: dt_update.php"); ?>
<?php } ?>

<h2>Update a development team</h2>

<form method="post">
  <?php foreach ($user as $key => $value) : ?>  
    <label for="<?php echo $key; ?>"><?php echo ucfirst($key); ?></label>
    <input type="text" name="<?php echo $key; ?>" id="<?php echo $key; ?>" value="<?php echo $value; ?>">
  <?php endforeach; ?>
  <input type="submit" name ="submit" value="Submit">
  <input type="hidden" name="oldTeamID" value="<?php echo $user['teamID']; ?>">
</form>

<a href = "dt_update.php">Back to development team editor</a>

<?php include "templates/footer.php"; ?>