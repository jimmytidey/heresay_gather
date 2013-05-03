<?

include(__DIR__ . '/../ini.php');
$db = new dbClass(DB_LOCATION, DB_USER_NAME, DB_PASSWORD, DB_NAME);

$results = $db->fetch("SELECT * FROM manual_updates WHERE borough='0' && lat>0 LIMIT 200");

foreach($results as $result) {
    
    sleep(1);
    $lat = $result['lat'];
    $lng = $result['lng'];
    $id = $result['id'];
        
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
            echo $borough;
        }
        
        if ($location_datum['type_name'] == 'London borough ward') { 
            $ward = addslashes($location_datum['name']);
            echo $ward;
        }
        
        if ($location_datum['type_name'] == 'UK Parliament constituency') { 
            $constituency = addslashes($location_datum['name']);
            echo $constituency;
        }

    }
    

    
    $query  = "UPDATE manual_updates
    SET borough='$borough', ward='$ward', constituency='$constituency'
    WHERE id=$id";
    $db->query($query);
    echo $query;
    

    echo "<hr />";
}














?>