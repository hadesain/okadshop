/**
 * =====================
 *		Cart script
 * =====================
 */

$(document).ready(function($){

	refreshCart();
	$('.ajax_add_to_cart_button').click(function(){
		var l = $(this).attr('l');
		var p = $(this).attr('p');
		var q = $(this).attr('q');
		var t = $(this).attr('t');
		var product_image = $(this).closest( ".product-item" ).find('img');
		cartAction("ajout",l,q,p,t,product_image);
		return false;
	});
	
	$('.ajax_add_to_cart_product_button').click(function(){
		var l = $(this).attr('l');
		var p = $('#product_sell_price').attr('p');
		var q = $('#quantity_wanted').val();
		var t = $(this).attr('t');
		var product_image = $('.product_image_galery img').eq(0);
		cartAction("ajout",l,q,p,t,product_image);
		return false;
	});

	$('.cart_quantity_down , .cart_quantity_up').click(function(){
		var input = $(this).parent().parent().find('.cart_quantity_input');
		var result = null;
		var l = input.attr('l');
		if ($(this).hasClass('cart_quantity_down')) {
			result = updateInputQty(input,'down');
		}else if($(this).hasClass('cart_quantity_up')){
			result = updateInputQty(input,'up');
		}
		if (result == 0) {
			cartAction('suppression',l,null,null,null,null);
			
			refrechPage();
		};	
		
		var tmp = '';
		$('.cart_quantity_input').each(function(){ 
			var qty = $(this).val();
			var l = $(this).attr('l');
			tmp += '"'+l+'":'+qty+',';
		});
		tmp = '{'+tmp.slice(0,-1)+'}';
		refrechCartQtys(tmp);

	});

	$('.refresh_qty_product').click(function(){
		var parent = $(this).parent().parent();
    	var idproduct = parent.attr("pid");
    	var dec = parent.attr("dec");
    	var qty = parent.find("input[type=number]").val();
    	jQuery.ajax({
			url: WebSite+"includes/cart/index.php",
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

	
	$('#cart_panel_refresh').click(function(){
		var tmp = '';
		$('.cart_quantity_input').each(function(){ 
			var qty = $(this).val();
			var l = $(this).attr('l');
			tmp += '"'+l+'":'+qty+',';
		});
		tmp = '{'+tmp.slice(0,-1)+'}';
		refrechCartQtys(tmp);
	});

});


function cartAction(action,product_code,qty,price,product_title,thiselm) {
	var queryString = "";
	price = parseFloat(price).toFixed(2);
	if(action != "") {
		switch(action) {
			case "ajout":
				queryString = 'action='+action+'&l='+ product_code+'&q='+qty+'&p='+price+'&t='+product_title;
			break;
			case "suppression":
				queryString = 'action='+action+'&l='+ product_code;
			break;
			case "refresh":
				queryString = 'action='+action;
			break;
		}	 
	}
	jQuery.ajax({
	url: WebSite+"includes/cart/index.php",
	data:queryString,
	type: "POST",
	success:function(data){
		if(action != "") {
			switch(action) {
				case "ajout":
					cart_fly(thiselm);
					refreshCart();
				break;
				case "suppression":
					if (data == "") {
						if (thiselm != null) {
							$(thiselm).parent().parent().fadeOut(1000);
							$(thiselm).parent().parent().next().fadeOut(1000);
							setTimeout(function() {
							   	refreshCart();
							}, 1000);
						};
					};
					
				break;
				case "empty":
				
				break;
			}	 
		}
	},
	error:function (){}
	});
}

function cart_fly(element){
    var cart = $('#cart_block');
   // var imgtodrag = $(element).parent().parent().parent().find(".product_image img");
    var imgtodrag = element;
    if (imgtodrag) {
        var imgclone = imgtodrag.clone()
            .offset({
            top: imgtodrag.offset().top,
            left: imgtodrag.offset().left
        })
            .css({
            'opacity': '0.5',
                'position': 'absolute',
                'height': '150px',
                'width': '150px',
                'z-index': '100'
        })
            .appendTo($('body'))
            .animate({
            'top': cart.offset().top + 10,
                'left': cart.offset().left + 10,
                'width': 75,
                'height': 75
        }, 1000, 'easeInOutExpo');
        
        setTimeout(function () {
            cart.effect("shake", {
                times: 2
            }, 200);
        }, 1500);

        imgclone.animate({
            'width': 0,
                'height': 0
        }, function () {
            $(this).detach()
        });
    }
}

function refreshCart(){
	jQuery.ajax({
	url: WebSite+"includes/cart/index.php",
	data:'action=getCart',
	type: "POST",
	success:function(data){
		var json = $.parseJSON(data);
		var nb = json['idProduit'].length;
		var panel_cart = '';
		var total = 0;
		if (nb > 0 && !json['verrou']) {
			panel_cart = '<dl class="products">';
			for (var i = 0; i < nb; i++) {
				var l = json['idProduit'][i];
				var t = json['titleProduit'][i];
				var p = json['prixProduit'][i];
				var q = json['qteProduit'][i];
				total += (p*q);
				panel_cart += '<dt class="item" id="cart_block_product_'+l+'"><span class="quantity-formated"><span class="quantity">'+q+'</span>x</span> <a class="cart_block_product_name" href="#" title="'+t+'">'+t.substr(0, 10)+'...</a> <span class="remove_link"><a class="ajax_cart_block_remove_link" href="javascript:;" l="'+l+'" rel="nofollow" title="supprimer cet produit du panier">&nbsp;</a></span> <span class="price">'+p*q+' '+CURRENCY+'</span></dt>';
				panel_cart += '<dd class="first_item" id="cart_block_combination_of_'+l+'"><a href="#" title="'+t+'">'+t+'</a></dd>';
			};
			panel_cart +='</dl>';

		}else{
			panel_cart = '<p id="cart_block_no_products" style="display: block;">Aucun produit</p>';
		}
		total = parseFloat(total).toFixed(2);
		$('#cart_block_list #product-cart-list').html(panel_cart);
		$('#cart_block_total .price-value').html(total);
		$('#shopping_cart .product_quantity').html(nb);
		$('#shopping_cart .product_total').html(total);
		deleteProduct();
		deleteProductFromCartPage();
	},
	error:function (){}
	});
}

function deleteProductFromCartPage(){
	$('.ajax_delete_product_cart').click(function(){
		var l = $(this).attr('l');
		cartAction("suppression",l,null,null,null,null);
		$(this).closest('tr').fadeOut(1000);
		setTimeout(function() {
		   	refrechPage();
		}, 1000);
		return false;
	});
}

function deleteProduct(){
	$('.ajax_cart_block_remove_link').click(function(){
		var l = $(this).attr('l');
		cartAction("suppression",l,null,null,null,this);

		return false;
	});
}

function updateInputQty(input,action){
	var tmp = input.val();
	switch(action) {
	    case 'down':
	        tmp--;
	        break;
	    case 'up':
	        tmp++;
	        break;
	    default:
	        break;
	}
	input.val(tmp);
	return tmp;
}

function refrechPage(){
	location.reload();
}

function refrechCartQtys(Qtys){
	jQuery.ajax({
	url: WebSite+"includes/cart/index.php",
	data:{action:'refrechCartQtys',Qtys:Qtys},
	type: "POST",
	success:function(data){
		refrechPage();
	},
	error:function (){}
	});
}


/*'action=refrechCartQtys&Qtys='+Qtys*/