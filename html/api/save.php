<? 
include('../ini.php');
@$url = explode("/",$_GET['url']);
$db = new dbClass(DB_LOCATION, DB_USER_NAME, DB_PASSWORD, DB_NAME);

$lat =  mysql_real_escape_string($_GET['lat']);
$lng =  mysql_real_escape_string($_GET['lng']);
$category_1 =  mysql_real_escape_string($_GET['category_1']);
$category_2 =  mysql_real_escape_string($_GET['category_2']);
$category_3 =  mysql_real_escape_string($_GET['category_3']);
$category_4 =  mysql_real_escape_string($_GET['category_4']);
$id = mysql_real_escape_string(htmlspecialchars($_GET['id']));
$favourite = mysql_real_escape_string(htmlspecialchars($_GET['favourite']));


$query = "UPDATE manual_updates SET lat='$lat', lng='$lng', favourite='$favourite', category_1='$category_1', category_2='$category_2', category_3='$category_3', category_4='$category_4' WHERE id='$id'";
$db->query($query); 
echo $query;    
?>