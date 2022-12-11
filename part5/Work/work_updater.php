<?php

require "../../connection.php";

if (isset($_POST['submit'])) {
  try {
    $connection = new PDO($dsn, $username, $password, $options);
    
    $work = explode(" ", $_POST['oldWork']);

    $dev = explode(" ", $_POST['developer']);

    $new_work = [
      "oldDFname"       => $work[0],
      "oldDLname"       => $work[1],
      "oldDDateOfBirth" => $work[2],
      "oldTeamID"       => $work[3],
      "oldExpID"        => $work[4],
      "newDFname"       => $dev[0],
      "newDLname"       => $dev[1],
      "newDDateOfBirth" => $dev[2],
      "newTeamID"       => $_POST['team'],
      "newExpID"        => $_POST['experience']
    ];

    $query_str = "UPDATE work
                  SET dFname = :newDFname,
                      dLname = :newDLname,
                      dDateOfBirth = :newDDateOfBirth,
                      teamID = :newTeamID,
                      expID = :newExpID
                  WHERE dFname = :oldDFname AND dLname = :oldDLname AND dDateOfBirth = :oldDDateOfBirth AND teamID = :oldTeamID AND expID = :oldExpID";

    $stmt = $connection->prepare($query_str);
    $stmt->execute($new_work);

  } catch (PDOException $error) {
    echo "Database connection error: " . $error->getMessage() . "<BR>";
  }
}
?>

<?php include "templates/work_header.php"; ?>

<?php
  try{
    $connection = new PDO($dsn, $username, $password, $options);

    $query_str = "SELECT * FROM work";

    $workList = $connection->prepare($query_str);
    $workList->execute();

    $workResults = $workList->fetchAll(PDO::FETCH_ASSOC);
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

<?php
  try{
    $connection = new PDO($dsn, $username, $password, $options);

    $query_str = "SELECT teamID FROM developmentTeam ORDER BY teamID";

    $teamList = $connection->prepare($query_str);
    $teamList->execute();

    $teamResults = $teamList->fetchAll(PDO::FETCH_ASSOC);
  } catch (PDOException $error) {
    echo "Database connection error: " . $error->getMessage() . "<BR>";
  }
?>

<?php
  try{
    $connection = new PDO($dsn, $username, $password, $options);

    $query_str = "SELECT expID FROM VRExperience ORDER BY expID";

    $expList = $connection->prepare($query_str);
    $expList->execute();

    $expResults = $expList->fetchAll(PDO::FETCH_ASSOC);
  } catch (PDOException $error) {
    echo "Database connection error: " . $error->getMessage() . "<BR>";
  }
?>

<h2>Update work</h2>

<form method="post">
<label for="work-select">Select Experience</label>
  <select name="oldWork" id="work-select">
    <option selected>--Select Experience--></option>
    <?php foreach ($workResults as $row) : ?>
      <option value="<?php echo $row['dFname']." ".$row['dLname']." ".$row['dDateOfBirth']." ".$row['teamID']." ".$row['expID']; ?>"><?php echo "dFname: ".$row['dFname']." | Team: ".$row['teamID']." | Experience: ".$row['expID']; ?></option>
    <?php endforeach; ?>
  </select>

  <label for="dev-select">Developer</label>
  <select name="developer" id="developer-select">
    <option selected>--Select Developer--></option>
    <?php foreach ($devResults as $row) : ?>
      <option value="<?php echo $row['fName']." ".$row['lName']." ".$row['dateOfBirth']; ?>"><?php echo $row['fName']." ".$row['lName']." ".$row['dateOfBirth']; ?></option>
    <?php endforeach; ?>
  </select>

  <label for="team-select">Team ID</label>
  <select name="team" id="team-select">
    <option selected>--Select Team--></option>
    <?php foreach ($teamResults as $row) : ?>
      <option value="<?php echo $row['teamID']; ?>"><?php echo $row['teamID']; ?></option>
    <?php endforeach; ?>
  </select>

  <label for="experience-select">Experience ID</label>
  <select name="experience" id="experience-select">
    <option selected>--Select Experience--></option>
    <?php foreach ($expResults as $row) : ?>
      <option value="<?php echo $row['expID']; ?>"><?php echo $row['expID']; ?></option>
    <?php endforeach; ?>
  </select>

  <input type="submit" name="submit" value="Update">
</form>

<a href = "work_home.php">Back to work home</a>

<?php include "templates/footer.php"; ?>