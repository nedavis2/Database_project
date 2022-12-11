<?php
require_once("composer/vendor/autoload.php");

try{
    $faker = Faker\Factory::create();

    //number of users(2000 players / 1500 developers / 1500 both player and developer)
    //total number(3500 players, 3000 devs)
    $num_users    = 5000;
    $num_players  = 3500;
    $num_devs     = 3000;
    $num_avatar   = 15000;
    $num_VRexp    = 300;
    $num_devTeam  = 500;
    
    //create a list of users
    for ($i = 0; $i < $num_users; $i++){
        $data["user"][$i]["fName"]          = $faker->firstName();
        $data["user"][$i]["lName"]          = $faker->lastName();
        $data["user"][$i]["dateOfBirth"]    = $faker->unique()->date('Y-m-d', '-10 years');
        $data["user"][$i]["email"]          = $faker->unique()->email();
        $data["user"][$i]["streetAddr"]     = $faker->unique()->streetAddress();
        $data["user"][$i]["city"]           = $faker->city();
        $data["user"][$i]["state"]          = $faker->stateAbbr();
        $data["user"][$i]["country"]        = "USA";
        $data["user"][$i]["zip"]            = $faker->postcode();
    }

    //guarantee every user has at least 1 avatar
    for ($i = 0; $i < $num_users; $i++){
        $data["avatar"][$i]["fName"]       = $data["user"][$i]["fName"];
        $data["avatar"][$i]["lName"]       = $data["user"][$i]["lName"];
        $data["avatar"][$i]["dateOfBirth"] = $data["user"][$i]["dateOfBirth"];

        $data["avatar"][$i]["name"]     = $faker->unique()->userName();
        $data["avatar"][$i]["height"]   = $faker->randomFloat(2, 4, 7);
        $data["avatar"][$i]["gender"]   = $faker->randomElement(['Male', 'Female']);
        $data["avatar"][$i]["species"]  = $faker->word();
    }

    //randomly assign the remaining avatars to the users
    for ($i = $num_users; $i < $num_avatar; $i++){
        $j = random_int(0, (count($data["user"])-1));
        $data["avatar"][$i]["fName"]       = $data["user"][$j]["fName"];
        $data["avatar"][$i]["lName"]       = $data["user"][$j]["lName"];
        $data["avatar"][$i]["dateOfBirth"] = $data["user"][$j]["dateOfBirth"];

        $data["avatar"][$i]["name"]     = $faker->unique()->userName();
        $data["avatar"][$i]["height"]   = $faker->randomFloat(2, 4, 7);
        $data["avatar"][$i]["gender"]   = $faker->randomElement(['Male', 'Female']);
        $data["avatar"][$i]["species"]  = $faker->word();
    }

    //create the developer list from users
    for ($i = 0; $i < $num_devs; $i++){
        $data["developer"][$i]["fName"]         = $data["user"][$i]["fName"];
        $data["developer"][$i]["lName"]         = $data["user"][$i]["lName"];
        $data["developer"][$i]["dateOfBirth"]   = $data["user"][$i]["dateOfBirth"];
        $data["developer"][$i]["startDate"]     = $faker->unique()->dateTimeBetween('-4 years', 'now')->format('Y-m-d');
    }

    //give each developer a set of known languages
    for ($i = 0; $i < $num_devs; $i++){
        $data["progLanguage"][$i]["dFName"]       = $data["developer"][$i]["fName"];
        $data["progLanguage"][$i]["dLName"]       = $data["developer"][$i]["lName"];
        $data["progLanguage"][$i]["dDateOfBirth"] = $data["developer"][$i]["dateOfBirth"];
        $data["progLanguage"][$i]["language"]     = implode(", ",
            $faker->randomElements(['Java', 'SQL', 'C', 'C++', 'C#', 'Python'], random_int(1,6)));
    }

    //create the player list from users
    for ($i = ($num_users-$num_players); $i < $num_users ; $i++){
        $data["player"][$i]["fName"]        = $data["user"][$i]["fName"];
        $data["player"][$i]["lName"]        = $data["user"][$i]["lName"];
        $data["player"][$i]["dateOfBirth"]  = $data["user"][$i]["dateOfBirth"];
        $data["player"][$i]["headset"]      = implode(", ",
            $faker->randomElements(['HTC VIVE', 'Varjo', 'HTC VIVE Pro', 'HP Reverb', 'Oculus Quest', 'Valve Index'], random_int(1,6)));
        $data["player"][$i]["favGenre"]     = $faker->word();
    }

    //create the vr experiences using developer data
    for ($i = 0; $i < $num_VRexp; $i++){
        $data["VRExperience"][$i]["expID"]           = $faker->unique()->numberBetween(1000, 100000);

        $j = random_int(0, (count($data["developer"])-1));
        $data["VRExperience"][$i]["maintainerFName"] = $data["developer"][$j]["fName"];
        $data["VRExperience"][$i]["maintainerLName"] = $data["developer"][$j]["lName"];
        $data["VRExperience"][$i]["maintainerDOB"]   = $data["developer"][$j]["dateOfBirth"];
        
        $data["VRExperience"][$i]["name"]            = $faker->word();
        $data["VRExperience"][$i]["type"]            = $faker->word();
    }

    //give each vr experience a list of supported headsets
    for ($i = 0; $i < (count($data["VRExperience"])); $i++){
        $data["supportedHeadset"][$i]["expID"]   = $data["VRExperience"][$i]["expID"];
        $data["supportedHeadset"][$i]["headset"] = implode(", ",
            $faker->randomElements(['HTC VIVE', 'Varjo', 'HTC VIVE Pro', 'HP Reverb', 'Oculus Quest', 'Valve Index'], random_int(1,6)));
    }

    //create a series of development teams
    for ($i = 0; $i < $num_devTeam; $i++){
        $data["developmentTeam"][$i]["teamID"]      = $faker->unique()->numberBetween(1000, 100000);
        $data["developmentTeam"][$i]["type"]        = $faker->randomElement(['back-end', 'front-end', 'QA', 'integration']);
        $data["developmentTeam"][$i]["description"] = $faker->sentence();
    }

    //create the work interaction between developers, development teams, and vr experiences
    for ($i = 0; $i < $num_devs; $i++){
        $data["work"][$i]["dFName"]       = $data["developer"][$i]["fName"];
        $data["work"][$i]["dLName"]       = $data["developer"][$i]["lName"];
        $data["work"][$i]["dDateOfBirth"] = $data["developer"][$i]["dateOfBirth"];
        $data["work"][$i]["teamID"]       = $data["developmentTeam"][random_int(0, (count($data["developmentTeam"])-1))]["teamID"];
        $data["work"][$i]["expID"]        = $data["VRExperience"][random_int(0, (count($data["VRExperience"])-1))]["expID"];
    }


    //encode data to be sent to the dataload.php
    $encoded_data = json_encode($data);

    $json_encoded_file = fopen("dump.json", "w");

    fwrite($json_encoded_file, $encoded_data);
    fclose($json_encoded_file);

}catch(Exception $e){
    echo "Exception: ".$e->getMessage();
}

?>
Data successfully generated.