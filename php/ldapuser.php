<?php
set_time_limit(30);
/*
error_reporting(E_ALL);
ini_set('error_reporting', E_ALL);
ini_set('display_errors',1);
*/

if (isset($_SERVER["HTTP_ORIGIN"]) === true) {
	$origin = $_SERVER["HTTP_ORIGIN"];
	header('Access-Control-Allow-Origin: ' . $origin);
	header('Access-Control-Allow-Credentials: true');
	header('Access-Control-Allow-Methods: POST');
	header('Access-Control-Allow-Headers: Content-Type');

	if ($_SERVER["REQUEST_METHOD"] === "OPTIONS") {
		exit; // OPTIONS request wants only the policy, we can stop here
	}
}

$db = new SQLite3('../user.db');
$db->exec("CREATE TABLE if not exists usersetting(id INTEGER PRIMARY KEY, username TEXT, systemid TEXT)");

$data = "[";

if($_GET["saveuser"] != '')
{
	$count = $db->querySingle('SELECT count(*) from usersetting where systemid = "' . $_GET["systemid"] . '"');
	$sqltxt='';
	if($count > 0) {
		$sqltxt="Update usersetting Set username = '" . $_GET["saveuser"] . "' Where systemid = '" . $_GET["systemid"] . "'";
	} else {
		$sqltxt="INSERT INTO usersetting(username, systemid) VALUES('" . $_GET["saveuser"] . "', '" . $_GET["systemid"] . "')";
	}
	//echo $sqltxt;
	$db->exec($sqltxt);
}
else	
{
	$username= '';
	$count = $db->querySingle('SELECT count(*) from usersetting where systemid = "' . $_GET["systemid"] . '"');
	if($count > 0) {
		$username = $db->querySingle('SELECT username from usersetting where systemid = "' . $_GET["systemid"] . '"');
	}
	//echo 'user:'.$username;

	putenv('LDAPTLS_REQCERT=never');
	
	$ldaphost = "ldaps://XXX.XXX.XXX.XXX:636/";

	// Connecting to LDAP
	$ldapconn = ldap_connect($ldaphost)
          or die("That LDAP-URI was not parseable");

	// binding to ldap server
    $ldapbind = ldap_bind($ldapconn, "cn=XXXXXX,cn=users,dc=XXXXXX,dc=XXXXXX", "XXXXXXXXXXXXX");

    // verify binding
    if ($ldapbind) {
        //echo "LDAP bind successful...";
		
		
		$result = ldap_search($ldapconn,"cn=users,dc=XXXXXX,dc=XXXXXX", "(&(Objectclass=user)(!(objectClass=computer))(memberOf:1.2.840.113556.1.4.1941:=cn=XXXXX,cn=Groups,dc=XXXXXX,dc=XXXXXX))") or die ("Error in search query: ".ldap_error($ldapconn));
        $ldapdata = ldap_get_entries($ldapconn, $result);
       
        // SHOW ALL DATA
		//print_r($ldapdata[1]); 

		for ($i = 0; $i < count($ldapdata)-1; $i++) {
			if($ldapdata[$i]['samaccountname'][0] == $username) {
				$status = 'true';
			} else {
				$status = 'false';
			}
			
			$data .= '
			{
				name: "'.$ldapdata[$i]['samaccountname'][0].'",
				real_name: "",
				display_name: "'.$ldapdata[$i]['displayname'][0].'",
				image: "",
				language: "de_DE",
				layout: null,
				session: null,
				logged_in: '.$status.'
			},
';
		}
		
		
		
    } else {
        echo "LDAP bind failed...";
    }

$data .= "]";

echo $data;

}	

?>