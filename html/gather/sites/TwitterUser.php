<?
class ScraperTwitterUser { 
    
    function __construct($site) {
        
        $this->db = new dbClass(DB_LOCATION, DB_USER_NAME, DB_PASSWORD, DB_NAME);
        $this->connection = new twitterInterface();
        
        $results = $this->connection->userStatuses(array(
            'screen_name' => $site['url']
        ));
        
      //  print_r($results);
        
        foreach($results as $result)  {
           
            $id = $result->id_str;
            $username = $result->user->screen_name;
            
            $link   = "https://twitter.com/$username/statuses/" .$id ;
            $title  = $result->text;
            $date   = strtotime($result->created_at);
            $description = '';

            $output = $this->db->save_update($site['site'], $title, $description, $link, $date);
          //  echo $output;

            echo "----------------------------------------\n\n";
        }
        
    }
}

?>