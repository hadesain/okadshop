$(document).ready(function(){
	$('body').append('<div id="add_to_quoataion_form" style="display:none;width: 95%;"></div>');
	$("a.add_to_quoataion_btn").fancybox({
        'hideOnContentClick': true,
          autoSize : false,
/*          scrolling : 'no',*/
          beforeLoad : function() {         
           // this.width  = 600;  
            //this.height = 700;
        }
    });

    $('a#show_cart_popup').fancybox();

    $('.carrier-pop').on('click', function() {
    	var idcarrier = $(this).attr('idcarrier');
    	//get carrier description
    	jQuery.ajax({
			url: WebSite+"modules/quotationfront/php/includes/ajax.php",
			data:{action:'getcarrier',idcarrier:idcarrier},
			type: "POST",
			success:function(data){
				data = $.parseJSON(data);
				if (data[0] != undefined) {
					data = data[0];
					$('#carriermodal #carrier_description').html(data['description']);
					$('#carriermodal').modal('show');   
					//console.log(data);
				};
			},
			error:function (){}
		});
		return false;
	});

    $('.delete_product').click(function(){

    	var idproduct = $(this).attr("pid");
    	var dec = $(this).attr("dec");
    	jQuery.ajax({
			url: WebSite+"modules/quotationfront/php/includes/ajax.php",
			data:{action:'deleteproduct',idproduct:idproduct,dec:dec},
			type: "POST",
			success:function(data){
				if(data == 1){
					location.reload();
				}
			},
			error:function (){}
		});

	});

	$('.refresh_qty_product').click(function(){
		var parent = $(this).parent().parent();
    	var idproduct = parent.attr("pid");
    	var dec = parent.attr("dec");
    	var qty = parent.find("input[type=number]").val();
    	jQuery.ajax({
			url: WebSite+"modules/quotationfront/php/includes/ajax.php",
			data:{action:'updateQteProduct',idproduct:idproduct,dec:dec,qty:qty},
			type: "POST",
			success:function(data){
				if(data == 1){
					location.reload();
				}
			},
			error:function (){}
		});

	});


	//image preview
	popImage();


	$('#add_product_to_quoataion').click(function(){
		$('#addproduct_alert').css('display','none');
		var parent = $(this).parent();
    	var qty = parent.find("#qty").val();
    	var cu = parent.find(".cu").val();
    	var prix = parent.find(".sell_price").val();
    	var idproduct = parent.attr("id_product");
    	jQuery.ajax({
			url: WebSite+"modules/quotationfront/php/includes/ajax.php",
			data:{action:'addproducttoquotation',idproduct:idproduct,cu:cu,qty,qty,prix:prix},
			type: "POST",
			success:function(data){
				if(data != 0){
					data = $.parseJSON(data);
					$('#addproduct_alert').html('<div class="alert alert-info" role="alert">'+data['ok']+'</div>');
					$('#addproduct_alert').css('display','block');
				}
			},
			error:function (){}
		});

	});
    
	$('a.add_to_quoataion_btn').click(function(){
		var idproduct = $(this).attr('idproduct');
		/*jQuery.ajax({
			url: WebSite+"modules/quotationfront/php/includes/ajax.php",
			data:{action:'addproducttoquotation',idproduct:idproduct},
			type: "POST",
			success:function(data){
				var form = "";
				if(data == 1){
					form += '<div class="panel panel-default"><div class="panel-body"><form role="form" action="" method="POST" style="min-width: 272px;min-height: 160px;"><div class="alert alert-info" role="alert">Le produit à ete bien ajouter au devis</div>';
					form += '<p><a class="button_large btn_quotation closeForm" href="javascript:;" style="margin: 10px 0;width: 100%;" title="continuer mon devis">continuer mon devis</a></p>';
					form += '<p><a class="button_large btn_quotation" href="'+WebSite+'cart" style="margin: 10px 0;width: 100%;" title="continuer mon devis">soumettre mon devis</a></p>';
					form += '</form> </div></div>';
				}
				$('#add_to_quoataion_form').html(form);
				$('a.closeForm').click(function(){
					parent.$.fancybox.close();
				});
			},
			error:function (){}
		});*/
		jQuery.ajax({
			url: WebSite+"modules/quotationfront/php/includes/ajax.php",
			data:{action:'getLiteProductForm',idproduct:idproduct},
			type: "POST",
			success:function(data){
				$('#add_to_quoataion_form').html(data);
				$('.cu').val(getAttributeCu());
			    $('.attributes select').change(function(){
			        $('.cu').val(getAttributeCu());
			    });
				$('#add_to_quoataion_btn_confirm').click(function(){
			    	var parent = $(this).parent();
			    	var qty = parent.find("#qty").val();
			    	var cu = parent.find(".cu").val();
			    	var prix = parent.find(".sell_price").val();
			    	var idproduct = parent.attr("id_product");
			    	jQuery.ajax({
						url: WebSite+"modules/quotationfront/php/includes/ajax.php",
						data:{action:'addproducttoquotation',idproduct:idproduct,cu:cu,qty,qty,prix:prix},
						type: "POST",
						success:function(data2){
							var form = "";
							if(data2 != 0){
								data2 = $.parseJSON(data2);
								form += '<div class="panel panel-default"><div class="panel-body"><form role="form" action="" method="POST" style="font-size: 18px;min-width: 272px;min-height: 160px;"><div class="alert alert-info" role="alert">'+data2["ok"]+'</div>';
								form += '<p><a class="button_large btn_quotation" onclick="$.fancybox.close()" href="javascript:;" style="margin: 10px 0;width: 100%;font-size: 18px;" title="">'+data2["btn1"]+'</a></p>';
								form += '<p><a class="button_large btn_quotation" href="'+WebSite+'cart" style="margin: 10px 0;width: 100%;font-size: 18px;" title="">'+data2["btn2"]+'</a></p>';
								form += '</form> </div></div>';
							}
							$('#add_to_quoataion_form').html(form);
						},
						error:function (){}
					});
			    });
			},
			error:function (){}
		});
	});

	$('#recyclable').change(function(){
		$('#recyclable').prop('checked', true);
	});
/*	$('#send_quotation').click(function(){
		if ($('#cgv_checkbox:checked').length == 0) {
			$('#cgv_warning_msg').css('display','block');
			return false;
		};
	});*/

	$( "#send_quotation_form" ).submit(function( event ) {
	  	if ($('#cgv_checkbox:checked').length == 0) {
			$('#cgv_warning_msg').css('display','block');
			event.preventDefault();
			return false;
		};
	});

	/*$('.payment_module input[name="payment_methode"]').click(function(){
		var code_promo = $('#code_promo').val();
		
		jQuery.ajax({
			url: WebSite+"modules/quotationfront/php/includes/ajax.php",
			data:{action:'check_cart_rule'},
			type: "POST",
			success:function(data){
				console.log(data);
			},
			error:function (){}
		});
	});*/
	$('.quotation_action').change(function(){
		var action = $(this).val();
		var id_quotation = $(this).attr('id_quotation');
		$('.quotation_action_btn').removeAttr('download');
		$('.quotation_action_btn').attr('href','#');
		$('.quotation_action_btn').addClass('detail-quotation-skip');
		switch(action) {
		    case 'download':
		    	var link = WebSite+'pdf/quotation.php?id_quotation='+id_quotation;
		        $('.quotation_action_btn').attr('href',link).prop('download','');
		        break;
		    case 'pay':
		        var link = WebSite+'cart/paiement?quotation_edit='+id_quotation;
		        $('.quotation_action_btn').attr('href',link);
		        break;
		    case 'details':
		        $('.quotation_action_btn').attr('href','javascript:;');
		        $('.quotation_action_btn').removeClass('detail-quotation-skip');
		        break;
		    case 'edit':
		        var link = WebSite+'cart?quotation_edit='+id_quotation;
		        $('.quotation_action_btn').attr('href',link);
		        break;
		        break;
		}
	});

	 $('.quotation_action_btn').click(function(){

	 });


	 	$('.detail-quotation').click(function(){
			if ($(this).hasClass('detail-quotation-skip')) {
				return;
			}
			$('.quotation-detail').hide();
			var idquotation = $(this).attr('devisId');
			jQuery.ajax({
				url: WebSite+"modules/quotationfront/php/includes/ajax.php",
				data:{action:'getquotationhistory',idquotation:idquotation},
				type: "POST",
				success:function(data){
						//console.log(data);
						if (data != 0) {
								$('#quotation_detail_table').html(data);
								popImage();
								quotation_send_message();
								pop_quote_rejected();
								pop_quote_contact();
								$('.quotation-detail').fadeIn(1000);
									setTimeout(function(){ 
										$('html,body').animate({
								        scrollTop: $("#quotation-detail").offset().top},
								        'slow');
									}, 1000);
						}
				},
				error:function (){}
			});

		});



});


function popImage(){
	$('.pop').on('click', function() {
		var big_image = $(this).find('img').attr('src').replace("80x80", "360x360");
		$('.imagepreview').attr('src', big_image);
		$('#imagemodal').modal('show'); 
		return false;  
	});
}

function pop_quote_rejected(){
	$('.pop_quote_rejected').on('click', function() {
		$('#message_bloc').modal('show'); 
		return false;  
	});
}


function pop_quote_contact(){
	$('.pop_quote_contact').on('click', function() {
		$('#message_bloc3').modal('show'); 
		return false;  
	});
}

function quotation_send_message(){
	$('.send_quotation_message').click(function(){
		var object = $(this).parent().parent().find('select').val();
		var message = $(this).parent().parent().find('textarea').val();
		var idquotation = $(this).attr('idquotation');
		var id_alert = $(this).attr('id_alert');
		var rejected = $(this).attr('rejected');

		//$('.'+id_alert).hide(1000);
		if (message == '') {
			$('.'+id_alert).removeClass('alert-info').addClass('alert-danger').html('Message Vide!!').show(1000);
			setTimeout(function(){
						$('.'+id_alert).hide(1000);
				}, 2000);
			return false;
		}
		jQuery.ajax({
			url: WebSite+"modules/quotationfront/php/includes/ajax.php",
			data:{action:'sendquotationmessage',idquotation:idquotation,message:message,object:object,rejected:rejected},
			type: "POST",
			success:function(data){
					//console.log(data);
					try {
					   data = $.parseJSON(data);
					   if (data['result'] != undefined) {
					   		$('.'+id_alert).removeClass('alert-danger').addClass('alert-info').html(data['result']).show(1000);
					   }else if(data['error'] != undefined) {
					   		$('.'+id_alert).removeClass('alert-info').addClass('alert-danger').html(data['error']).show(1000);
					   }
					}
					catch(err) {
					    
					}
				setTimeout(function(){
					$('.'+id_alert).hide(1000);
					if (rejected == 1) {
						location.reload();
					}
				}, 2000);
				

			},
			error:function (){}
		});
	});
	return false;
}
function edit_quotation(){
	
}