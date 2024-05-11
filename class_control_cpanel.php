<?php 

class ClassControlCpanel
{
    
    public $cpanel_username,$cpanel_password,$subdomain,$domain,$directory;
    public function __construct() {
        $this->cpanel_username = "sandsl23";
        $this->cpanel_password = "d0mainsecur1ty@123!@#x%1";
        $this->subdomain = 'newsubdomain';
        $this->domain = 'sandslab.com';
        $this->directory = "/public_html/".$this->subdomain;
    }
    
    
    
    
    public function __destruct() {
        
    }

}

?>