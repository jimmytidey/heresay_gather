<? 

include('../header.php');
include(__DIR__ . '/../functions/matchPlaces.php');

$site_name = @urldecode($_GET['site_name']);
$lat = @addslashes(urldecode($_GET['lat'])); 
$lng = @addslashes(urldecode($_GET['lng'])); 

$recent_date = time() - (60*60*24*60);

if(!empty($lat) && !empty($lng)) { 
    $query = "SELECT 
      *, 
       ( 3959 * acos( cos( radians($lat) ) * cos( radians(manual_sites.lat) ) 
       * cos( radians(manual_sites.lng) - radians($lng)) + sin(radians($lat)) 
       * sin( radians(manual_sites.lat)))) AS distance 
    FROM manual_sites 
    JOIN manual_updates ON manual_sites.site = manual_updates.site 
    WHERE category_1='' 
    && pubdate > $recent_date
    ORDER BY distance ASC 
    LIMIT 10";
    echo "<p>Locating by lat lng</p>";
}

else if(!empty($site_name)) { 
    $query              = "SELECT * FROM manual_updates WHERE category_1='' && site='$site_name' ORDER BY pubdate desc LIMIT 10";
    echo "<p>Locating by site name</p>";
}

else {
    echo "<p>Locating by latest date order</p>";
    $query          = "SELECT * FROM manual_updates WHERE category_1='' ORDER BY pubdate desc LIMIT 10"; 
}

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
             <?
                $text = $result['description'] . " " . $result['title'];
                $terms = extract_place_terms($text);
                print_r($terms);
             
             ?>
             
             
             <p class='site'>Site: <?echo strip_tags(htmlspecialchars_decode ($result['site'])) ?> </p>
         </div>     
        
         <div class='grid_6 omega'>
             <input name='no_location_<?=$i ?>' id='no_location_<?=$i ?>' class='no_location_checkbox'  type='checkbox' />
             <label for='no_location_<?=$i ?>'>This post has no location</label>
             <input  id='no_location_link_<?=$i ?>'  type='hidden'  value='<?echo $result['link'] ?>' />
                         
             <br/>
             
             <input type="checkbox"  name="favourite" id='favourite_<?=$i ?>' class='favourite_checkbox' value="1" /> Favourite<br>
             
             <br/>
             
            <input type="checkbox" checked='false' class='category_checkbox' <? checkcheck('local_knowledge', $categories) ?> value='local_knowledge'> Local history<br/>
            <input type="checkbox" class='category_checkbox' <? checkcheck('crime_emergencies', $categories) ?> value='crime_emergencies'> Crime and emergencies<br/>
            <input type="checkbox" class='category_checkbox' <? checkcheck('crime_emergencies', $categories) ?> value='jobs'> Jobs<br/>
            <input type="checkbox" class='category_checkbox' <? checkcheck('community_events', $categories) ?> value='community_events'> Community events<br/>
            <input type="checkbox" class='category_checkbox' <? checkcheck('forsale_giveaway', $categories) ?> value='forsale_giveaway'> Buy Sell<br/>
            <input type="checkbox" class='category_checkbox' <? checkcheck('charity', $categories) ?> value='charity'> Charity<br/> 
            <input type="checkbox" class='category_checkbox' <? checkcheck('pets_nature', $categories) ?> value='pets_nature'> Pets and nature<br/> 
            
            <br/>
            
            <input type="checkbox" class='category_checkbox' <? checkcheck('parks', $categories) ?> value='parks'> Parks<br/>               
            <input type="checkbox" class='category_checkbox' <? checkcheck('shops', $categories) ?> value='shops'> Shops<br/>
            <input type="checkbox" class='category_checkbox' <? checkcheck('restaurants_bars', $categories) ?> value='restaurants_bars'>Restaurants / Bars<br/>
            <input type="checkbox" class='category_checkbox' <? checkcheck('art', $categories) ?> value='art'> Art / music / culture<br/>
            <input type="checkbox" class='category_checkbox' <? checkcheck('sport', $categories) ?> value='sport'> Sport<br/>                          
            <input type="checkbox" class='category_checkbox' <? checkcheck('housing', $categories) ?> value='housing'> Housing<br/>                          
            <input type="checkbox" class='category_checkbox' <? checkcheck('health', $categories) ?> value='health'> Health<br/>                          


            <br/>

            <input type="checkbox" class='category_checkbox' <? checkcheck('lost', $categories) ?> value='lost'> Lost<br/>
            <input type="checkbox" class='category_checkbox' <? checkcheck('transport', $categories) ?> value='transport'> Transport<br/>
            <input type="checkbox" class='category_checkbox' <? checkcheck('council', $categories) ?> value='council'> Local Politics<br/> 
            <input type="checkbox" class='category_checkbox' <? checkcheck('planning', $categories) ?> value='planning'>Planning<br/> 
            
            <br/>
            
            <input type="checkbox" class='category_checkbox' <? checkcheck('dog_mess', $categories) ?> value='dog_mess'>Dog mess<br/> 
            <input type="checkbox" class='category_checkbox' <? checkcheck('refuse', $categories) ?> value='refuse'>Recycling / bins<br/> 
            
            
            <br/>
            
            <input type="checkbox" class='category_checkbox' <? checkcheck('kids', $categories) ?> value='kids'> Kids<br/>     
            <input type="checkbox" class='category_checkbox' <? checkcheck('disabilities', $categories) ?> value='disabilities'> Disabilities<br/>                                                                         
                                                                           
            <input type="checkbox" class='category_checkbox' <? checkcheck('elderly', $categories) ?> value='elderly'> Elderly<br/>                            

            
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