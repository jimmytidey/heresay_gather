<?


include(__DIR__ . '/../ini.php');
$db = new dbClass(DB_LOCATION, DB_USER_NAME, DB_PASSWORD, DB_NAME);


$results = $db->fetch("SELECT * FROM manual_updates WHERE postcode='' && lat != '--' && lat != '0'   LIMIT 2000 ");

foreach($results as $result) {
  
    $lat = $result['lat'];
    $lng = $result['lng'];
        
    if (!empty($lat)) {    
         sleep(1);
        $geo_url = 'http://maps.googleapis.com/maps/api/geocode/json?latlng=' . $lat . ',' . $lng . '&sensor=false';
        echo $geo_url;
        $location_data = json_decode(file_get_contents($geo_url), true);
        echo $result['title'] . "<br />";
        echo $result['lat'] . "<br />";
        echo $result['lng'] . "<br />";
        //print_r($location_data['results'][0]['address_components']);
        $post_code = '';
    
        foreach ($location_data['results'][0]['address_components'] as $address_component) { 
            if($address_component['types'][0] == 'postal_code' ||$address_component['types'][0]=='postal_code_prefix'){
            
                $post_code= $address_component['long_name'];
            }
        }
    
        print_r($post_code);
    
        if (!isset($location_data['results'][0])) {
            echo('FAIL');
            print_r($location_data['results']);
        }
        else { 
            $location_name = addslashes($location_data['results'][0]['formatted_address']);
            
            $id     = $result['id'];
            $query  = "UPDATE manual_updates
            SET location_name='$location_name', postcode='$post_code'
            WHERE id=$id";
            $db->query($query);
            echo $query;
        }

        echo "<hr />";
    }    
}














?>