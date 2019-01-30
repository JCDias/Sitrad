<section class="content-header">

  <div class="callout callout-success">
    <h4>Bem-vindo ao SiTraD!</h4>
  </div>

</section>

<section class="content">
  <div class="container">
    <div class="row">
      <div class="col-md-4">
       <div class="box box-primary">
         <div class="box-header">
          
        </div>
        <!-- /.box-header -->
        <div class="box-body text-center">
          <a href="#" class="btn btn-lg btn-primary"><i class="fa fa-edit"></i> Solicitar Requerimento</a>
        </div>
        <div class="box-footer">
          
        </div>
      </div>
      <!-- /.box -->
    </div>
    {{-- Inicio do outro box --}}
    <div class="col-md-7">
     <!-- PRODUCT LIST -->
     <div class="box box-warning">
      <div class="box-header with-border">
        <h3 class="box-title">Minhas Solicitações</h3>
      </div>
      <!-- /.box-header -->
      <div class="box-body">
        <ul class="products-list product-list-in-box">
          <li class="item">
            <div class="product-img">
              <img src="{{ asset('adminlte/dist/img/default-50x50.gif')}}" alt="Product Image">
            </div>
            <div class="product-info">
              <a href="javascript:void(0)" class="product-title">Samsung TV
                <span class="label label-warning pull-right">$1800</span></a>
                <span class="product-description">
                  Samsung 32" 1080p 60Hz LED Smart HDTV.
                </span>
              </div>
            </li>
          </ul>
        </div>
        <!-- /.box-body -->
        <div class="box-footer text-center">
          <a href="javascript:void(0)" class="uppercase">View All Products</a>
        </div>
        <!-- /.box-footer -->
      </div>
      <!-- /.box -->
    </div>
    {{-- Inicio do outro box --}}
    {{-- Fim controle de acesso --}}
    @else
    Não era pra chegar aki
    @endcan

  </div>
</div>
</section>



<!-- Js do footer -->

 <!-- Sparkline -->
  <script src="{{ asset('adminlte/bower_components/jquery-sparkline/dist/jquery.sparkline.min.js')}}"></script>
  <!-- jvectormap -->
  <script src="{{ asset('adminlte/plugins/jvectormap/jquery-jvectormap-1.2.2.min.js')}}"></script>
  <script src="{{ asset('adminlte/plugins/jvectormap/jquery-jvectormap-world-mill-en.js')}}"></script>
  <!-- jQuery Knob Chart -->
  <script src="{{ asset('adminlte/bower_components/jquery-knob/dist/jquery.knob.min.js')}}"></script>
  <!-- daterangepicker -->
  <script src="{{ asset('adminlte/bower_components/moment/min/moment.min.js')}}"></script>
  <script src="{{ asset('adminlte/bower_components/bootstrap-daterangepicker/daterangepicker.js')}}"></script>
  <!-- datepicker -->
  <script src="{{ asset('adminlte/bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js')}}"></script>
  <!-- Bootstrap WYSIHTML5 -->
  <script src="{{ asset('adminlte/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js')}}"></script>
  <!-- Slimscroll -->
  <script src="{{ asset('adminlte/bower_components/jquery-slimscroll/jquery.slimscroll.min.js')}}"></script>
  <!-- FastClick -->
  <script src="{{ asset('adminlte/bower_components/fastclick/lib/fastclick.js')}}"></script>
   <!-- Morris.js charts -->
  <script src="{{ asset('adminlte/bower_components/raphael/raphael.min.js')}}"></script>
  <script src="{{ asset('adminlte/bower_components/morris.js/morris.min.js')}}"></script>
  <!-- AdminLTE dashboard demo (This is only for demo purposes) -->
  <script src="{{ asset('adminlte/dist/js/pages/dashboard.js')}}"></script>
  <!-- AdminLTE for demo purposes -->
  <script src="{{ asset('adminlte/dist/js/demo.js')}}"></script>


  <!-- CSS do Header -->
  <!-- Morris chart -->
   <link rel="stylesheet" href="{{ asset('adminlte/bower_components/morris.js/morris.css')}}">
   <!-- jvectormap -->
   <link rel="stylesheet" href="{{ asset('adminlte/bower_components/jvectormap/jquery-jvectormap.css')}}">
   <!-- Date Picker -->
   <link rel="stylesheet" href="{{ asset('adminlte/bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css')}}">
   <!-- Daterange picker -->
   <link rel="stylesheet" href="{{ asset('adminlte/bower_components/bootstrap-daterangepicker/daterangepicker.css')}}">
   <!-- bootstrap wysihtml5 - text editor -->
   <link rel="stylesheet" href="{{ asset('adminlte/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css')}}">