<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>TiranossauroRex | Registro</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="{{env('APP_URL')}}/plugins/fontawesome-free/css/all.min.css">
  <!-- icheck bootstrap -->
  <link rel="stylesheet" href="{{env('APP_URL')}}/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="{{env('APP_URL')}}/dist/css/adminlte.min.css">
</head>
<body class="hold-transition register-page">
<div class="register-box">
  <div class="register-logo">
    <img class="animation__wobble" src="{{env('APP_URL')}}/img/favicon.png" alt="Logo" height="60" width="60">
  </div>

  <div class="card">
    <div class="card-body register-card-body">
        
      <p class="login-box-msg">Registro</p>
      <x-jet-validation-errors class="mb-4" />
      <form method="POST" action="{{ route('register') }}">
            @csrf
        <div class="input-group mb-3">
          <x-jet-input id="name" class="form-control" placeholder="Nome" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-user"></span>
            </div>
          </div>
        </div>
        <div class="input-group mb-3">
          <x-jet-input id="email" class="form-control" placeholder="Email" type="email" name="email" :value="old('email')" required />
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-envelope"></span>
            </div>
          </div>
        </div>
        <div class="input-group mb-3">
          <x-jet-input id="password" class="form-control" placeholder="Senha" type="password" name="password" required autocomplete="new-password" />
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
          </div>
        </div>
        <div class="input-group mb-3">
          <x-jet-input id="password_confirmation" placeholder="Confirmar a senha" class="form-control" type="password" name="password_confirmation" required autocomplete="new-password" />
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-8">
            <div class="icheck-primary">
              <x-jet-checkbox name="terms" id="terms" required />
              <label for="terms">
               Eu aceito os <a href="{{env('APP_URL')}}/termos" target="_blank">termos</a> de uso.
              </label>
            </div>
          </div>
          <!-- /.col -->
          <div class="col-4">
            <button type="submit" class="btn btn-primary btn-block">Registar</button>
          </div>
          <!-- /.col -->
        </div>
      </form>

      

      <a href="{{ route('login') }}" class="text-center">Já possui uma conta? faça login</a>
    </div>
    <!-- /.form-box -->
  </div><!-- /.card -->
</div>
<!-- /.register-box -->

<!-- jQuery -->
<script src="{{env('APP_URL')}}/plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="{{env('APP_URL')}}/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="{{env('APP_URL')}}/dist/js/adminlte.min.js"></script>
</body>
</html>
