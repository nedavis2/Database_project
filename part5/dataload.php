<pre>
<?php
require_once("connection.php");

try{

    $file_name = "dump.json";
    $json_stuff = file_get_contents($file_name);
    $data = json_decode($json_stuff);

    // print_r($data);
    // die;

}catch(Exception $e){
    echo "JSON Exception: ".$e->getMessage();
}

try{
    //remove all entries from tables before insertion
    $connection->query("DELETE FROM work");
    $connection->query("DELETE FROM developmentTeam");
    $connection->query("DELETE FROM supportedHeadset");
    $connection->query("DELETE FROM VRExperience");
    $connection->query("DELETE FROM player");
    $connection->query("DELETE FROM progLanguage");
    $connection->query("DELETE FROM developer");
    $connection->query("DELETE FROM avatar;");
    $connection->query("DELETE FROM user;");

    //insert into the user table
    $query_str = "INSERT INTO user VALUES (:first_name,:last_name,:date_of_birth,:email,:street_address,:city,:state,:country,:ZIP)";
    foreach ($data->user as $row){
        $stmt = $connection->prepare($query_str);

        $stmt->bindParam(":first_name", $row->fName, PDO::PARAM_STR);
        $stmt->bindParam(":last_name", $row->lName, PDO::PARAM_STR);
        $stmt->bindParam(":date_of_birth", $row->dateOfBirth, PDO::PARAM_STR);
        $stmt->bindParam(":email", $row->email, PDO::PARAM_STR);
        $stmt->bindParam(":street_address", $row->streetAddr, PDO::PARAM_STR);
        $stmt->bindParam(":city", $row->city, PDO::PARAM_STR);
        $stmt->bindParam(":state", $row->state, PDO::PARAM_STR);
        $stmt->bindParam(":country", $row->country, PDO::PARAM_STR);
        $stmt->bindParam(":ZIP", $row->zip, PDO::PARAM_INT);

        $stmt->execute();
    }

    //insert into the avatar table
    $query_str = "INSERT INTO avatar (fName, lName, dateOfBirth, name, height, gender, species)
                        VALUES (:user_first_name,:user_last_name,:user_DOB,:avatar_name,:height,:gender,:species)";
    foreach ($data->avatar as $row){
        $stmt = $connection->prepare($query_str);

        $stmt->bindParam(":user_first_name", $row->fName, PDO::PARAM_STR);
        $stmt->bindParam(":user_last_name", $row->lName, PDO::PARAM_STR);
        $stmt->bindParam(":user_DOB", $row->dateOfBirth, PDO::PARAM_STR);
        $stmt->bindParam(":avatar_name", $row->name, PDO::PARAM_STR);
        $stmt->bindParam(":height", $row->height, PDO::PARAM_INT);
        $stmt->bindParam(":gender", $row->gender, PDO::PARAM_STR);
        $stmt->bindParam(":species", $row->species, PDO::PARAM_STR);

        $stmt->execute();
    }

    //insert into the developer table
    $query_str = "INSERT INTO developer (fName, lName, dateOfBirth, startDate)
                        VALUES (:userFName,:userLName,:userDOB,:startDate)";
    foreach ($data->developer as $row){
        $stmt = $connection->prepare($query_str);

        $stmt->bindParam(":userFName", $row->fName, PDO::PARAM_STR);
        $stmt->bindParam(":userLName", $row->lName, PDO::PARAM_STR);
        $stmt->bindParam(":userDOB", $row->dateOfBirth, PDO::PARAM_STR);
        $stmt->bindParam(":startDate", $row->startDate, PDO::PARAM_STR);

        $stmt->execute();
    }

    //insert into the progLanguage table
    $query_str = "INSERT INTO progLanguage (dFName, dLName, dDateOfBirth, language)
                        VALUES (:devFName,:devLName,:devDOB,:language)";
    foreach ($data->progLanguage as $row){
        $stmt = $connection->prepare($query_str);

        $stmt->bindParam(":devFName", $row->dFName, PDO::PARAM_STR);
        $stmt->bindParam(":devLName", $row->dLName, PDO::PARAM_STR);
        $stmt->bindParam(":devDOB", $row->dDateOfBirth, PDO::PARAM_STR);
        $stmt->bindParam(":language", $row->language, PDO::PARAM_STR);

        $stmt->execute();
    }

    //insert into the player table
    $query_str = "INSERT INTO player (fName, lName, dateOfBirth, headset, favGenre)
                        VALUES (:userFName,:userLName,:userDOB,:headset,:favGenre)";
    foreach ($data->player as $row){
        $stmt = $connection->prepare($query_str);

        $stmt->bindParam(":userFName", $row->fName, PDO::PARAM_STR);
        $stmt->bindParam(":userLName", $row->lName, PDO::PARAM_STR);
        $stmt->bindParam(":userDOB", $row->dateOfBirth, PDO::PARAM_STR);
        $stmt->bindParam(":headset", $row->headset, PDO::PARAM_STR);
        $stmt->bindParam(":favGenre", $row->favGenre, PDO::PARAM_STR);

        $stmt->execute();
    }

    //insert into the vr experience table
    $query_str = "INSERT INTO VRExperience (expID, maintainerFName, maintainerLName, maintainerDOB, name, type)
                        VALUES (:expID,:mainFName,:mainLName,:mainDOB,:name,:type)";
    foreach ($data->VRExperience as $row){
        $stmt = $connection->prepare($query_str);

        $stmt->bindParam(":expID", $row->expID, PDO::PARAM_INT);
        $stmt->bindParam(":mainFName", $row->maintainerFName, PDO::PARAM_STR);
        $stmt->bindParam(":mainLName", $row->maintainerLName, PDO::PARAM_STR);
        $stmt->bindParam(":mainDOB", $row->maintainerDOB, PDO::PARAM_STR);
        $stmt->bindParam(":name", $row->name, PDO::PARAM_STR);
        $stmt->bindParam(":type", $row->type, PDO::PARAM_STR);

        $stmt->execute();
    }

    //insert into the supported headset table
    $query_str = "INSERT INTO supportedHeadset (expID, headset)
                        VALUES (:expID,:headset)";
    foreach ($data->supportedHeadset as $row){
        $stmt = $connection->prepare($query_str);

        $stmt->bindParam(":expID", $row->expID, PDO::PARAM_INT);
        $stmt->bindParam(":headset", $row->headset, PDO::PARAM_STR);
        
        $stmt->execute();
    }

    //insert into the development team table
    $query_str = "INSERT INTO developmentTeam (teamID, type, description)
                        VALUES (:teamID,:type,:description)";
    foreach ($data->developmentTeam as $row){
        $stmt = $connection->prepare($query_str);

        $stmt->bindParam(":teamID", $row->teamID, PDO::PARAM_INT);
        $stmt->bindParam(":type", $row->type, PDO::PARAM_STR);
        $stmt->bindParam(":description", $row->description, PDO::PARAM_STR);
        
        $stmt->execute();
    }

    //insert into the work table
    $query_str = "INSERT INTO work (dFName, dLName, dDateOfBirth, teamID, expID)
                        VALUES (:devFirstName,:devLastName,:devDOB,:teamID,:expID)";
    foreach ($data->work as $row){
        $stmt = $connection->prepare($query_str);

        $stmt->bindParam(":devFirstName", $row->dFName, PDO::PARAM_STR);
        $stmt->bindParam(":devLastName", $row->dLName, PDO::PARAM_STR);
        $stmt->bindParam(":devDOB", $row->dDateOfBirth, PDO::PARAM_STR);
        $stmt->bindParam(":teamID", $row->teamID, PDO::PARAM_INT);
        $stmt->bindParam(":expID", $row->expID, PDO::PARAM_INT);
        
        $stmt->execute();
    }
}catch(PDOException $error){
    echo "Database connection error: " . $error->getMessage() . "<BR>";
    die;
}
?>
Data successfully inserted.
</pre>