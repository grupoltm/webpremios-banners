
( function( jQuery) {
	 
	 function activeDates() {
		 $.fn.datepicker.dates['pt-BR'] = {
			days: ["Dom", "Seg", "Ter", "Qua", "Qui", "Sex", "Sab"],
			daysShort: ["Dom", "Seg", "Ter", "Qua", "Qui", "Sex", "Sab"],
			daysMin: ["D", "S", "T", "Q", "Q", "S", "S"],
			months: ["Jan", "Fev", "Mar", "Abr", "Mai", "Jun", "Jul", "Ago", "Set", "Out", "Nov", "Dez"],
			monthsShort: ["Jan", "Fev", "Mar", "Abr", "Mai", "Jun", "Jul", "Ago", "Set", "Out", "Nov", "Dez"],
			today: "Hoje",
			clear: "Limpar",
			format: "dd/mm/yyyy",
			titleFormat: "MM yyyy", /* Leverages same syntax as 'format' */
			weekStart: 0
		};
		$(".datepicker").datepicker({
			format: 'dd/mm/yyyy',
			language: "pt-BR",
			autoclose: true
		});
	 }
	
    jQuery.wpMediaUploader = function( options ) {
        
        var settings = jQuery.extend({
            
            target : '.item', // The class wrapping the textbox
            uploaderTitle : 'Select or upload image', // The title of the media upload popup
            uploaderButton : 'Set image', // the text of the button in the media upload popup
            multiple : false, // Allow the user to select multiple images
            buttonText : 'Upload image', // The text of the upload button
            buttonClass : '.logo-upload', // the class of the upload button
            modal : false, // is the upload button within a bootstrap modal ?
        }, options );
        
        
        jQuery( settings.target ).append( '<div class="col-12 pb-2 mb-2"><a href="#" class="button button-primary button-large ' + settings.buttonClass.replace('.','') + '">' + settings.buttonText + '</a></div>' );
        jQuery( settings.target ).append('<div class="col-12"><img src="#" class="img-fluid" style="display: none;"/><input class="banner" name="banners[0]" type="hidden" /></div>')
        
        jQuery('body').on('click', settings.buttonClass, function(e) {
            
            e.preventDefault();
            var selector = jQuery(this).parents( settings.target );
            var custom_uploader = wp.media({
                title: settings.uploaderTitle,
                button: {
                    text: settings.uploaderButton
                },
                multiple: settings.multiple
            })
            .on('select', function() {
                var attachment = custom_uploader.state().get('selection').first().toJSON();
                selector.find( 'img' ).attr( 'src', attachment.url).show();
                selector.find( 'input' ).val(attachment.url);
				
				
				selector.find(".banner").attr('name', "banners["+ selector.parents(".imagem").attr("data-index") +"]");

                if( settings.modal ) {
                    jQuery('.modal').css( 'overflowY', 'auto');
                }
            })
            .open();
        });
        jQuery('body').on('click', '.editarItem', function(e) {
			var that = this;
			
			jQuery( that ).parents(".itemTemp").addClass('item');
			jQuery( that ).parents(".itemTemp").html( '<div class="col-12 pb-2 mb-2"><a href="#" class="button button-primary button-large ' + settings.buttonClass.replace('.','') + '">' + settings.buttonText + '</a></div><div class="col-12"><img src="#" class="img-fluid" style="display: none;"/><input class="banner" name="banners['+ jQuery(that).parents(".imagem").attr("data-index") +']" type="hidden" /></div>' );
        });
        
        
    }
	$(".addItem").on("click", function(){
		
		$(".imagem:eq(0)").find(".banner").attr('name', "banners[0]");
		var item = $(".imagem:eq(0)").clone();
		current = $(".imagem:last").attr("data-index");
		next = parseInt(current) + 1;
		$(item).find("label span").text(next);
		
		$(item).find(".data_inicio").attr('name', $(item).find(".data_inicio").attr('name').replace("0", next)).attr('required', true);
		$(item).find(".minuto_inicio").attr('name', $(item).find(".minuto_inicio").attr('name').replace("0", next));
		$(item).find(".hora_inicio").attr('name', $(item).find(".hora_inicio").attr('name').replace("0", next));
		$(item).find(".data_final").attr('name', $(item).find(".data_final").attr('name').replace("0", next)).attr('required', true);
		$(item).find(".hora_final").attr('name', $(item).find(".hora_final").attr('name').replace("0", next));
		$(item).find(".minuto_final").attr('name', $(item).find(".minuto_final").attr('name').replace("0", next));
		$(item).find(".link").attr('name', $(item).find(".link").attr('name').replace("0", next)).attr('required', true);
		$(item).attr("data-index", next);
		
		$(item).find(".banner").attr('name', "banners["+ next +"]");
		$(".imagem:last").after($(item).removeClass("d-none"));
		
		activeDates();
		
		return false;
	})
	$(".newBanner").on("click", ".removeItem", function(){
		$(this).parents(".imagem").remove();
		return false;
	})
	jQuery.wpMediaUploader();
	
	$('.apagar').on('click', function() {
		console.log(this);
		url = $(this).data("href");
		$("#apagar .confirmar").attr("href", url);
		$("#apagar").modal();
	})
	
	activeDates();
	
	
})(jQuery);