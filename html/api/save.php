<? 
include('../ini.php');

include('../functions/getAddress.php');
include('../functions/getMapit.php');

@$url = explode("/",$_GET['url']);
$db = new dbClass(DB_LOCATION, DB_USER_NAME, DB_PASSWORD, DB_NAME);

$lat                = mysql_real_escape_string($_GET['lat']);
$lng                = mysql_real_escape_string($_GET['lng']);
$category_1         = mysql_real_escape_string($_GET['category_1']);
$category_2         = mysql_real_escape_string($_GET['category_2']);
$category_3         = mysql_real_escape_string($_GET['category_3']);
$category_4         = mysql_real_escape_string($_GET['category_4']);
$id                 = mysql_real_escape_string(htmlspecialchars($_GET['id']));
$favourite          = mysql_real_escape_string(htmlspecialchars($_GET['favourite']));

$address_results    = getAddress($lat, $lng);
$postcode           = $address_results[0];
$location_name      = $address_results[1]; 

$mapit_results      = getMapit($lat, $lng);
$constituency       = $mapit_results[0];
$borough            = $mapit_results[1];
$ward               = $mapit_results[2];


$query = "UPDATE manual_updates 
SET lat='$lat', lng='$lng', favourite='$favourite', category_1='$category_1', category_2='$category_2', 
category_3='$category_3', category_4='$category_4', 
postcode='$postcode',  location_name='$location_name', constituency='$constituency', borough='$borough', ward='$ward' WHERE id='$id'";
$db->query($query); 

echo $query;    


?>