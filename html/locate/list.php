<? 


include ('../header.php');



$sql    = "SELECT DISTINCT site FROM manual_sites ORDER BY site";
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
