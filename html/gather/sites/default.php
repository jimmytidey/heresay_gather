<?
class scraperDefault {   
    function __construct($site) {
        $this->db = new dbClass(DB_LOCATION, DB_USER_NAME, DB_PASSWORD, DB_NAME);


        $feed = new SimplePie();
    	$feed->set_feed_url($site['url']);
    	
    	$feed->enable_cache(false);
    	$feed->init();
    	$feed->handle_content_type();

    	$max = $feed->get_item_quantity();
    	for ($x = 0; $x < $max; $x++)  {

    		$item = $feed->get_item($x);
    		
    		$title = $item->get_title();
            
            if (strpos($title, 'Re: ') === false) { 
            
        	    echo strip_tags($item->get_title()) . " - ".$item->get_date() ."\n\n"; 
                echo strip_tags($item->get_description()). "\n\n";
            
                $title          = strip_tags($item->get_title());
                $description    = strip_tags($item->get_description());
                $link           = $item->get_permalink();
                $date           = strtotime($item->get_date()); 
            
                $output = $this->db->save_update($site['site'], $title, $description, $link, $date);
                echo $output;
            }    
            echo "----------------------------------------\n\n";

        }

        
    }
}



?>