<?php
$cpanel_username = "sandsl23";
$cpanel_password = "d0mainsecur1ty@123!@#x%1";
$domain = 'sandslab.com';
$database_name ='sandsl23_deva_db';
$database_user ='sandsl23_example_user1';
// Grant privileges to the database user
$query_params = array(
    'cpanel_jsonapi_module' => 'MysqlFE',
    'cpanel_jsonapi_func' => 'setdbuserprivileges',
    'cpanel_jsonapi_version' => 2,
    'db' => $database_name,
    'dbuser' => $database_user,
    'privileges' => 'ALL PRIVILEGES'
);
$query = "https://$domain:2083/json-api/cpanel?" . http_build_query($query_params);

echo "API Request URL: $query<br>";

$curl = curl_init();
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
curl_setopt($curl, CURLOPT_URL, $query);
curl_setopt($curl, CURLOPT_USERPWD, "$cpanel_username:$cpanel_password");

$result = curl_exec($curl);
if ($result === false) {
    error_log("cURL error: " . curl_error($curl));
    echo "Error: cURL error - " . curl_error($curl);
} else {
    echo $result."<br>Privileges granted successfully.<br>";
}