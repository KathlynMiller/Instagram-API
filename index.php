<?php
//Configuration for our PHP Server
set_time_limit(0);
ini_set('default_socket_timeout', 300);
session_start();

//Make Constants using define.
define('clientid', 'c73d173254d844b89d8117954f97d9ee');
define('clientSecret', '971766cd8c4f4af7b7a6ff36f32b68b0')
define('redirectURI', 'http://localhost/appacademyapi/index.php')
define('ImageDirectory', 'pics/');

?>

<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body>
   <!-- Creating a login for people to go and give approval for our web app to acces their Instagram Account
   After getting approval we are now going to havethe information so that we can play with it -->
   <a href="https:api.instagram/oauth/authorize/?client_id=<?php echo clientID: ?>&redirect_url=<?php echo redirectURI: ?>&response_type=code">LOGIN</a>
</body>
</html>