<? 

include ('../header.php');
include_once('../classes/simplepie/autoloader.php');
include_once('../classes/simplepie/idn/idna_convert.class.php');

//load all the scraper classes
foreach (glob("sites/*.php") as $filename) {
    include $filename;
}

$site   = $_GET['site'];

if ($site != 'default') { 
    $sql    = "SELECT * FROM manual_sites WHERE site='$site'"; 
}

else {
     $sql    = "SELECT * FROM manual_sites WHERE scraper=''"; 
}

$urls=$db->fetch($sql);

foreach ($urls as $url) { 
    
    echo "<h1>".$url['site']."</h1>";
    echo "<h2>".$url['url']."</h2>";
    
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
