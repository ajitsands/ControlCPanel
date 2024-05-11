
<?php
$cpanel_username = "sandsl23";
$cpanel_password = "d0mainsecur1ty@123!@#x%1";
$domain = 'sandslab.com';
$database_name = 'sandsl23_deva_db';
$database_user = 'sandsl23_deva_user';
$database_password = 'S@nds1@b';

// Create the database
// $query_params = array(
//     'cpanel_jsonapi_module' => 'MysqlFE',
//     'cpanel_jsonapi_func' => 'createdb',
//     'cpanel_jsonapi_version' => 2,
//     'db' => $database_name
// );
// $query = "https://$domain:2083/json-api/cpanel?" . http_build_query($query_params);

// $curl = curl_init();
// curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
// curl_setopt($curl, CURLOPT_URL, $query);
// curl_setopt($curl, CURLOPT_USERPWD, "$cpanel_username:$cpanel_password");

// $result = curl_exec($curl);
// if ($result === false) {
//     error_log("cURL error: " . curl_error($curl));
//     echo "Error: cURL error - " . curl_error($curl);
// } else {
//     echo $result."<br>Database created successfully.<br>";
// }
//curl_close($curl);


// Check if the database user name is not empty
if (empty($database_user)) {
    echo "Error: Database user name cannot be empty.";
    exit;
}

// Debugging statement
echo "Database user name: $database_user";

// Create the database user
$query_params = array(
    'cpanel_jsonapi_module' => 'MysqlFE',
    'cpanel_jsonapi_func' => 'createdbuser',
    'cpanel_jsonapi_version' => 2,
    'name' => $database_user,
    'password' => $database_password
);
$query = "https://$domain:2083/json-api/cpanel?" . http_build_query($query_params);

$curl = curl_init();
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
curl_setopt($curl, CURLOPT_URL, $query);
curl_setopt($curl, CURLOPT_USERPWD, "$cpanel_username:$cpanel_password");

$result = curl_exec($curl);
if ($result === false) {
    error_log("cURL error: " . curl_error($curl));
    echo "Error: cURL error - " . curl_error($curl);
} else {
    // Decode the JSON response
    $json_response = json_decode($result, true);
    
    // Check if there's an error message
    if (isset($json_response['cpanelresult']['error'])) {
        echo "Error:- " . $json_response['cpanelresult']['error'];
    } else {
        echo $result."<br>Database user created successfully.<br>";
    }
}




// Grant privileges to the database user
// $query_params = array(
//     'cpanel_jsonapi_module' => 'MysqlFE',
//     'cpanel_jsonapi_func' => 'setdbuserprivileges',
//     'cpanel_jsonapi_version' => 2,
//     'user' => $database_user,
//     'database' => $database_name,
//     'privileges' => 'ALL PRIVILEGES'
// );
// $query = "https://$domain:2083/json-api/cpanel?" . http_build_query($query_params);

// curl_setopt($curl, CURLOPT_URL, $query);

// $result = curl_exec($curl);
// if ($result === false) {
//     error_log("cURL error: " . curl_error($curl));
//     echo "Error: cURL error - " . curl_error($curl);
// } else {
//     echo $result."<br>Privileges granted successfully.<br>";
// }

curl_close($curl);
?>

