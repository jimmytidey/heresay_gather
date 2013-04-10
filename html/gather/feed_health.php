<? 


include ('../header.php');

//loads a class for reading RSS feeds
include_once('../classes/simplepie/autoloader.php');
include_once('../classes/simplepie/idn/idna_convert.class.php');

//load all the scraper classes from inside the sites directory
foreach (glob("sites/*.php") as $filename) {
    include $filename;
}

$sql    = "SELECT * FROM manual_sites"; 

// get all the urls associated with this site
$urls=$db->fetch($sql);

// feed those urls into the relevant scraper class (either default or the specific one)
foreach ($urls as $url) { 
     
    echo "Site: " . $url['site']."<br/>";
    echo "URL: "  . $url['url']."<br/>";
    
    $recent_query   =   "SELECT * FROM manual_updates WHERE site='".$url['site']."' ORDER BY pubdate DESC LIMIT 1";
    $recent_post    =   $db->fetch($recent_query);
    echo $recent_query;
    print_r($recent_post);
    $string = date("F j, Y", $recent_post[0]['pubdate']);
    $color = 'black';
    if ($recent_post[0]['pubdate'] < time()-60*60*24*21) {
        $color = 'red';
    }
    echo "<p style='color:$color'>$string</p>";
    echo "<hr/>";
}







include ('../footer.php'); 



?>
