<?php
require_once("composer/vendor/autoload.php");

try
{
    $faker = Faker\Factory::create();

    //two depts per buidling
    $num_depts = 50;
    $num_build = 25;
    $num_instructors = 200;

    //data structure to hold dept info
    // depts[] {
    //    dept_name
    //    building
    //    budget
    // }

    for ($i = 0; $i < $num_depts; $i++){
        $data["department"][$i]["dept_name"] = $faker->unique()->word();
        
        //new building when index odd
        if(!($i % 2)){
            $data["department"][$i]["building"] = $faker->unique()->word();
        }
        else {
            $data["department"][$i]["building"] = $depts[$i-1]["building"];
        }

        $data["department"][$i]["budget"] = $faker->numberBetween(150,500)*1000;
    }

    for ($i = 0; $i < $num_instructors; $i++){
        $data["instructor"][$i]["id"] = $i;
        $data["instructor"][$i]["name"] = $faker->name();             
        $data["instructor"][$i]["dept_name"] = 
            data["department"][random_int(0, count($data["department"]))]["dept_name"];
        $data["instructor"][$i]["salary"] = $faker->randomFloat(2, 50000, 100000);
    }

    $dept_Data_Encoded = json_encode($data);

    $json_encoded_file = fopen("datadump.json", "w");
    fwrite($json_encoded_file, $dept_Data_Encoded);
    fclose($json_encoded_file);

}catch(Exception $e){
    echo "Exception: ".$e->getMessage();
}

echo "<PRE>";
print_r($dept_Data_Encoded);
echo "</PRE>";

?>