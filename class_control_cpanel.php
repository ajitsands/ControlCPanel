<?php 
include_once "settings.php";
class ClassControlCpanel
{
    
    public $cpanel_username,$cpanel_password,$subdomain,$domain,$directory;
    public function __construct($action) {
        $this->cpanel_username = CPANELUSERNAME ;
        $this->cpanel_password = CPANELPASSWORD;
        $this->subdomain = SUBDOMAIN;
        $this->domain = DOMAIN;
        $this->directory = DIRECTORY;
        $this->RequestHandler($action); 
    }

    public function RequestHandler($action)
    {
        switch($action)
        {
            case 'AddNewSubdomain':
            {
                $this->AddNewSubdomain();
                break;
            }
            case 'ListOfSubdomain':
            {
                $this->ListOfSubdomain();
                break;
            }
            default:
            {
                $this->JSONResponse(0,'No Action Found..!');
                break;
            }
                
        }

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
        $this->CommonCURLRequest($query_params);
        
    }
    public function ListOfSubdomain()
    {
        $query_params = array(
            'cpanel_jsonapi_module' => 'SubDomain',
            'cpanel_jsonapi_func' => 'listsubdomains',
            'cpanel_jsonapi_version' => 2,
            'domain' => $domain
        );
        $this->CommonCURLRequest($query_params);
        
    }
    public function CommonCURLRequest($query_params)
    {
        $query = "https://$this->domain:2083/json-api/cpanel?" . http_build_query($query_params);
       
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_URL, $query);
        curl_setopt($curl, CURLOPT_USERPWD, "$this->cpanel_username:$this->cpanel_password");
        
        $result = curl_exec($curl);
        if ($result === false) {
            error_log("cURL error: " . curl_error($curl));
        } else {

            $data = json_decode($result, true);
        
            // Access the value of 'reason' under 'data' array
            $reason = $data['cpanelresult']['data'][0]['reason'];
            $jsonresult = $data['cpanelresult']['data'][0]['result'];
            
           echo $this->JSONResponse($jsonresult,$reason);
        }
        curl_close($curl);
        
       
    }
    public function JSONResponse($jsonresult, $reason)
    {
        // Create an associative array to represent the JSON structure
        $response = array(
            "status" => $jsonresult,
            "message" => $reason
        );
    
        // Convert the associative array to JSON
        $JSONOut = json_encode($response);
    
        // Return the JSON string
        return $JSONOut;
    }
    public function __destruct() {
       // echo "This is for Testing";
    }

}
$action = $_POST['action'];
$ccp = new ClassControlCpanel($action);

?>