<?php
    define('CPANELUSERNAME','sandsl23');
    define('CPANELPASSWORD','d0mainsecur1ty@123!@#x%1');
    define('DOMAIN','sandslab.com');
    define('SUBDOMAIN',$_POST['subdomainname']);
    define('DIRECTORY','/public_html/'.SUBDOMAIN);
    define('DBNAMEPREFIX','sandsl23_');
    define('DBNAME',DBNAMEPREFIX.$_POST['dbname']);
    define('DBUSERNAME',DBNAMEPREFIX.$_POST['dbusername']);
    define('DBUSERPASSWORD',$_POST['dbuserpassword']);
    define('APPLICATIONSOURSE','/home/sandsl23/public_html/createsubdomain/'.$_POST['application_file_name']);
    define('DESTINATIONPATH','/home/sandsl23/public_html/'.SUBDOMAIN.'/');
    define('APPLICATIONFILENAME',$_POST['application_file_name']);
    define('MYSQLSCRIPTPATH','/home/sandsl23/public_html/createsubdomain/sapphire_innovate_staging.sql');
   
?>