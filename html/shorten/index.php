<?
include(__DIR__ . '/../ini.php');
$db = new dbClass(DB_LOCATION, DB_USER_NAME, DB_PASSWORD, DB_NAME);
$results = $db->fetch("SELECT *
FROM manual_updates
WHERE short_url = '0'
ORDER BY ID DESC
LIMIT 100");

foreach($results as $result) {
    
    sleep(1);
  
    $link = urlencode($result['link']);
        
    $geo_url = 'http://api.bit.ly/v3/shorten?apikey=R_47a9b2e5ba6ce9f6cac9a247c2a4e25c&login=jimmytidey&URI=' . $link;
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
    //print_r();
    
    if ($location_data['status_code'] != 200) {
        echo('FAIL');
        print_r($location_data);
    }
    
    else if (strlen($location_data['data']['url']) < 5) { 
        echo "This URL doesn't look right";
        
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