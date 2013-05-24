<? 


include ('../header.php');



$sql    = "SELECT * FROM manual_sites ";
// get all the urls associated with this site
$urls=$db->fetch($sql);

// feed those urls into the relevant scraper class (either default or the specific one)
foreach ($urls as $url) { 
    
    $site_name = urlencode($url['site']); 
    $name = $url['site']; 

     
    echo "<p><a href='index.php?site_name=$site_name'>$name</a></p>";
    
}







include ('../footer.php'); 



?>
