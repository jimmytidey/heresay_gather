<?

include('../header.php'); 

$results = $db->fetch("SELECT * FROM manual_updates WHERE short_url='' && lat != '--' LIMIT 400");

foreach($results as $result) {
    
    sleep(2);
  
    $link = urlencode($result['link']);
    
        
    $geo_url = 'http://api.bit.ly/v3/shorten?apikey=R_47a9b2e5ba6ce9f6cac9a247c2a4e25c&login=jimmytidey&URI=' . $link;
    echo $geo_url;
    $location_data = json_decode(file_get_contents($geo_url), true);
    //print_r();
    
    if ($location_data['status_code'] != 200) {
        echo('FAIL');
        print_r($location_data);
    }
    else { 
        $short_url = addslashes($location_data['data']['url']); 
        $id     = $result['id'];
        $query  = "UPDATE manual_updates
        SET short_url='$short_url'
        WHERE id=$id";
        $db->query($query);
        echo $query;
    }

    echo "<hr />";
}














?>