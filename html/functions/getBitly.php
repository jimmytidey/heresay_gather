<?

function getBitly($link) { 
     
     $link = urlencode($link);
     $url = 'http://api.bit.ly/v3/shorten?apikey=R_47a9b2e5ba6ce9f6cac9a247c2a4e25c&login=jimmytidey&URI=' . $link;
     
     echo $url;

     $ch = curl_init(); 

     // set url 
     curl_setopt($ch, CURLOPT_URL, $url); 

     //return the transfer as a string 
     curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 

     // $output contains the output string 
     $output = curl_exec($ch); 

     // close curl resource to free up system resources 
     curl_close($ch);    

     $location_data = json_decode($output, true);

     if ($location_data['status_code'] != 200) {
         return false;
     }

     else if (strlen($location_data['data']['url']) < 5) { 
         return false;
     }

     else { 
        $short_url = $location_data['data']['url']; 
        return $short_url;
     }
}

?>