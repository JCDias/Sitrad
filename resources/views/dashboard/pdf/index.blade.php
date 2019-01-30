<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Requerimento</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <link rel="stylesheet" href="{{ asset('adminlte/dist/css/AdminLTE.min.css')}}">
  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
<![endif]-->

<style type="text/css">
td{
  height: 30px;
  margin: auto;
  padding: 5px;
}
.center{
  text-align: center;
}
.left{
  text-align: left;
}
.right{
  text-align: right;
}
</style>
</head>
<body class="hold-transition skin-blue layout-top-nav">
  <!-- Site wrapper -->
  <div class="wrapper">

    <header class="main-header">

    </header>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
      <!-- Content Header (Page header) -->
      <section class="content-header">

      </section>

      <!-- Main content -->
      <section class="content">
        <div class="row">
          <div class="col-md-12 center">
            <h4><b>REQUERIMENTO</b></h4>
            <hr>
          </div>
        </div>
        <table class="table table-striped">
          <tr>
            <td width="30%" class="tipo"><b>Acadêmico:</b></td>
            <td>{!! $data['aluno'] !!}</td>
          </tr>
          <tr>
            <td width="30%" class="tipo"><b>Matrícula:</b></td>
            <td>{!! $data['matricula'] !!}</td>
          </tr>
          <tr>
            <td width="30%" class="tipo"><b>Protocolo:</b></td>
            <td>{!! $data['protocolo'] !!}</td>
          </tr>
          <tr>
            <td width="30%" class="tipo"><b>Requerimento:</b></td>
            <td>{!! $data['requerimento'] !!}</td>
          </tr>
          <tr>
            <td width="30%" class="tipo"><b>Acadêmico do curso:</b></td>
            <td>{!! $data['cursoDe'] !!}</td>
          </tr>
          <tr>
            <td width="30%" class="tipo"><b>Encaminhado para:</b></td>
            <td>{!! $data['cursoPara'] !!}</td>
          </tr>
          <tr>
            <td width="30%" class="tipo"><b>Justificativa:</b></td>
            <td>{!! $data['justificativa'] !!}</td>
          </tr>
          <tr>
            <td width="30%" class="tipo"><b>Documento(s) Anexo(s):</b></td>
            <td>{!! $data['anexos'] !!}</td>
          </tr>
        </table>
        <br>
        <br>
        <br>
        <p class="right">JANUÁRIA(MG), _______ / ______ / __________</p>
        <br>
        <br>
        <br>
        <div class="center">
          ____________________________________________________________<br/>
         {!! $data['aluno'] !!}
        </div>
        <br>
        <br>
        <div class="center">
          ____________________________________________________________<br/>
          PROTOCOLO S.R.A
        </div>
        <div>
          <h4 class="tipo">Informações importantes </h4>
          <ul>
            @foreach($data['informacoes'] as $info)
              <li>{!! $info !!}</li>
            @endforeach
          </ul>
        </div>
      </section>
      <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
  </div>
  <!-- ./wrapper -->
</body>
</html>