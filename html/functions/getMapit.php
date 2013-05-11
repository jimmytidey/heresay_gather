<?

function getMapit($lat, $lng) {
            
    $geo_url = 'http://mapit.mysociety.org/point/4326/'. $lng.','. $lat;

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
    
   
    foreach($location_data as $location_datum) { 
        if ($location_datum['type_name'] == 'London borough') { 
            $borough = addslashes($location_datum['name']);
            
        }
        
        if ($location_datum['type_name'] == 'London borough ward') { 
            $ward = addslashes($location_datum['name']);
            
        }
        
        if ($location_datum['type_name'] == 'UK Parliament constituency') { 
            $constituency = addslashes($location_datum['name']);
            
        }

    }
       
    $result[0] = $constituency;
    $result[1] = $borough;    
    $result[2] = $ward;
    
    return $result; 
}














?>