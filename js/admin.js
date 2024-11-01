jQuery(document).ready(function() {

	jQuery(".price_update").change(function(e) {
		
		var ok = wpeb_price_changed(jQuery(this).parent().parent())
		if(ok) {

			var nonce = jQuery(".woocat_main_row").attr("data-nonce");

			var data = {
				action : "woobulkedit_price",
				price : jQuery(this).val(),
				post_id : jQuery(this).attr("data-id"),
				nonce : nonce 
			}
			jQuery.post(ajaxurl , data);
		}
	});		

	jQuery(".price_update_sale").change(function(e) {

		var ok = wpeb_price_changed(jQuery(this).parent().parent())

		if(ok) {
			var nonce = jQuery(".woocat_main_row").attr("data-nonce");

			var data = {
				action : "woobulkedit_sale_price",
				price : jQuery(this).val(),
				post_id : jQuery(this).attr("data-id"),
				nonce : nonce
			}
			jQuery.post(ajaxurl , data);
		}
		else {
			//e.preventDefault();
		}
	});

});


function wpeb_price_changed(woocat_half) {
	
	var reg = parseFloat(woocat_half.find(".price_update").val()); //regular price

	var sale = parseFloat(woocat_half.find(".price_update_sale").val()); //sale price 
	//console.log(sale+", "+reg)	
	
	if(sale >= reg) {
		alert("Sale price should be less than regular price");
		return false;
	}
	else {
		return true;
	}

}