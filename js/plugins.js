jQuery(function() {
	
// tooltip de joomla	
	jQuery('.hasTooltip').tooltip({"html": true,"container": "body"});

//Cierra el menu en responsivo al click.
    var navMain = jQuery('#nav-main');
    navMain.on('click', 'a:not([data-toggle="dropdown"])', null, function () {
        navMain.collapse('hide');
    });

//Lazy load para carga de imagenes
	jQuery('p img').lazyload({ 
		threshold : 200,
	    placeholder : 'http://loshijosdelrol.com/templates/ekilinejfw/img/loader.gif',
	    effect : "fadeIn" 
	});
	
// Canales de redes sociales al clic	

	jQuery('.compartirFB').on('click', function() {
	    jQuery(this).attr('href', 
	        'https://www.facebook.com/sharer/sharer.php?u=' + document.URL);
	});
	jQuery('.compartirTT').on('click', function() {
	    jQuery(this).attr('href', 
	        'http://twitter.com/share?text='+document.title+'&url='+document.URL);

	});
	jQuery('.compartirGP').on('click', function() {
	    jQuery(this).attr('href', 
	        'https://plus.google.com/share?url=' + document.URL);
	});	
	
// Adición de clases de bootstrap a contenidos que se generan al vuelo	

    jQuery('#jform_profile_dob-lbl').parent('.control-label').addClass('col-sm-3');

	
});

//Scroll para analytics 
//https://developers.google.com/analytics/devguides/collection/analyticsjs/events

jQuery(document).ready(function(){
	
    // Track scrolling events
    var trackBottomScroll = 0;
    
    jQuery(window).scroll(function() {
        if(trackBottomScroll < 100 && (jQuery(window).scrollTop() >= (jQuery(document).height() - jQuery(window).height()) / 100 * (trackBottomScroll + 10) )) {
            trackBottomScroll += 10;

        // en caso de ga undefined: http://stackoverflow.com/questions/18696998/ga-or-gaq-push-for-google-analytics-event-tracking
        	if (typeof ga !== 'undefined') {
	            ga('send', 'event', {
	                'eventCategory': 'Interaccion',
	                'eventAction': 'Scroll al ' + trackBottomScroll + '%',
	                'eventLabel': location.href
	                });
        	}
        }
    });     
    
});