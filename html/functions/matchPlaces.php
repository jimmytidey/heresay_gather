<?                                      
//Match street anmes and palces. Not this assumes the first place and street are the most important and returns them
function extract_place_terms($text, $area = null, $country = null){
    $return = false;

    //TODO: remove obvious places - downing street, scotland yard etc

    //find roads?
    $street_regex = "/(?:\s*[A-Z]\w+?)+\s+(?:Street|Road|Square|Park|Avenue|Oval|Crescent|Gardens|Lane|Way|Walk|Boulevard|Terrace|Row|Place|Close|Mews|Hill)/";
    $street_match = match_first($text, $street_regex);

    //remove 'in months'
    $text = preg_replace("/in (January|Febuary|March|April|May|June|July|August|September|October|November|December)/", " ", $text);

    //remove streets
    $text = preg_replace("/(?:\s*[A-Z]\w+?)+\s+(?:Street|Road|Square|Park|Avenue|Oval|Crescent|Gardens|Lane|Way|Walk|Boulevard|Terrace|Row|Place|Close|Mews)/", " ", $text);

    //Place - in XXX
    $place_regex = "/ in [A-Z]\w+(,( [A-Z]\w+)+)?/";
    $place_match = match_first($text, $place_regex);
    $place_match = str_replace(" in ", "", $place_match);

    //Place - missing from XXX
    if(!isset($place_match) || $place_match == ""){
        $place_regex = "/ from ([A-Z]\w+(,( [A-Z|a-z]\w+)+)?).*since/";
        preg_match_all($place_regex, $text, $place_matches, PREG_PATTERN_ORDER);
        $place_match = $place_matches[1][0];
    }

    $place_match = trim($place_match);

    $can_match = false;

    //got a street and a place or area?
    if(has_value($street_match) && (has_value($place_match) || has_value($area))){
        $can_match  = true;
    //got a place and an area?
    }else if(has_value($place_match) && has_value($area)){
        $can_match  = true;
    }

    //if can match, build return var
    if($can_match){
        $return = array();
        if(has_value($street_match)){
            $return['street'] = $street_match;
        }
        if(has_value($place_match)){
            $return['place'] = $place_match;
        }
        if(has_value($area)){
            $return['area'] = $area;
        }
        if(has_value($country)){
            $return['country'] = $country;
        }

    }
    print_r($return);

    return $return;
}

function match_first($first, $second) { 
    $value = preg_match($second, $first);
    
    return $value;
}

function has_value($val) { 
    if(empty($val)) { 
        return false;
    }
    else { 
        return true;
    }
}


?>