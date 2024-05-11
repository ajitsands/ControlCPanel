<?php 
include_once "settings.php";
class ClassControlCpanel
{
    
    public $cpanel_username,$cpanel_password,$subdomain,$domain,$directory;
    public function __construct() {
        $this->cpanel_username = CPANELUSERNAME ;
        $this->cpanel_password = CPANELPASSWORD;
        $this->subdomain = SUBDOMAIN;
        $this->domain = DOMAIN;
        $this->directory = DIRECTORY;

    }

    public function AddNewSubdomain()
    {
        $query_params = array(
            'cpanel_jsonapi_module' => 'SubDomain',
            'cpanel_jsonapi_func' => 'addsubdomain',
            'cpanel_jsonapi_version' => 2,
            'domain' => $this->subdomain,
            'rootdomain' => $this->domain,
            'dir' => $this->directory
        );
        
        $query = "https://$this->domain:2083/json-api/cpanel?" . http_build_query($query_params);
        
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_URL, $query);
        curl_setopt($curl, CURLOPT_USERPWD, "$this->cpanel_username:$this->cpanel_password");
        
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
    }
    
    
    
    
    public function __destruct() {
       // echo "This is for Testing";
    }

}

$ccp = new ClassControlCpanel();

?>