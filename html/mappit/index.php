<?

include(__DIR__ . '/../ini.php');
$db = new dbClass(DB_LOCATION, DB_USER_NAME, DB_PASSWORD, DB_NAME);

$results = $db->fetch("SELECT * FROM manual_updates WHERE borough='' && LENGTH(postcode)>=5 LIMIT 3");

foreach($results as $result) {
    
    sleep(1);
    $postcode = $result['postcode'];
    
        
    $geo_url = 'http://mapit.mysociety.org/postcode/' . $postcode;
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