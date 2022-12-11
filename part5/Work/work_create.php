<?php
require "../../connection.php";

if (isset($_POST['submit'])) {

    try {
        $connection = new PDO($dsn, $username, $password, $options);

        $dev = explode(" ", $_POST['developer']);

        $new_work = array(
            "dFname"         => $dev[0],
            "dLname"         => $dev[1],
            "dDateOfBirth"   => $dev[2],
            "teamID"         => $_POST['team'],
            "expID"          => $_POST['experience']
        );

        $query_str = "INSERT INTO work VALUES (:dFname,:dLname,:dDateOfBirth,:teamID,:expID)";

        $stmt = $connection->prepare($query_str);
        $stmt->execute($new_work);

    } catch (PDOException $error) {
        echo "Database connection error: " . $error->getMessage() . "<BR>";
    }
}

?>

<?php include "templates/work_header.php"; ?>

<?php if (isset($_POST['submit']) && $stmt) {?> 
    <blockquote>Work successfully added.</blockquote>
<?php } ?>

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

<h2>Create work</h2>

<form method = "post">
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

    <input type = "submit" name = "submit" value = "Create">
</form>

<a href = "work_home.php">Back to work home page</a>

<?php include "templates/footer.php"; ?>