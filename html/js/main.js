
//FOR THE EXPLORE SECTION 

heresay={};

$(document).ready(function() { 

	$('#btn_search').click(function(){ 
		var query = $('#search_query').val(); 
		window.location = "/explore/search/"+query; 
	});

	$(".save_tags_btn").click(function() { 
		var tags = []; 
		var tags_string
		var pub_id = $(this).attr('data-pub-id');
		console.log(pub_id);
		var tag_elems = $('span [data-pub-id="'+pub_id+'"]:checked');

		$.each(tag_elems, function(key, val){
			tags.push($(val).val());
			console.log($(val).val());
		}); 
	
		tags_string = encodeURIComponent(tags.join());
	
		var url = '/api/publications/save_tags.php?pub_id=' + pub_id + '&tags=' + tags_string; 
	
		$(this).parent().append("<img src='/img/ajax-loader-balls.gif' class='loader' />"); 
		
		$.getJSON(url, function(data){ 
			$('.loader').remove();
		});
	});



	$(".save_twitter_btn").click(function(){ 
		var twitter_handle = $(this).siblings().val();
		twitter_handle = encodeURIComponent(twitter_handle);
		var person_id = $(this).siblings().attr('data-person_id');
		var url = '/api/people/save_twitter_handle.php?person_id=' + person_id + '&twitter_handle=' + twitter_handle ; 
		$(this).parent().append("<img src='/img/ajax-loader-balls.gif' class='loader' />"); 
		
		$.getJSON(url, function(data){ 
			$('.loader').remove();
			console.log(data);
		});
	});


	//FOR THE GATHER SECTION 

	$('.btn_gather').click(function() { 
		var site	= $(this).attr('data-name');
		var site_id	= $(this).attr('data-id');
		var iframe_id 		= "#site_" + site_id;
		$(iframe_id).attr('src', "gather.php?site=" + site);
		$(iframe_id).css('height', '400px');
	});	
	
	
	//For the locate section
	
	var elem 	= $('.item');
	var maps 	= [];
	var markers = [];
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
		
	    maps[id] = new google.maps.Map($(".map", val)[0], myOptions);
		var myLatlng = new google.maps.LatLng(lat, lng);
		
	    markers[id] = new google.maps.Marker({
	        position: myLatlng, 
	        map: maps[id],
	        draggable:true,
	        title:"move me about"
	    });
		
	    //this adds the search stuff 
	    var input = $(".search", val)[0];
		console.log($(".search", val)[0]);
	    var autocomplete = new google.maps.places.Autocomplete(input);
	    autocomplete.bindTo('bounds', maps[id]);
    
	    google.maps.event.addListener(autocomplete, 'place_changed', function() {
        
	        var place = this.getPlace();                            
	        if (place.geometry.viewport) {
	            map.fitBounds(place.geometry.viewport);
	        } else {
	            map.setCenter(place.geometry.location);
	            map.setZoom(17);  // Why 17? Because it looks good.
	        }
        
	        var point = new google.maps.LatLng(place.geometry.location.lat(), place.geometry.location.lng());
	        markers[id].setPosition(point);
        
	    });		
	});
	
	$('.save_btn').click(function(){
		elem = $(this).parent().parent();
		
		lat 	= $(".map", elem).attr('data-lat');
		lng 	= $(".map", elem).attr('data-lng');
		id 		= $(".map", elem).attr('data-id');
		
		heresay.cat_elems = []; 
		
		$('.category_checkbox', elem).each(function(key,val){
			if($(val).is(':checked')){
				heresay.cat_elems.push($(this).val()); 
				console.log($(this).val());
			}
		});		
		
	    var position =  markers[id].getPosition();
	    var lat = position.lat();
	    var lng = position.lng(); 
	    var link = encodeURIComponent($('.gather_link', elem).attr('href'));
	    var category_1 = escape(heresay.cat_elems[0]);
	    var category_2 = escape(heresay.cat_elems[1]);
	    var category_3 = escape(heresay.cat_elems[2]);
	    var category_4 = escape(heresay.cat_elems[3]);
	    var favourite  = escape();	

		if($('.favourite_checkbox').is(':checked')) {
			favourite = 1; 
		}
		else { 
			favourite = 0; 
		}
		
		if($('.no_location_checkbox').is(':checked')) {
			lat = 0;
			lng = 0; 
		}
		
		$.get("/api/save.php?category_1="+category_1+"&category_2="+ category_2+"&category_3="+category_3+"&category_4="+category_4+"&lat="+lat+'&lng='+lng+'&id='+id+"&favourite="+favourite, function(html) { 
		    console.log(html);
		});
	});	
	
});






