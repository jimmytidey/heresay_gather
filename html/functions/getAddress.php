<?

function getAddress($lat, $lng) {
      
    $post_code ='';
    sleep(0.3);
    $geo_url = 'http://maps.googleapis.com/maps/api/geocode/json?latlng=' . $lat . ',' . $lng . '&sensor=false';
    echo $geo_url;
    
    $ch = curl_init(); 

    // set url 
    curl_setopt($ch, CURLOPT_URL, $geo_url); 

    //return the transfer as a string 
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 

    // $output contains the output string 
    $output = curl_exec($ch); 

    // close curl resource to free up system resources 
    curl_close($ch);
    
    
    $location_data = json_decode($output, true);

    //print_r($location_data['results'][0]['address_components']);
    $post_code = '';

    foreach ($location_data['results'][0]['address_components'] as $address_component) { 
        if($address_component['types'][0] == 'postal_code' ||$address_component['types'][0]=='postal_code_prefix'){
        
            $post_code = $address_component['long_name'];
        }
    }

    print_r($post_code);
    
    $location_name = addslashes($location_data['results'][0]['formatted_address']); 
    
    $return[0] = $post_code; 
    $return[1] = $location_name;
    return($return);
}



?>
