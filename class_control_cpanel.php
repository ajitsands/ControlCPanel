<?php 
include_once "settings.php";
class ClassControlCpanel
{
    
    public $cpanel_username,$cpanel_password,$subdomain,$domain,$directory,$result,$database_name;
    public function __construct($action) {
        $this->cpanel_username = CPANELUSERNAME ;
        $this->cpanel_password = CPANELPASSWORD;
        $this->subdomain = SUBDOMAIN;
        $this->domain = DOMAIN;
        $this->directory = DIRECTORY;
        $this->RequestHandler($action); 
        $this->database_name = DBNAME;
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
            case 'DeleteSubdomain':
            {
                $this->DeleteSubdomain();
                break;
            }
            case 'CreateNewDatabase':
            {
                $this->CreateNewDatabase();
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
       
        $this->result = $this->CommonCURLRequest($query_params);
        $response_data = json_decode($this->result, true);
        $data = $response_data['cpanelresult']['data'];

        foreach ($data as $item) {
            $jsonresult = $item['result'];
            $reason = $item['reason'];
        }

        echo $this->JSONResponse($jsonresult,$reason);
        
    }
    public function DeleteSubdomain()
    {
        $query_params = array(
            'cpanel_jsonapi_module' => 'SubDomain',
            'cpanel_jsonapi_func' => 'delsubdomain',
            'cpanel_jsonapi_version' => 2,
            'domain' => $this->subdomain.'.'.$this->domain,
            'rootdomain' => $this->domain
        );
       
        $this->result = $this->CommonCURLRequest($query_params);
        $response_data = json_decode($this->result, true);
        $data = $response_data['cpanelresult']['data'];

        foreach ($data as $item) {
            $jsonresult = $item['result'];
            $reason = $item['reason'];
        }

        echo $this->JSONResponse($jsonresult,$reason);
        
    }
    public function ListOfSubdomain()
    {
        $query_params = array(
            'cpanel_jsonapi_module' => 'SubDomain',
            'cpanel_jsonapi_func' => 'listsubdomains',
            'cpanel_jsonapi_version' => 2,
            'domain' => $domain
        );
        $this->result =  $this->CommonCURLRequest($query_params);
            $jsonArray = [];
            $slno = 1;

            $data = json_decode($this->result, true);

            if (isset($data['cpanelresult']['data'])) {
                $subdomains = array_column($data['cpanelresult']['data'], 'domain');
                foreach ($subdomains as $subdomain) {
                    $jsonElement = [
                        "slno" => $slno,
                        "subdomainname" => $subdomain
                    ];
                    $jsonArray[] = $jsonElement;
                    $slno++;
                }
                echo $this->JSONResponse(1,$jsonArray);
            } else {
                echo $this->JSONResponse(0,"No subdomains found.");
            }


    }

    public function CreateNewDatabase()
    {
        $query_params = array(
            'cpanel_jsonapi_module' => 'MysqlFE',
            'cpanel_jsonapi_func' => 'createdb',
            'cpanel_jsonapi_version' => 2,
            'db' => $database_name
        );
        $this->result = $this->CommonCURLRequest($query_params);
        echo $this->result;
    }
    public function CommonCURLRequest($query_params)
    {
        $query = "https://$this->domain:2083/json-api/cpanel?" . http_build_query($query_params);
       
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_URL, $query);
        curl_setopt($curl, CURLOPT_USERPWD, "$this->cpanel_username:$this->cpanel_password");
        
        $result = curl_exec($curl);
        curl_close($curl);
        if ($result === false) {
            //error_log("cURL error: " . curl_error($curl));
            echo $this->JSONResponse(0,"cURL error: " . curl_error($curl));
        } else {

           return $result;
        }
        
        
       
    }
    public function JSONResponse($jsonresult, $reason)
    {
        $response = array(
            "status" => $jsonresult,
            "message" => $reason
        );
        $JSONOut = json_encode($response);
        return $JSONOut;
    }
    public function __destruct() {
       // echo "This is for Testing";
    }

}
$action = $_POST['action'];
$ccp = new ClassControlCpanel($action);

?>