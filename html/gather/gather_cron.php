<? 

include(__DIR__ . '/../ini.php');

@$url = explode("/",$_GET['url']);
$db = new dbClass(DB_LOCATION, DB_USER_NAME, DB_PASSWORD, DB_NAME);


//Get the bitly converter
include_once(__DIR__ . '/../functions/getBitly.php');

//loads a class for reading RSS feeds
include_once(__DIR__ . '/../classes/simplepie/autoloader.php');
include_once(__DIR__ . '/../classes/simplepie/idn/idna_convert.class.php');

//load all the scraper classes from inside the sites directory
foreach (glob(__DIR__ . "/../gather/sites/*.php") as $filename) {
    include $filename;
}


//Cycle through the values
$current_value = $db->fetch('SELECT * FROM cron_manage');
$current_value = $current_value[0]['current_value'];

$max_query  = "SELECT * FROM manual_sites ORDER BY site_id DESC LIMIT 1"; 
$max_number = $db->fetch($max_query);
$max_number = $max_number[0]['site_id'];

if ($current_value >= $max_number) { 
    $sql    = "UPDATE cron_manage SET current_value = 0"; 
    $db->query($sql);
}
else { 
    $sql    = "UPDATE cron_manage SET current_value = current_value+1"; 
    $db->query($sql);
}

$sql    = "SELECT * FROM manual_sites WHERE site_id='$current_value'"; 

// get all the urls associated with this site
$urls=$db->fetch($sql);

// feed those urls into the relevant scraper class (either default or the specific one)
foreach ($urls as $url) { 
    
    echo "Site: ".$url['site']."\n\n<br/>";
    echo "URL: ".$url['url']."\n\n";
    
    if (empty($url['scraper'])) { 
        $scraper = new scraperDefault($url);
    }
    else { 
        $classname = "scraper".$url['scraper'];
        $scraper = new $classname($url);
    }
}

$sql    = "UPDATE cron_manage SET current_value = current_value+1"; 




?>
