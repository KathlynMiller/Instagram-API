<?php
//Configuration for our PHP Server
set_time_limit(0);
ini_set('default_socket_timeout', 300);
session_start();

//Make Constants using define.
define('clientID', '62ec64b621af403e80b8fffba847c630'); // client id code
define('clientSecret', '292703a0ea7a419e8afb6ae6c900e43f'); // client secret code
define('redirectURI', 'http://localhost/appacademyapi/index.php'); // redirectURI linked url page
define('ImageDirectory', 'pics/'); // adding pics into pic folder

//function that is going to connect to Instagram.
function connectToInstagram($url){
	$ch = curl_init();

	curl_setopt_array($ch, array(
		CURLOPT_URL => $url,
		CURLOPT_RETURNTRANSFER => true,
		CURLOPT_SSL_VERIFYPEER => false,
		CURLOPT_SSL_VERIFYHOST => 2,
	));
	$result = curl_exec($ch);
	curl_close($ch);
	return $result;

}
// function to get userID cause userName doesnt allow us to get picture!
function getUserID($userName){
	$url = 'https://api.instagram.com/v1/users/search?q='.$userName.'&client_id='.clientID;
	$instagramInfo = connectToInstagram($url);
	$results = json_decode($instagramInfo, true);

	return $results['data'][0]['id'];
}
//function to print put images
function printImages($userID){
	$url = 'https:api.instagram.com/users'.$userID.'/media/recent?client_id='.clientID.'&count=5';
	$instagramInfo = connectToInstagram($url);
	$results = json_decode($instagramInfo, true);
	//Parse throught the information one by one.
	foreach($results['data'] as $items){
		$image_url = $items['images']['low_resolution']['url']; // going to go through all of my results and give myself back the URL of those pictures because we want to save itin the PHP Server.
		echo '<img src="'.$image_url.'"/></br>';
		//calling a function to save that $image_url
		savePictures($image_url);
	}

}

function savePicutres($image_url){
	echo $image_url . '<br>'; 
	$filename = basename($image_url); // the filename is what we are storing. basename is the PHP built in method that we are using to store $image_url
	echo $filename . '<br>';

	$destination = ImageDirectory . $filename;
	file_put_contents($destination, file_get_contents($image_url)); // goes and grabs an imagefile  and sotres it into our server
}

if (isset($_GET['code'])){
	$code = $_GET['code']; // function containing GET variable code
	$url = 'https://api.instagram.com/oauth/access_token'; // url
	$access_token_settings = array ('client_id' => clientID,// linked to clientID
	                               'client_secret' => clientSecret, // linked to clientSecret
                                   'redirect_url' => 'authorization_code', // linked to url
                                   'code' => $code // linked to code variable 
                                   );
//cURL is what we use in PHP, its a library calls to other API's.
$curl = curl_init($url); // setting a curl session and we put in $url because that's where we are getting the data from.
curl_setopt($curl, CURLOPT_POST, true);
curl_setopt($curl, CURLOPT_POST, $access_token_settings); // setting the POSTFIELDS to the array setup that we created.
curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1); // setting is equal to 1 because we are getting strings back.
curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);// but in live work-production we want to set this to true.

$result = curl_exec($curl);
curl_close($curl);

$results = json_decode($result, true);

$userName = $results['user']['username'];

$userID = getUserID($userName); // calling our function

printImages($userID); // printing our function
}
else { // added missing else statement
?>

<!DOCTYPE html>
<html>
<head>
	<title></title>
	<link rel="stylesheet" type="text/css" href="css/main.css">
</head>
<body>
   <!-- Creating a login for people to go and give approval for our web app to acces their Instagram Account
   After getting approval we are now going to havethe information so that we can play with it -->
   <a href="https://api.instagram.com/oauth/authorize/?client_id=<?php echo clientID; ?>&redirect_uri=<?php echo redirectURI; ?>&response_type=code">LOGIN</a> 
   <!--added login and url with echoing clientID and  redirectURI -->
</html>
<?php
}  // added missing bracket
?>