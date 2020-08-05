//Ryviu.com

jQuery(document).ready(function($) {
    $('.column-ryviu_meta > a').on('click', function(){
    	var thiss = $(this);
    	thiss.text('Updating...');
		$.ajax({
		 	url: ajaxurl,
		  	method: "POST",
		  	data: { 
		  		product_id : $(this).data('pid'),
		  		action: 'ryviu_update_meta'
		  	},
		  	dataType: "json",

		  	success: function(res){
		  		thiss.css({"display":"block","color": "green","font-weight": "bold"});
		  		thiss.text('Updated');
		  		if(res.meta_info){
			  		var meta_info = res.meta_info;
			  		meta_info = meta_info.replace('"', '');
			  		var meta_split = meta_info.split(";");
			  		var total = parseInt(meta_split[0]);
			  		var avg = parseFloat(meta_split[1]);avg = round(avg, 2);
			  		if(total>1){
				  		thiss.parent().find('.rv-number').html(total+' reviews');
			  		}else{
				  		thiss.parent().find('.rv-number').html(total+' review');
			  		}
			  		thiss.parent().find('.rv-rating').html('★ '+avg);
		  		}
		  	}
		}); 
	});
});
