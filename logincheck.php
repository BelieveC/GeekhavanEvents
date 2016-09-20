<?php

session_start();



function chk_user( $uid, $pwd ) {

		if ($pwd) {
			$ds = ldap_connect("172.31.1.42");
			ldap_set_option($ds, LDAP_OPT_PROTOCOL_VERSION, 3);
			$a = ldap_search($ds, "dc=iiita,dc=ac,dc=in", "uid=$uid" );
			$b = ldap_get_entries( $ds, $a );
			$dn = $b[0]["dn"];
			$ldapbind=@ldap_bind($ds, $dn, $pwd);
			if ($ldapbind) {
				return 1;
			} else {
				return 0;
			}
			ldap_close($ds);
		} else {
			return 0;
		}
	}
		
	function get_name($uid) {
		$ds=ldap_connect("172.31.1.42");
		

		ldap_set_option($ds, LDAP_OPT_PROTOCOL_VERSION, 3);
		if ($ds)
		{
			$bnd=ldap_bind($ds);
			$srch=ldap_search($ds, "dc=iiita,dc=ac,dc=in", "uid={$uid}");
			$info=ldap_get_entries($ds, $srch);
			ldap_close($ds);

			$userdn=$info[0]["dn"];
			$usernm=$info[0]["cn"][0];

			return $info[0]["cn"][0];
		} else {
			return "Not available";
		}
	}

	
	$user=$_REQUEST['roll'];
	$pass=$_REQUEST['pass'];
	
	$true=chk_user($user, $pass);
	$data = "";
	
	if($true){
	
		$name=get_name($user);
		$arr = explode("-",$name);
		$fname1=substr($name, 0, strrpos($name, "-"));
		$fname=str_replace("-", " ", $fname1);
		$_SESSION['name']=$name;
		$_SESSION['fname']=$fname;
		$new="";
		
	
		$data = $user;
		
	}
	else{
		$data = "invalid credentials";
	}

	
	echo $data;
	$new = '<meta http-equiv="refresh" content="0; url=http://127.0.0.1:5000/checklogin/'.$data.'" />'
	

?>
<html>
<head>
	<?php
	echo "logging you in as";
	echo $new;
	?>
</head>
<body>
</body>
</html>