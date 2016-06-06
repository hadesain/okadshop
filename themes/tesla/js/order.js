
function updateAddressesDisplay(){
	var id_address_delivery = $('#id_address_delivery').val();
	var id_address_invoice = $('#id_address_invoice').val();
	var adresse_multiple = $('#adresse_multiple').is(':checked');
	jQuery.ajax({
	url: WebSite+"includes/order/order.php",
	data:{action:'getAdresse',idadress:id_address_delivery,setSession:"adress_liv"},
	type: "POST",
	success:function(data){
		if (data != "" && data != "0") {
			var data = $.parseJSON(data);
			ajaxUpdateAddresses("address_delivery",data);
			
			if (adresse_multiple) {
				$("#adresse_select_invoice").slideUp();
				ajaxUpdateAddresses("address_invoice",data);
			}else{
				$("#adresse_select_invoice").slideDown();
				jQuery.ajax({
				url: WebSite+"includes/order/order.php",
				data:{action:'getAdresse',idadress:id_address_invoice,setSession:"adress_fact"},
				type: "POST",
				success:function(data2){
					if (data2 != "" && data2 != "0") {
						var data2 = $.parseJSON(data2);
						ajaxUpdateAddresses("address_invoice",data2);
					}
				},
				error:function (){}
				});
			}
			
		}
		
	},
	error:function (){}
	});
	
}

function ajaxUpdateAddresses(id,data){

	$('#'+id+' .address_firstname').text(data['lastname'] +' '+data['firstname']);
	$('#'+id+' .address_address1').text(data['addresse']);
	$('#'+id+' .address_postcode').text(data['codepostal'] +' '+data['city']);
	$('#'+id+' .address_Country').text(data['country']);
	$('#'+id+' .address_phone').text(data['phone']);
	$('#'+id+' .address_mobile').text(data['mobile']);
	$('#'+id+' .address_company').text(data['company']);
	$('#'+id+' .address_update a.update').attr("href",WebSite+"account/adresse?id_address="+data['id']+"&fromcart=1");/*account/adresse?id_address=2*/
	$('#'+id+' .address_update a.delete').attr("href",WebSite+"account/addresses?id_delete="+data['id']+"&fromcart=1");
	var full_adress = '<b>'+data['lastname'] +' '+data['firstname'] + ' </b><br><b>'+ data['company'] + '</b><br> ' +data['addresse'] + ' <br>' + data['codepostal'] + ' ' + data['city'] + ' <br>' + data['country']+' <br>'+ ' ' + data['mobile'];
	//console.log(full_adress);
	if (id == "address_delivery") {
		$('#shipping_address').val(full_adress);
		$('#id_country').val(data['id_country']);
	}else if (id == "address_invoice") {
		$('#invoice_address').val(full_adress);
	};

}

$(document).ready(function($){
	updateAddressesDisplay();

	$('.get-order-detail').click(function(){
		$('.order-detail').hide();
		var order_id = $(this).attr('orderId');
		jQuery.ajax({
		url: WebSite+"includes/order/order.php",
		data:{action:'getOrder',order_id:order_id},
		type: "POST",
		success:function(data){
			if (data != "" && data != "0") {
				var data = $.parseJSON(data);
				$('.order-detail .order-detail-title').text("Commande "+data['id']+" du "+data['cdate']);
				$('.order-detail .payment-methode').text(data['methode']);
				$('.order-detail .order-date').text(data['cdate']);
				$('.order-detail .order-status').text(data['status']);
				data['total'] = parseFloat(data['total']).toFixed(2);
				$('#product-order-list .price').html(data['total']+' &euro;');
				$('#address_fact .address_address1').text(data['address_invoice']);
				$('#address_liv .address_address1').text(data['address_delivery']);
				
				//get adress facturation
				/*jQuery.ajax({
				url: WebSite+"includes/order/order.php",
				data:{action:'getAdresse',idadress:data['adress_fact']},
				type: "POST",
				success:function(data2){
					if (data2 != "" && data2 != "0") {
						var data2 = $.parseJSON(data2);
						$('#address_fact .address_firstname').text(data2['firstname'] +' '+data2['firstname']);
						$('#address_fact .address_address1').text(data2['addresse']);
						$('#address_fact .address_postcode').text(data2['codepostal'] + ' '+data2['city']);
						$('#address_fact .address_Country').text(data2['country']);
						$('#address_fact .address_phone').text(data2['phone']);
						$('#address_fact .address_mobile').text(data2['mobile']);
					}
					
				},
				error:function (){}
				});*/

				//get adress livraison
				/*jQuery.ajax({
				url: WebSite+"includes/order/order.php",
				data:{action:'getAdresse',idadress:data['adress_liv']},
				type: "POST",
				success:function(data2){
					if (data2 != "" && data2 != "0") {
						var data2 = $.parseJSON(data2);
						$('#address_liv .address_firstname').text(data2['firstname'] +' '+data2['firstname']);
						$('#address_liv .address_address1').text(data2['addresse']);
						$('#address_liv .address_postcode').text(data2['codepostal'] + ' '+data2['city']);
						$('#address_liv .address_Country').text(data2['country']);
						$('#address_liv .address_phone').text(data2['phone']);
						$('#address_liv .address_mobile').text(data2['mobile']);
					}
					
				},
				error:function (){}
				});*/

				//get Order Product List
				jQuery.ajax({
				url: WebSite+"includes/order/order.php",
				data:{action:'getProductOrder',order_id:order_id},
				type: "POST",
				success:function(data2){
					if (data2 != "" && data2 != "0") {
						var data2 = $.parseJSON(data2);
						var tmp="";
						for (var i = 0; i < data2.length; i++) {
							data2[i]['product_price'] = parseFloat(data2[i]['product_price']).toFixed(2);
							tmp += '<tr><td><p><strong>'+data2[i]['product_name']+'</strong></p> <p><strong>Référence : </strong></p></td><td>'+data2[i]['product_quantity']+'</td><td>'+data2[i]['product_price']+' €</td><td>'+(data2[i]['product_price'] * data2[i]['product_quantity'] )+' €</td></tr>';
						};
						$('#product-order-list tbody').html(tmp);
					}
				},
				error:function (){}
				});
			}
		},
		error:function (){}
		});
	$('.order-detail').fadeIn(1000);
	setTimeout(function(){ 
		$('html,body').animate({
        scrollTop: $("#order-detail").offset().top},
        'slow');
	}, 1000);
	
	});





});