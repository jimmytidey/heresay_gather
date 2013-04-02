<? 


include (__DIR__ . '/../header.php');

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
$db->query($sql);
include (__DIR__ . '/../footer.php'); 



?>
