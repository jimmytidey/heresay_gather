<?
class ScraperTwitterSearch { 
    
    function __construct($site) {
        
        $this->db = new dbClass(DB_LOCATION, DB_USER_NAME, DB_PASSWORD, DB_NAME);
        $this->connection = new twitterInterface();
        
        $results = $this->connection->search(array(
            'q' => urldecode($site['url']), 
            'count'=> 100
        ));
        
        
        foreach($results->statuses as $result)  {
           
            $id = $result->id_str;
            $username = $result->user->screen_name;
            
            $link   = "https://twitter.com/$username/statuses/" .$id ;
            $title  = $result->text;
            $date   = strtotime($result->created_at);
            $description = '';

            $output = $this->db->save_update($site['site'], $title, $description, $link, $date);
            echo $output;

            echo "----------------------------------------\n\n";
        }
    }
}

?>