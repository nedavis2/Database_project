<?php
//data loader
// 1. read from json file into array structure
// 2. connect to database
// 3. insert all data into respective rows in the correct order

//reading json file
try{
    $file_name = "datadump.json";

    $json_contents = file_get_contents($file_name);

    $data = json_decode($json_contents);

}catch(Exception $e){
    echo "JSON Exception: " . $e->getMessage();
}
echo "<PRE>";
print_r($data);
echo "</PRE>";
?>