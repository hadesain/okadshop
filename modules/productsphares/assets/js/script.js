/*$(document).ready(function(){
	$('a.add_to_quoataion_btn').click(function(){
		var idproduct = $(this).attr('idproduct');
		jQuery.ajax({
			url: WebSite+"modules/productsphares/php/ajax.php",
			data:{action:'addproducttoquotation',idproduct:idproduct},
			type: "POST",
			success:function(data){
				console.log(data);
			},
			error:function (){}
		});
	});
});*/