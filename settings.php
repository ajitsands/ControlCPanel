<?php
    define('CPANELUSERNAME','sandsl23');
    define('CPANELPASSWORD','d0mainsecur1ty@123!@#x%1');
    define('DOMAIN','sandslab.com');
    define('SUBDOMAIN',$_POST['subdomainname']);
    define('DIRECTORY','/public_html/'.SUBDOMAIN);
    define('DBNAMEPREFIX','sandsl23_');
    define('DBNAME',DBNAMEPREFIX.$_POST['dbname']);
    define('DBUSERNAME',$_POST['dbusername']);
    define('DBUSERPASSWORD',$_POST['dbuserpassword']);
   
?>