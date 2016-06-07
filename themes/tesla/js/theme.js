(function($){
	$(document).ready(function(){
		$('ul.dropdown-menu [data-toggle=dropdown]').on('click', function(event) {
			event.preventDefault(); 
			event.stopPropagation(); 
			$(this).parent().siblings().removeClass('open');
			$(this).parent().toggleClass('open');
		});

		$('.gridview').click(function(){
			$('.listview').removeClass('active');
			$(this).addClass('active');
			$('.product-list').removeClass('list');
			$('.product-list .col-xs-12').removeClass('col-xs-12').addClass('col-xs-6').addClass('col-sm-4').addClass('col-md-3').addClass('paddingleft0');
		});

		$('.listview').click(function(){
			$('.gridview').removeClass('active');
			$(this).addClass('active');
			$('.product-list').addClass('list');
			$('.product-list .col-xs-6').addClass('col-xs-12').removeClass('col-xs-6').removeClass('col-sm-4').removeClass('col-md-3').removeClass('paddingleft0');
		});
		$('#media').carousel({
		    pause: true,
		    interval: false,
		});

		$('#lang_list').change(function(){
			$(this).parent().submit();
		});
		//product attributes script
		/*$('.attributes select').change(function(){
			updateQtePrice_attributes();
		});



		updateQtePrice_attributes();*/

		
	/*	$("a#home_popup").fancybox({
			'hideOnContentClick': true
		});
		$("#home_popup").trigger('click');

		$('#myModal').on('shown.bs.modal', function () {
		  $('#myInput').focus()
		})*/
		/*var yetVisited = localStorage['visited'];
	    if (!yetVisited) {
	        // open popup
	        localStorage['visited'] = 'yes';
	        $('#home_popup_block').modal('show');
	    }
		setTimeout(function(){ 
			localStorage.removeItem('visited');
		}, 200000);*/
		$('#registerForm').submit(function(){
			
		});

		$('.grower.CLOSE , .grower.OPEN').click(function(){
			if ($(this).hasClass('CLOSE')) {
				$(this).removeClass('CLOSE');
				$(this).addClass('OPEN');
			}else if ($(this).hasClass('OPEN')) {
				$(this).removeClass('OPEN');
				$(this).addClass('CLOSE');
			}
		});


	});
	$(window).load(function(){
      $('.flexslider').flexslider({
        animation: "slide",
        controlNav: "thumbnails",
        start: function(slider){
          $('body').removeClass('loading');
        }
      });
    });
})(jQuery);
function closeCommentForm(){
	$('#sendComment').slideUp('fast');
	$('input#addCommentButton').fadeIn('slow');
}

function updateQtePrice_attributes(){
	$('.not_in_comm').hide();
	var tmp = "";
	$('.attributes select').each(function(){
		var id_attribute = $(this).attr('attrID');
		var id_value = $(this).val();
		
			tmp += ('"'+id_attribute+'":"'+id_value+'",');
		/*if (id_value != 0) {};*/
		
	});
	tmp = tmp.slice(0,-1);
	var json  = '{'+tmp+'}'
	var product_id = $('#product_id').val();
	jQuery.ajax({
	url: WebSite+"includes/product/ajax.php",
	data:{action:'updateQtePrice_attributes',json:json,product_id:product_id},
	type: "POST",
	success:function(data){
		data = $.parseJSON(data);
		if (data.length != 0) {
			$('.content_prices .product-price p').html(data['sell_price']+' &euro;');
			$('.sell_price').val(data['sell_price']);
			$('.content_prices #quantityAvailable').html(data['quantity']);
			if (data['quantity'] ==0) {
				$('.content_prices #availability_statut').html('<span class="available" id="availability_value">Out of stock</span>');
				$('.add_to_cart_block').hide();
			}
			else{
				$('.content_prices #availability_statut').html('<span class="available" id="availability_value"><i class="fa fa-check"></i> En stock</span>');
				$('.add_to_cart_block').show();
				$('#quantity_wanted').attr('min',data['min_quantity']);
				$('#quantity_wanted').attr('value',data['min_quantity']);
			}
			
		}else{
			/*console.log(12);
			$('.not_in_comm').slideDown();
			$('.content_prices #quantityAvailable').html(0);
			$('.content_prices #availability_statut').html('<span class="available" id="availability_value">Out of stock</span>');
			$('.add_to_cart_block').hide();
			console.log(data.length);
			console.log(data);*/
		}
		//console.log(data);
		
		
	},
	error:function (){}
	});


}
