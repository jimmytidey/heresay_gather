<? 

include('../header.php'); 
$query              = "SELECT * FROM manual_updates WHERE lat='' ORDER BY id desc LIMIT 10";
$results            = $db->fetch($query);

$location_query     = "SELECT * FROM manual_sites ORDER BY site_id desc";
$location_results   = $db->fetch($location_query);



?>
<h1>Locate</h1>

<? 
    $i = 0;
    foreach($results as $result) { ?>
     <div class='item grid_12 article' style='border-bottom:1px solid black'>
         
         <div class='grid_6 alpha'>
            <?
            
            $categories = array($result['category_1'], $result['category_2'], $result['category_3'], $result['category_4']);
         
            if (empty( $result['title'] )) { 
                $result['title'] = "NO TITLE";  
            }

            foreach($location_results as $location_result) { 
                if ($location_result['site'] == $result['site']) { 
                    $lat = $location_result['lat'];
                    $lng = $location_result['lng'];
                    $zoom = $location_result['zoom'];
                }
            } 

            if (empty($lat)){ 
                $lat = 51.5073346;
                $lng = -0.1276831;
                $zoom = 12;
            }
            if (empty($zoom)){ 

                $zoom = 12;
            }
            ?>
            <div class='map' data-lat='<?= $lat  ?>' data-id='<?=$result['id'] ?>' data-lng='<?= $lng  ?>' data-zoom='<?= $zoom  ?>' > </div>
            
            <p>Search <input type='text'  class='search'  /> </p>  
            
            
             <h3><a href='<?echo $result['link'] ?>' target='_blank' class='gather_link'><?echo $result['title'] ?></a></h3>
             <p class='description'><?echo strip_tags(htmlspecialchars_decode ($result['description'])) ?> </p>
             <p class='site'>Site: <?echo strip_tags(htmlspecialchars_decode ($result['site'])) ?> </p>
         </div>     
        
         <div class='grid_6 omega'>
             <input name='no_location_<?=$i ?>' id='no_location_<?=$i ?>' class='no_location_checkbox'  type='checkbox' />
             <label for='no_location_<?=$i ?>'>This post has no location</label>
             <input  id='no_location_link_<?=$i ?>'  type='hidden'  value='<?echo $result['link'] ?>' />
                         
             <br/>
             
             <input type="checkbox"  name="favourite" id='favourite_<?=$i ?>' class='favourite_checkbox' value="1" /> Favourite<br>
             
             <br/>
             
            <input type="checkbox" checked='false' class='category_checkbox' <? checkcheck('local_knowledge', $categories) ?> value='local_knowledge'> Local knowledge<br/>
            <input type="checkbox" class='category_checkbox' <? checkcheck('crime_emergencies', $categories) ?> value='crime_emergencies'> Crime and emergencies<br/>
            <input type="checkbox" class='category_checkbox' <? checkcheck('crime_emergencies', $categories) ?> value='jobs'> Jobs<br/>
            <input type="checkbox" class='category_checkbox' <? checkcheck('community_events', $categories) ?> value='community_events'> Community events<br/>
            <input type="checkbox" class='category_checkbox' <? checkcheck('forsale_giveaway', $categories) ?> value='forsale_giveaway'> Buy Sell<br/>
            <input type="checkbox" class='category_checkbox' <? checkcheck('charity', $categories) ?> value='charity'> Charity<br/>                            
            <input type="checkbox" class='category_checkbox' <? checkcheck('pets_nature', $categories) ?> value='pets_nature'> Pets and nature<br/> 
            <input type="checkbox" class='category_checkbox' <? checkcheck('parks', $categories) ?> value='pets_nature'> Parks<br/>               
            <input type="checkbox" class='category_checkbox' <? checkcheck('shops_restaurants', $categories) ?> value='shops_restaurants'> Shops<br/>
            <input type="checkbox" class='category_checkbox' <? checkcheck('restaurants_bars', $categories) ?> value='shops_restaurants'>Restaurants / Bars<br/>
            <input type="checkbox" class='category_checkbox' <? checkcheck('art', $categories) ?> value='art'> Art / music / culture<br/>
            <input type="checkbox" class='category_checkbox' <? checkcheck('sport', $categories) ?> value='sport'> Sport<br/>                          
            <input type="checkbox" class='category_checkbox' <? checkcheck('food_drink', $categories) ?> value='food_drink'> Food and Drink<br/>
            <input type="checkbox" class='category_checkbox' <? checkcheck('lost', $categories) ?> value='lost'> Lost<br/>
            <input type="checkbox" class='category_checkbox' <? checkcheck('transport', $categories) ?> value='transport'> Transport<br/>
            <input type="checkbox" class='category_checkbox' <? checkcheck('council', $categories) ?> value='council'> Council business<br/> 
            <input type="checkbox" class='category_checkbox' <? checkcheck('kids', $categories) ?> value='kids'> Kids<br/>                                                                         
            
            <input type='button' value='save' class='save_btn'  /> 
            
         </div>
         
      </div>
   
     <?
    $i++;
 }   
 
function checkcheck($cat, $categories) {
    if (array_search($cat, $categories)) { 
        echo "checked='checked'";
    }
}
 
 
?>        







<? include('../footer.php'); ?>