
<?php
$cpanel_username = "sandsl23";
$cpanel_password = "d0mainsecur1ty@123!@#x%1";
$domain = 'sandslab.com';

// cPanel API endpoint
$api_endpoint = 'https://'.$domain.':2087/json-api/cpanel';

// cPanel API credentials
// Data to send in the request
$post_data = array(
    'cpanel_jsonapi_user' => $cpanel_username,
    'cpanel_jsonapi_module' => 'MysqlFE',
    'cpanel_jsonapi_func' => 'createdbuser',
    'dbuser' => 'sandsl23_example_user1',
    'password' => 'S@nds1@b'
);
$query = "https://$domain:2083/json-api/cpanel?" . http_build_query($post_data);

// Initialize cURL session
$curl = curl_init();

curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
curl_setopt($curl, CURLOPT_URL, $query);
curl_setopt($curl, CURLOPT_USERPWD, "$cpanel_username:$cpanel_password");
// Execute the request
$response = curl_exec($curl);

// Check for errors
if ($response === false) {
    echo 'Error: ' . curl_error($curl);
} else {
    echo 'Response: ' . $response;
}

// Close cURL session
curl_close($curl);
?>
