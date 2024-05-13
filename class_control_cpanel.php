<?php 
include_once "settings.php";
class ClassControlCpanel
{
    
    public $cpanel_username,$cpanel_password,$subdomain,$domain,$directory,$result;
    public $database_name,$database_username,$database_user_password;
    public $servername,$sql_script_path;
    public $source_file,$destination_path;
    public function __construct($action) {
        $this->cpanel_username = CPANELUSERNAME ;
        $this->cpanel_password = CPANELPASSWORD;
        $this->subdomain = SUBDOMAIN;
        $this->domain = DOMAIN;
        $this->directory = DIRECTORY;
        $this->database_name = DBNAME;
        $this->database_username = DBUSERNAME;
        $this->database_user_password = DBUSERPASSWORD;
        $this->source_file = APPLICATIONSOURSE;
        $this->destination_path = DESTINATIONPATH;
        $this->servername = "localhost";
        $this->sql_script_path = MYSQLSCRIPTPATH;


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
            case 'CreateNewDatabaseUser':
            {
                $this->CreateNewDatabaseUser();
                break;
            }
            case 'SetPrivilageToDBUser':
            {
                $this->SetPrivilageToDBUser();
                break;
            }
            case 'DeployApplication':
            {
                $this->DeployApplication();
                break;
            }
            case 'RunSQLScriptPDOMethod':
            {
                $this->RunSQLScriptPDOMethod();
                break;
            }
            case 'RunSQLScriptWithCPanel':
            {
                $this->RunSQLScriptWithCPanel();
                break;
            }
            case 'RunSQLScriptMySQLiMethod':
            {
                $this->RunSQLScriptMySQLiMethod();
                break;
            }
            
            default:
            {
                echo $this->JSONResponse(0,'No Action Found..!');
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
            'db' => $this->database_name
        );
        $this->result = $this->CommonCURLRequest($query_params);
        $response_data = json_decode($this->result, true);
        $event_result = $response_data['cpanelresult']['event']['result'];
        $function = $response_data['cpanelresult']['func'];

        echo $this->JSONResponse($event_result,$function);
    }

    public function CreateNewDatabaseUser()
    {
       
        $query_params = array(
            'cpanel_jsonapi_user' => $this->cpanel_username,
            'cpanel_jsonapi_module' => 'MysqlFE',
            'cpanel_jsonapi_func' => 'createdbuser',
            'dbuser' => $this->database_username,
            'password' => $this->database_user_password
        );
        $this->result = $this->CommonCURLRequest($query_params);
        $response_data = json_decode($this->result, true);
        
        $event_result = $response_data['cpanelresult']['event']['result'];
        $event_reason = $response_data['cpanelresult']['event']['reason'];

        // $event_result = $response_data['cpanelresult']['event']['result'];
        // $function = $response_data['cpanelresult']['func'];

        echo $this->JSONResponse($event_result,$event_reason);
    }

    public function SetPrivilageToDBUser()
    {
       
        $query_params = array(
            'cpanel_jsonapi_module' => 'MysqlFE',
            'cpanel_jsonapi_func' => 'setdbuserprivileges',
            'cpanel_jsonapi_version' => 2,
            'db' => $this->database_name,
            'dbuser' => $this->database_username,
            'privileges' => 'ALL PRIVILEGES'
        );
        $this->result = $this->CommonCURLRequest($query_params);
        echo $this->result;
        $response_data = json_decode($this->result, true);
        $event_result = $response_data['cpanelresult']['event']['result'];
        $event_reason = $response_data['cpanelresult']['event']['reason'];

        echo $this->JSONResponse($event_result,$event_reason);
    }

    public function DeployApplication()
    {
        // Move the zip file to the destination folder
        if (copy($this->source_file, $this->destination_path . APPLICATIONFILENAME)) {
            // Open the zip file
            $zip = zip_open($this->destination_path . APPLICATIONFILENAME);
            if ($zip) {
                // Extract each file from the zip
                while ($zip_entry = zip_read($zip)) {
                    // Get the name of the file inside the zip
                    $filename = zip_entry_name($zip_entry);
                    // Create the destination directory if it doesn't exist
                    $dirname = dirname($this->destination_path . $filename);
                    if (!is_dir($dirname)) {
                        mkdir($dirname, 0755, true);
                    }
                    // Extract the file
                    if (zip_entry_open($zip, $zip_entry, "r")) {
                        $file_content = zip_entry_read($zip_entry, zip_entry_filesize($zip_entry));
                        file_put_contents($this->destination_path . $filename, $file_content);
                        zip_entry_close($zip_entry);
                    }
                }
                zip_close($zip);
                
                // Remove the zip file after extraction
                if (unlink($this->destination_path . APPLICATIONFILENAME)) {
                    echo $this->JSONResponse('1', "Selected package installed successfully..!");
                } else {
                    echo $this->JSONResponse('0', "Failed to remove the zip file after extraction.");
                }
            } else {
                echo $this->JSONResponse('0', "Failed to open the zip file.");
            }
        } else {
            echo $this->JSONResponse('0', "Failed to move the zip file.");
        }
        
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
    

    public function RunSQLScriptWithCPanel()
    {

                // Database connection settings
                
                 $query_params = array(
					'cpanel_jsonapi_user' => CPANELUSERNAME,
					'cpanel_jsonapi_apiversion' => 2,
					'cpanel_jsonapi_module' => 'cpanel',
					'cpanel_jsonapi_func' => 'execute_query',
					'cpanel_jsonapi_module2' => 'MysqlFE',
					'cpanel_jsonapi_func2' => 'execute_query',
					'arguments' => json_encode(array(
						'database' => DBNAME,
						'sql' => file_get_contents(MYSQLSCRIPTPATH)
					))
				);

                $this->result = $this->CommonCURLRequest($query_params);
                echo $this->result;
                // Check if the API call was successful
                if ($api2_response['cpanelresult']['data'][0]['status'] == 1) {
                    echo "SQL script executed successfully.";
                } else {
                    echo "Error executing SQL script: " . $api2_response['cpanelresult']['data'][0]['statusmsg'];
                }
    }

    public function RunSQLScriptPDOMethod()
    {
           
            try {
                 // Create a new PDO instance
					$dsn = "mysql:host=".$this->servername.";dbname=".DBNAME;
					$pdo = new PDO($dsn, DBUSERNAME, DBUSERPASSWORD);
					// Set PDO error mode to exception
					$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

					// Read SQL script from file
					$sqlScript = file_get_contents(MYSQLSCRIPTPATH);

					// Execute SQL script
					$pdo->exec($sqlScript);
            
					echo $this->JSONResponse(1,'SQL script executed successfully.');
            } catch(PDOException $e) {
                echo $this->JSONResponse(0,'Error executing SQL script'.$e);
            }
            
    }

    public function RunSQLScriptMySQLiMethod()
    {
         // Database connection settings
        $servername = $this->servername;
        $username = DBUSERNAME;
        $password = DBUSERPASSWORD;
        $dbname = DBNAME;
         $conn = new mysqli($servername, $username, $password, $dbname);
         if ($conn->connect_error) {
             die("Connection failed: " . $conn->connect_error);
         }
         $sqlScript = file_get_contents($this->sql_script_path);
         if ($conn->multi_query($sqlScript) === TRUE) {
             echo $this->JSONResponse(1,'SQL script executed successfully.');
         } else {
             echo $this->JSONResponse(0,'Error executing SQL script');
         }
         $conn->close();

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