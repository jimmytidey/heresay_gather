<?

include('../header.php'); 

$results = $db->fetch("SELECT * FROM manual_updates WHERE location_name='' && lat != '--' LIMIT 100 ");

foreach($results as $result) {
    
    $lat = $result['lat'];
    $lng = $result['lng'];
        
    $geo_url = 'http://maps.googleapis.com/maps/api/geocode/json?latlng=' . $lat . ',' . $lng . '&sensor=false';
    echo $geo_url;
    $location_data = json_decode(file_get_contents($geo_url), true);
    echo $result['title'] . "<br />";
    echo $result['lat'] . "<br />";
    echo $result['lng'] . "<br />";
    //print_r();
    
    if (!isset($location_data['results'][0])) {
        echo('FAIL');
        print_r($location_data['results']);
    }
    else { 
        $location_name = $location_data['results'][0]['formatted_address']; 
        $id     = $result['id'];
        $query  = "UPDATE manual_updates
        SET location_name='$location_name'
        WHERE id=$id";
        $db->query($query);
        echo $query;
    }

    echo "<hr />";
}














?>