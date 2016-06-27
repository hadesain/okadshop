/*$(document).ready(function () {
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
					console.log(data);
			},
			error:function (){}
		});

		
	

	});





});*/

/*$('.quotation-detail').fadeIn(1000);
		setTimeout(function(){ 
			$('html,body').animate({
	        scrollTop: $("#quotation-detail").offset().top},
	        'slow');
		}, 1000);*/