<?php
//Configuration for our PHP Server
set_time_limit(0);
ini_set('default_socket_timeout', 300);
session_start();

//Make Constants using define.
define('clientid', '62ec64b621af403e80b8fffba847c630'); // client id code
define('clientSecret', '292703a0ea7a419e8afb6ae6c900e43f'); // client secret code
define('redirectURI', 'http://localhost/appacademyapi/index.php'); // redirectURI linked url page
define('ImageDirectory', 'pics/'); // adding pics into pic folder

if (isset($_GET['code'])){
	$code = ($_GET['code']); // function containing GET variable code
	$url = 'https://api.instagram.com/oauth/access_token'; // url
	$access_token_settings = array ('client_id' => clientID,// linked to clientID
	                               'client_secret' => clientSecret, // linked to clientSecret
                                   'redirect_url' => 'authorization_code', // linked to url
                                   'code' => $code // linked to code variable 
                                   );
//cURL is what we use in PHP, its a library calls to other API's.
$curl = curl_init($url);
curl_setopt($curl, CURLOPT_POST, true);
curl_setopt($curl, CURLOPT_POST, $access_token_settings);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
}

?>

<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body>
   <!-- Creating a login for people to go and give approval for our web app to acces their Instagram Account
   After getting approval we are now going to havethe information so that we can play with it -->
   <a href="https://api.instagram.com/oauth/authorize/?client_id=<?php echo clientID; ?>&redirect_url=<?php echo redirectURI; ?>&response_type=code">LOGIN</a> 
   <!--added login and url with echoing clientID and  redirectURI -->
</html>