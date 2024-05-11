<?php
$cpanel_username = "sandsl23";
$cpanel_password = "d0mainsecur1ty@123!@#x%1";
$subdomain = 'newsubdomain';
$domain = 'sandslab.com';
$directory = "/public_html/$subdomain";

$query_params = array(
    'cpanel_jsonapi_module' => 'SubDomain',
    'cpanel_jsonapi_func' => 'addsubdomain',
    'cpanel_jsonapi_version' => 2,
    'domain' => $subdomain,
    'rootdomain' => $domain,
    'dir' => $directory
);

$query = "https://$domain:2083/json-api/cpanel?" . http_build_query($query_params);

$curl = curl_init();
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
curl_setopt($curl, CURLOPT_URL, $query);
curl_setopt($curl, CURLOPT_USERPWD, "$cpanel_username:$cpanel_password");

$result = curl_exec($curl);
if ($result === false) {
    error_log("cURL error: " . curl_error($curl));
} else {
    echo $result;
}

curl_close($curl);

$data = json_decode($json_data, true);

// Access the value of 'reason' under 'data' array
$reason = $data['cpanelresult']['data'][0]['reason'];

// Access the value of 'module'
$module = $data['cpanelresult']['module'];

// Output the values
echo "Reason: $reason\n";
echo "Module: $module\n";
?>
