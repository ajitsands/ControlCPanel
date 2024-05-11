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

        echo $this->directory;
    }
    
    
    
    
    public function __destruct() {
        echo "This is for Testing";
    }

}

$ccp = new ClassControlCpanel();

?>