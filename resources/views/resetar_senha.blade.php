<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>TiranossauroRex | Resertar senha</title>
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="{{env('APP_URL')}}/plugins/fontawesome-free/css/all.min.css">
  <!-- icheck bootstrap -->
  <link rel="stylesheet" href="{{env('APP_URL')}}/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="{{env('APP_URL')}}/dist/css/adminlte.min.css">
</head>
<body class="hold-transition login-page">

<div class="login-box">
  <div class="login-logo">
    <img class="animation__wobble" src="{{env('APP_URL')}}/img/favicon.png" alt="Logo" height="60" width="60">
  </div>
  <!-- /.login-logo -->
  <div class="card">
    <div class="card-body login-card-body">
    <x-jet-validation-errors class="mb-4" />

@if (session('status'))
    <div class="mb-4 font-medium text-sm text-green-600">
        {{ session('status') }}
    </div>
@endif
    <form method="POST" action="">
            @csrf
        <div class="input-group mb-3">
          <input id="email" class="form-control" placeholder="Email" type="email" name="email" required autofocus />
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-envelope"></span>
            </div>
          </div>
        </div>
        <div class="row">
          <!-- /.col -->
          <div class="col-8">
            <div class="icheck-primary">

            </div>
          </div>
          <div class="col-4">
            <button type="submit" class="btn btn-primary btn-block">Enviar</button>
          </div>
          <!-- /.col -->
        </div>
      </form>


      <p class="mb-1">
        <a href="/">Logar</a>
      </p>
      <p class="mb-0">
        <a href="{{ route('register') }}" class="text-center">Criar conta</a>
      </p>
    </div>
    <!-- /.login-card-body -->
  </div>
</div>
<!-- /.login-box -->

<!-- jQuery -->
<script src="{{env('APP_URL')}}/plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="{{env('APP_URL')}}/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="{{env('APP_URL')}}/dist/js/adminlte.min.js"></script>

<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    $(document).ready(function(){
        $('form').on('submit', function(e){
            e.preventDefault();

            let formData = {
                email: $('input[name="email"]').val()
            };
            $.ajax({
                type: "POST",
                url: "{{ route('gerar_codigos') }}",
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                data: formData,
                success: function(response) {
                    if (response.success) {
                        Swal.fire(
                            'Enviado!',
                            'Os códigos de recuperação foram gerados e enviados para o seu e-mail.',
                            'success'
                        );
                    } else {
                        Swal.fire(
                            'Erro!',
                            'Não foi possível enviar o e-mail.',
                            'error'
                        );
                    }
                },
                error: function() {
                    Swal.fire(
                        'Erro!',
                        'Ocorreu um erro no envio.',
                        'error'
                    );
                }
            });
        });
    });
</script>

</body>
</html>
