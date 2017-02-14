<?php
namespace admin;

session_start();

ini_set('display_errors', '1');

$term = $_GET['term'];

if (empty($term) || strlen($term) < 2) {
    echo 'Parameters incorrect';
    die();
}
// cnx à l'annuaire ldap :
$ds = ldap_connect("ldap://ldap-m2.in.ac-dijon.fr:389");
ldap_set_option($ds,LDAP_OPT_PROTOCOL_VERSION, 3) ;
// Support Active Directory
ldap_set_option($ds, LDAP_OPT_REFERRALS, 0);
$bound = ldap_bind($ds);
$filter = "(|(cn=".$term."*)(uid=".$term."*)(mail=".$term."*))";

$sr   = ldap_search($ds, "ou=personnels EN,ou=ac-dijon,ou=education,o=gouv,c=fr", $filter, array("cn", "uid", "mail"));
$data = ldap_get_entries($ds,$sr);

$resp = array();

foreach($data as $info) {
	if (isset($info['uid'][0])) {
		array_push($resp, array(
			'uid' => $info['uid'][0],
			'mail' => $info['mail'][0],
			'cn' => $info['cn'][0]
		));
	}
}

echo json_encode(array_slice($resp, 0, 50, true));