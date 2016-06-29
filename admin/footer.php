  </section><!--/ .content  -->
  </aside><!-- /.main-content -->
  <footer class="footer hidden">
    <div class="slide">
      <p class="text-muted">Copyright &copy; Soft Hight Tech, 2016</p>
    </div>
  </footer>

  <!-- JAVASCRIPT  -->
  <script src="assets/js/bootstrap.min.js" type="text/javascript"></script>
  <!-- DataTable -->
  <script src="assets/js/datatables/jquery.dataTables.min.js" type="text/javascript"></script>
  <script src="assets/js/datatables/dataTables.bootstrap.min.js" type="text/javascript"></script>
  <!-- Morris Chart -->
  <!--script src="assets/js/morris/chart.js" type="text/javascript"></script-->
  <script src="assets/js/datepicker/raphael-min.js"></script>
  <script src="assets/js/datepicker/morris.min.js"></script>

  <!-- tagsinput -->
  <script src="assets/js/tagsinput/bootstrap-tagsinput.js" type="text/javascript"></script>
  <!-- summernote -->
  <script src="assets/js/summernote/summernote.min.js" type="text/javascript"></script>
  <!-- jquery-filer -->
  <script src="assets/js/jquery-filer/jquery.filer.min.js" type="text/javascript"></script>
  <!-- jquery-sortable -->
  <script src="assets/js/sortable/jquery.sortable.min.js" type="text/javascript"></script>
  <!-- datepicker -->
  <script src="assets/js/datepicker/moment.js" type="text/javascript"></script>
  <script src="assets/js/datepicker/bootstrap-datepicker.min.js" type="text/javascript"></script>
  <script src="assets/js/datepicker/bootstrap-datetimepicker.min.js" type="text/javascript"></script>
  <!-- Bootstrap chosen -->
  <script src="assets/js/chosen/chosen.jquery.js" type="text/javascript"></script>
  <!-- Bootstrap growl -->
  <script src="assets/js/growl/jquery.bootstrap-growl.min.js" type="text/javascript"></script>
  <!-- bootstrap-switch -->
  <script src="assets/js/bootstrap-switch/bootstrap-switch.min.js" type="text/javascript"></script>
  <!-- multiselect -->
  <script src="assets/js/multiselect/multiselect.min.js" type="text/javascript"></script>
  <!-- jquery-sortable 
  <script src="assets/js/dual-listbox/dual-list-box.min.js" type="text/javascript"></script>-->
  <!-- Application -->
  <script src="assets/js/jquery.ajaxupload.js"></script>
  <script src="assets/js/scripts.js"></script>
  <script src="assets/js/app.js" type="text/javascript"></script> 
  <script>
  $(document).ready(function(){
    var url = window.location.href;
    var page = url.split("?").pop();
    if(url.indexOf("?") > -1) {
      var $current = $('#os_admin_menu a[href$="'+page+'"]');
      $current.addClass('active');
      if ( url.indexOf("&slug=") >= 0 ){
        var module_name = url.split("&slug=").pop().split("&").shift();
        $('#os_admin_menu a[href*="slug='+module_name+'"]')
          .closest('#os_admin_menu>.dropdown-submenu')
          .addClass('active');
      }else{
        var current_m = url.split("?").pop().split("&").shift();
        $current.closest('#os_admin_menu>.dropdown-submenu').addClass('active');
      }
    }else{
      $('#os_admin_menu a[href*="./index.php"]').addClass('active');
    }

    //datatable lang
    $('#datatable').DataTable({
      "order": [],
      "iDisplayLength": 15,
      "aLengthMenu": [[15, 50, 100, 200, 300, -1], [15, 50, 100, 200, 300, "All"]],
      "language": {
        "url": "//cdn.datatables.net/plug-ins/1.10.11/i18n/<?=(!empty($_SESSION['dt_lang']) ? $_SESSION['dt_lang'] : 'French');?>.json"
      }
    });


    
  });
  </script>

  <?=os_footer();?>
</body>
</html>