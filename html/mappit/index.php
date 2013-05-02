<?

include('../header.php'); 

$results = $db->fetch("SELECT * FROM manual_updates WHERE borogh='' && postcode != '0' LIMIT 3");

foreach($results as $result) {
    
    sleep(1);
    $postcode = str_replace(' ', '', $result['link']);
    
        
    $geo_url = 'http://mapit.mysociety.org/postcode/' . $postcode;
    echo $geo_url;
    $location_data = json_decode(file_get_contents($geo_url), true);
    //print_r();
    
    if ($location_data['status_code'] != 200) {
        echo('FAIL');
        print_r($location_data);
    }
    else { 
        $short_url = addslashes($location_data['data']['url']); 
        $borough        = $result['areas'][2504]['name'];
        $constituency   = $result['areas'][65759]['name'];
        $ward           = $result['areas'][65759]['name'];
        
        $query  = "UPDATE manual_updates
        SET borough='$borough'
        WHERE id=$id";
        $db->query($query);
        echo $query;
    }

    echo "<hr />";
}














?>