<? 


include(__DIR__ . '/../ini.php');
include(__DIR__ . '/../functions/getBitly.php');

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


$site       = @$_GET['site'];
$site_id    = @$_GET['site_id'];

if ($site !='') {
    if ($site != 'default') { 
        $sql    = "SELECT * FROM manual_sites WHERE site='$site'"; 
    }

    else {
         $sql    = "SELECT * FROM manual_sites WHERE scraper=''"; 
    }
}

else if ($site_id !='') {
    $sql    = "SELECT * FROM manual_sites WHERE site_id='$site_id'";

}
else { 
    echo "<h2>No site provided</h2>";
}

// get all the urls associated with this site
$urls=$db->fetch($sql);

// feed those urls into the relevant scraper class (either default or the specific one)
foreach ($urls as $url) { 
    
    echo "Site:".$url['site']."\n\n";
    echo "URL".$url['url']."\n\n";
    
    if (empty($url['scraper'])) { 
        $scraper = new scraperDefault($url);
    }
    else { 
        $classname = "scraper".$url['scraper'];
        $scraper = new $classname($url);
    }
}







include ('../footer.php'); 



?>
