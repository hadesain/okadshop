(function($){

  //jQuery Filer
  $('#filer_input').filer({
    showThumbs: true,
    addMore: true,
    maxSize: 1,
    extensions: ['jpg', 'jpeg', 'png', 'gif']
  });
  $('.attachement').filer({
    showThumbs: false,
    addMore: false,
    maxSize: 8,
    extensions: ['jpg', 'jpeg', 'png', 'gif', 'pdf', 'doc', 'docx', 'xlsx', 'ppt', 'pptx', 'odt']
  });

  //Bootstrap Switch
  $("input.active").bootstrapSwitch({onColor:'success','offColor':'danger'});

  //sortable
  $(".sortable").sortable();


  //tags
  $("input#tags").tagsinput();
  $(".tags").tagsinput();

  //summernote
  $('.summernote').summernote({
    lang: 'fr-FR',
    height: 100, 
    minHeight: null,
    maxHeight: null,
    color: {
      recent: 'Recent Color',
      more: 'More Color',
      background: 'BackColor',
      foreground: 'FontColor',
      transparent: 'Transparent',
      setTransparent: 'Set transparent',
      reset: 'Reset',
      resetToDefault: 'Reset to default'
    },
    /*toolbar: [
      ['style', ['style']],
      ['font', ['bold', 'italic', 'underline', 'clear']],
      ['color', ['color']],
      ['para', ['ul', 'ol', 'paragraph']],
      ['height', ['height']],
      ['table', ['table']],
      ['insert', ['link', 'hr']],
    ],*/

    

  });

  //Datatable
  /*$('#product_table').DataTable();
  $('#datatable').DataTable({
    "order": [],
    "language": {
      "url": "//cdn.datatables.net/plug-ins/1.10.11/i18n/<?=$_SESSION['dt_lang'];?>.json"
    }
  });
  $('.datatable').DataTable({
    "order": [],
    "language": {
      "url": "//cdn.datatables.net/plug-ins/1.10.11/i18n/Arabic.json"
    }
  });*/





  //Admin menu Toogle
  $('header .sidebar-toggle').click(function() {
    if ($('.collapse-left').val() == undefined) {
      $('.main-content').css('margin-left', 'inherit');
    } else {
      $('.main-content').css('margin-left', '220px');
    }
  });

  //upload image script
  $(document).on('click', '#close-preview', function(){ 
    $('.image-preview').popover('hide');
    // Hover befor close the preview
    $('.image-preview').hover(
      function () {
        $('.image-preview').popover('show');
      }, 
       function () {
        $('.image-preview').popover('hide');
      }
    );    
  });


  // Create the close button
  var closebtn = $('<button/>', {
      type:"button",
      text: 'x',
      id: 'close-preview',
      style: 'font-size: initial;',
  });
  closebtn.attr("class","close pull-right");
  // Set the popover default content
  $('.image-preview').popover({
      trigger:'manual',
      html:true,
      title: "<strong>Preview</strong>"+$(closebtn)[0].outerHTML,
      content: "There's no image",
      placement:'bottom'
  });
  // Clear event
  $('.image-preview-clear').click(function(){
      $('.image-preview').attr("data-content","").popover('hide');
      $('.image-preview-filename').val("");
      $('.image-preview-clear').hide();
      $('.image-preview-input input:file').val("");
      $(".image-preview-input-title").text("Browse"); 
  }); 
  // Create the preview image
  $(".image-preview-input input:file").change(function (){     
      var img = $('<img/>', {
          id: 'dynamic',
          width:250,
          height:200
      });      
      var file = this.files[0];
      var reader = new FileReader();
      // Set preview image into the popover data-content
      reader.onload = function (e) {
          $(".image-preview-input-title").text("Change");
          $(".image-preview-clear").show();
          $(".image-preview-filename").val(file.name);            
          img.attr('src', e.target.result);
          $(".image-preview").attr("data-content",$(img)[0].outerHTML).popover("show");
      }        
      reader.readAsDataURL(file);
  });


  //Footer
  /*$(".footer").hover(function () {
    $(".footer").slideToggle("fast");
  });*/
$(".footer").hover(function () {
    $(".slide").slideToggle("fast");
  });



  // Javascript to enable link to tab
  var hash = document.location.hash;
  var prefix = "tab_";
  if (hash) {
    $('.nav-pills a[href='+hash.replace(prefix,"")+']').tab('show');
    $('.nav-tabs a[href='+hash.replace(prefix,"")+']').tab('show');
  } 
  // Change hash for page-reload
  $('.nav-tabs a, .nav-pills a').on('shown.bs.tab', function (e) {
    window.location.hash = e.target.hash.replace("#", "#");// + prefix
  });



  $('.datepicker').datepicker({
    format: 'yyyy-mm-dd',//2016-04-21
    startDate: '2010-01-01',
    endDate: '2020-01-01'
  });

  //bootstrap chosen
  //$('.chosen').chosen();
  $(".chosen").chosen({no_results_text: "Oops, rien trouvé!"});
  //$('.chosen-select-deselect').chosen({ allow_single_deselect: true });
  /*$('.chosen').focus(function(e){
    e.preventDefault();
  });*/


  // $('.datatables').on('click', '.DELETE', function( event ) {
  //   event.preventDefault();
  //   var choice = confirm("Cette action supprime définitivement cette élément de la base de donné.\nÊtes-vous vraiment sûr ?");
  //   if (choice == false) return;
  // });


  //token
  $.urlParam = function(name){
    var results = new RegExp('[\?&]' + name + '=([^&#]*)').exec(window.location.href);
    if (results==null){
      return null;
    }
    else{
      return results[1] || 0;
    }
  }
  var token = $.urlParam('token');
  if( token != null ){
    $("a:not([href*='javascript:;'],[href*='#'])").each(function(){

      var _href = $(this).attr("href"); 
      if( _href != undefined )
      {
        if (_href.indexOf('?') != -1) {
          $(this).attr("href", _href + '&token=' + token);
        }
        else {
          $(this).attr("href", _href + '?token=' + token);
        }
        console.log(_href)
      }
    });
  }


  /*$("a:not([href*='javascript:;'],[href*='#'])").each(function(){
    console.log($(this).attr('href'))
  });


  $('a[href="?module=products&action=edit&id=310"').attr("href", '?module=products&action=edit&id=310?token=');
*/


  //sidebar-toggle
  $('.sidebar-toggle').on('click', function(){
    var state = $('.left-side').hasClass( "collapse-left" );
    if( state ){
     sessionStorage.setItem('os_collapse', '1');
    }else{
     sessionStorage.setItem('os_collapse', '0');
    }
  });
  //get session
  var os_collapse = sessionStorage.getItem('os_collapse');
  if( os_collapse === "0" ){
    $('.left-side').addClass('collapse-left');
    $('.main-content').css('margin-left', '0px');
    $('#admin-home').css('overflow', 'inherit');
  }



})(jQuery);



//disable the Enter key on HTML form
function stopRKey(evt) { 
  var evt = (evt) ? evt : ((event) ? event : null); 
  var node = (evt.target) ? evt.target : ((evt.srcElement) ? evt.srcElement : null); 
  if ((evt.keyCode == 13) && (node.type=="text"))  {return false;} 
} 
document.onkeypress = stopRKey; 

//check_all
function check_all(name, state){
  $('input[name="'+name+'"]').prop("checked" , state);
}



//submit form by ajax
function submit_ajax_form(form_id, handle_data){
  //check form id
  if($("form#" + form_id).length == 0) {
    alert("Form ID doesn't exist.");
  }

  // get the data in the form
  var $form = $('#'+form_id);
  var form_data = new FormData($form[0]);

  // Let's select and cache all the fields
  var $inputs = $form.find("input, select, button, textarea").not(":disabled");

  // Let's disable the inputs for the duration of the Ajax request.
  // Disabled form elements will not be serialized.
  $inputs.prop("disabled", true);

  // Fire off the request
  $.ajax({
    url: $form.attr('action'),
    type: $form.attr('method'),
    data: form_data,
    cache: false,
    contentType: false,
    processData: false
    //dataType: 'json',
  })
  // Callback handler that will be called on success
  .done(function(response, textStatus, jqXHR) {
    try {
      //check if response is json
      handle_data( JSON.parse(response) );
    }catch (e) {
      $.bootstrapGrowl("Une erreur est survenue !" , {type: 'warning',delay: 4000,align: 'center'});
      //console.log("Error occurred, please try again !");
      //$('#message').html( jqXHR.responseText );
    }
  })
  // Callback handler that will be called on failure
  .fail(function (jqXHR, textStatus, errorThrown){
    // Log the error to the console
    get_error_message(textStatus, errorThrown);
    //console.error("The following error occurred: "+ textStatus, errorThrown);
  })
  // Callback handler that will be called regardless if the request failed or succeeded
  .always(function () {
    // Reenable the inputs
    $inputs.prop("disabled", false);
  });

  return false;
}

function get_error_message(textStatus, errorThrown){
  $.bootstrapGrowl("Une erreur est survenue !" , {type: 'warning',delay: 4000,align: 'center'});
  var err_msg = "The following error occured: " + textStatus, errorThrown;
  console.log(err_msg);
}

function error_message_notification(){
  $.bootstrapGrowl(
    "Une erreur est survenue ! <br> Veuillez actualiser la page et réessayer.", 
    {type: 'warning',delay: 6000,align: 'center'}
  );
}


function success_message_notification(message){
  $.bootstrapGrowl(
    message , 
    {type: 'success',delay: 4000,align: 'center'}
  );
}

function os_message_notif(message, type="info", delay=4000, width=250, align="center"){
  $.bootstrapGrowl(message, {
    ele: 'body', // which element to append to
    type: type, // (null, 'info', 'danger', 'success')
    offset: {from: 'top', amount: 20}, // 'top', or 'bottom'
    align: align, // ('left', 'right', or 'center')
    width: width, // (integer, or 'auto')
    delay: delay, // Time while the message will be displayed. It's not equivalent to the *demo* timeOut!
    allow_dismiss: true, // If true then will display a cross to close the popup.
    stackup_spacing: 10 // spacing between consecutively stacked growls.
  });
}

//Generate a string
function gencode(nbr, target)
{
  var text = "";
  var possible = "ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
  for( var i=0; i < nbr; i++ ){
    text += possible.charAt(Math.floor(Math.random() * possible.length));
  }
  $( target ).val(text);
}
