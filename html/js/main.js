
//FOR THE EXPLORE SECTION 

heresay={};

$(document).ready(function() { 

	//FOR THE GATHER SECTION 
	$('.btn_gather').click(function() { 
		var site	= $(this).attr('data-name');
		var site_id	= $(this).attr('data-id');
		var iframe_id 		= "#site_" + site_id;
		$(iframe_id).attr('src', "gather.php?site=" + site);
		$(iframe_id).css('height', '400px');
	});	
	
	
	//For the locate section
	$('.category_checkbox').attr('checked', false);
	var elem 	= $('.item');
	heresay.maps 	= [];
	heresay.markers = [];
	heresay.autocompletes = [];
	$.each(elem, function(key, val) { 

		lat 	= $(".map", val).attr('data-lat');
		lng 	= $(".map", val).attr('data-lng');
		id 		= $(".map", val).attr('data-id');
		zoom 	= parseInt($(".map", val).attr('data-zoom'));
		id 		= $(".map", val).attr('data-id');
		
		//locate 
	    var myOptions = {
			zoom: zoom,
			center: new google.maps.LatLng(lat, lng),
			mapTypeId: google.maps.MapTypeId.ROADMAP
	    };
		
	    heresay.maps[id] = new google.maps.Map($(".map", val)[0], myOptions);
		heresay.maps[id].heresay_id = id;
		var myLatlng = new google.maps.LatLng(lat, lng);
		
	    heresay.markers[id] = new google.maps.Marker({
	        position: myLatlng, 
	        map: heresay.maps[id],
	        draggable:true,
	        title:"move me about"
	    });
		
	    //this adds the search stuff 
	    var input = $(".search", val)[0];

	    heresay.autocompletes[id] = new google.maps.places.Autocomplete(input);
	    heresay.autocompletes[id].bindTo('bounds', heresay.maps[id]);
		heresay.autocompletes[id].heresay_id = id;
    
	    google.maps.event.addListener(heresay.autocompletes[id], 'place_changed', function() {
			
			var id = this.heresay_id;
			
			
	        var place = this.getPlace();
			
	        if (place.geometry.viewport) {
	            heresay.maps[id].fitBounds(place.geometry.viewport);
	        } else {
	            heresay.maps[id].setCenter(place.geometry.location);
	            heresay.maps[id].setZoom(17);  // Why 17? Because it looks good.
	        }
        
	        var point = new google.maps.LatLng(place.geometry.location.lat(), place.geometry.location.lng());
	        heresay.markers[id].setPosition(point);
        
	    });		
	});
	
	$('.save_btn').click(function(){
		elem = $(this).parent().parent();
		
		var lat 	= $(".map", elem).attr('data-lat');
		var lng 	= $(".map", elem).attr('data-lng');
		var id 		= $(".map", elem).attr('data-id');
		
		if(typeof heresay.autocompletes[id].getPlace().address_components !== 'undefined') {
		    var address_components = heresay.autocompletes[id].getPlace().address_components;
	    }
	    
	    else { 
	         var address_components = '';
	    }
		
		console.log(lat);
		console.log(lng);
		console.log(id);
		
		heresay.cat_elems = []; 
		
		$('.category_checkbox', elem).each(function(key,val){
			if($(val).is(':checked')){
				heresay.cat_elems.push($(this).val()); 
				console.log($(this).val());
			}
		});		
		
	    var position =  heresay.markers[id].getPosition();
	    var lat = position.lat();
	    var lng = position.lng(); 
	    var link = encodeURIComponent($('.gather_link', elem).attr('href'));
	    var category_1 = escape(heresay.cat_elems[0]);
	    var category_2 = escape(heresay.cat_elems[1]);
	    var category_3 = escape(heresay.cat_elems[2]);
	    var category_4 = escape(heresay.cat_elems[3]);
	    var favourite  = escape();	

		if($('.favourite_checkbox', elem).is(':checked')) {
			favourite = 1; 
		}
		else { 
			favourite = 0; 
		}
		
		if($('.no_location_checkbox', elem).is(':checked')) {
			lat = 0;
			lng = 0; 
		}
		
		
		$.get("/api/save.php?category_1="+category_1+"&category_2="+ category_2+"&category_3="+category_3+"&category_4="+category_4+"&lat="+lat+'&lng='+lng+'&id='+id+"&favourite="+favourite, function(html) { 
		    console.log(html);
		});
		
	});	
	
});






