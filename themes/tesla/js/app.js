$(document).ready(function () {
  	$('.submit-filter').change(function(){
		$( "#filter" ).submit();
	});

    $('[data-toggle="tooltip"]').tooltip();  
    
    $('.plus-detail').click(function(){
        $('html,body').animate({scrollTop: $("#product-tabs").offset().top},1500);
        return false;
    });
    
    $('#user_type').change(function(){
        $('#usertype_info_sup').addClass('hidden');
        var utype = $('#user_type').val();
        // console.log(utype);
         if (utype == 3) {
            
            $('#usertype_info_sup').removeClass('hidden');
         };
    });
    
    

    $("a.product_image_galery").fancybox();


    $('.cu').val(getAttributeCu());
    $('.attributes select').change(function(){
        $('.cu').val(getAttributeCu());
    });

    $('.cart_quantity_input').change(function(){
        var quantity_update = $(this).parent().parent().find('.quantity_update');
        var link = WebSite + "cart?updatepqty=" + quantity_update.attr("pid") + "&iddec="+quantity_update.attr("iddec")+"&qty=" + $(this).val();
       quantity_update.attr("href",link);
    });

    // the selector will match all input controls of type :checkbox
    // and attach a click event handler 
    $("#statuts input:checkbox").on('click', function() {
      // in the handler, 'this' refers to the box clicked on
      var $box = $(this);
      if ($box.is(":checked")) {
        if ($box.val() == 2){
            $('#company_bloc1').css("display","block");
            $('#company_bloc2').css("display","none");
            $('#company_bloc1 .required_statu').prop("required", true);
            $('#company_bloc2 .required_statu').prop("required", false);
        }else if ($box.val() == 3){
            $('#company_bloc1').css("display","block");
            $('#company_bloc2').css("display","block");
            $('#company_bloc1 .required_statu').prop("required", true);
            $('#company_bloc2 .required_statu').prop("required", true);
        }
        // the name of the box is retrieved using the .attr() method
        // as it is assumed and expected to be immutable
        var group = "input:checkbox[name='" + $box.attr("name") + "']";
        // the checked state of the group/box on the other hand will change
        // and the current value is retrieved using .prop() method
        $(group).prop("checked", false);
        $(group).prop("required", false);
        $box.prop("checked", true);
        $box.prop("required", true);
      } else {
        $box.prop("checked", false);
        $('.required_statu').prop("required", false );
        //$box.prop("required", false);
         $('#company_bloc1').css("display","none");
         $('#company_bloc2').css("display","none");
      }
    });
    
    $('.attributes select').change(function(){
        var cu = $('.cu').val();
        var product_id = $('#product_id').val();
        jQuery.ajax({
        url: WebSite+"includes/product/ajax.php",
        data:{action:'getimgbycu',cu:cu,product_id:product_id},
        type: "POST",
        success:function(data){
            data = $.parseJSON(data);
            if (data[0] != undefined) {
                var img_id = $('.carousel a#'+data[0]);
                if (img_id.val() != undefined) {
                    //img_id.click();
                    //console.log(img_id.attr('id'));
                    $('#carousel .carousel-inner .item').removeClass('active');
                    $('#carousel .carousel-inner .item #'+data[0]).parent().addClass('active');
                };
            };
        },
        error:function (){}
        });
    });

    $(".update_p_dec").click(function(){
        if ($(this).attr('autoclick') == 'true') {
            return;
        };
        var img_id = $(this).attr('id');
        var product_id = $('#product_id').val();
        jQuery.ajax({
        url: WebSite+"includes/product/ajax.php",
        data:{action:'getcubyimg',img_id:img_id,product_id:product_id},
        type: "POST",
        success:function(data){
           // console.log(data);
            data = $.parseJSON(data);
            for (var i = 0; i < data.length; i++) {
                var attribute = data[i]['attribute'];
                var attribute_value =  data[i]['attribute_value'];
                var attr_option = $('option#'+attribute_value);
                if (attr_option.val() != undefined) {
                    attr_option.parent().val(attr_option.val());
                };
            };
        },
        error:function (){}
        });
    });

});

$(function(){
$(".dropdown").hover(            
        function() {
            $('>.dropdown-menu', this).stop( true, true ).fadeIn("fast");
            $(this).toggleClass('open');
            $('b', this).toggleClass("caret caret-up");                
        },
        function() {
            $('>.dropdown-menu', this).stop( true, true ).fadeOut("fast");
            $(this).toggleClass('open');
            $('b', this).toggleClass("caret caret-up");                
        });
});

function cloneText(from,to){
    $(to).val($(from).val());
}

function getAttributeCu(){
    cu ="";
    $('.attributes select').each(function(){
         cu += ($(this).attr('attrid') +':'+$(this).val()) +",";
        
    });
    cu = cu.substr(0,cu.length-1);
    return cu;
}