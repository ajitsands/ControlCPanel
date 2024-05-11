<?php
$cpanel_username = "sandsl23";
$cpanel_password = "d0mainsecur1ty@123!@#x%1";
$domain = 'sandslab.com';

$query_params = array(
    'cpanel_jsonapi_module' => 'SubDomain',
    'cpanel_jsonapi_func' => 'listsubdomains',
    'cpanel_jsonapi_version' => 2,
    'domain' => $domain
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
    $data = json_decode($result, true);
    if (isset($data['cpanelresult']['data'])) {
        $subdomains = array_column($data['cpanelresult']['data'], 'domain');
        echo "Subdomains:<br>";
        foreach ($subdomains as $subdomain) {
            echo $subdomain . "<br>";
        }
    } else {
        echo "No subdomains found.";
    }
}

curl_close($curl);
?>
