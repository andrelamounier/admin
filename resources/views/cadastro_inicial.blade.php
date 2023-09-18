<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>TiranossauroRex | ADMIN</title>
  @yield('style')
  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome Icons -->
  <link rel="stylesheet" href="{{env('APP_URL')}}/plugins/fontawesome-free/css/all.min.css">
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
  <!-- overlayScrollbars -->
  <link rel="stylesheet" href="{{env('APP_URL')}}/plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="{{env('APP_URL')}}/dist/css/adminlte.min.css">
  <link rel="stylesheet" href="{{env('APP_URL')}}/dist/css/bootstrap.css">
  <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<body class="hold-transition dark-mode sidebar-mini layout-fixed layout-navbar-fixed layout-footer-not-fixed">
<div class="wrapper" style="padding:55px 0px;">
    <nav class="navbar navbar-dark">
        <ul class="navbar-nav ml-auto">
            <li class="nav-item">
                <form action="{{env('APP_URL')}}/logout" method="POST">
                @csrf
                  <a class="nav-link" href="{{env('APP_URL')}}/logout" role="button" onclick="event.preventDefault();
                    this.closest('form').submit();">
                    sair
                  </a>
                </form>
             </li>
        </ul>
    </nav>
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Configuração inicial</h1>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>
    <section class="content" style="width:100vw;">
        <div class="container-fluid" >
            <div class="row">
                <div class="col-12">
                    <div class="card" style="min-height:70vh;">
                        <div id="saldo_inicial">
                            <div class="card-header">
                                Saldo inicial
                            </div>    
                            <div class="card-body">
                                <form name="saldo_inicial" enctype="multipart/form-data" >
                                    @csrf
                  
                                    <div class="row">
                                        <div class="form-group col-md-12 col-lg-2">
                                          <label for="saldo">Saldo:</label>
                                          <div class="input-group">
                                            <input type="text" id="saldo" name="saldo" class="form-control dinheiro" >
                                          </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer justify-content-between">
                                      <button type="button" onClick="pular(1)" class="btn btn-default">Pular</button>
                                      <button type="submit" class="btn btn-primary">Salvar</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <div id="centro_custo" style="display: none;">
                            <div class="card-header">
                                O <b>centro de custo</b> é uma maneira de separar seu sistema financeiro em vários setores, exemplo:<br>
                                <b>Centro de custo: Concessionária de Energia</b>->Fonecedor: Cemig->Produto->Conta de luz<br>
                                <b>Centro de custo: Marketing</b>->Fonecedor: Grafica do Luiz->Produto->Planfeto<br>
                                *Após o cadastro inicial, pode-se alterar e adicionar mais centro de custo.
                            </div>    
                            <div class="card-body">
                                <form name="centro_custo" enctype="multipart/form-data" >
                                    @csrf
                  
                                    <div class="row">
                                        <div class="form-group col-12">
                                            <label for="saldo">Centro de custo:</label>
                                            <div class="row">
                                                <div class="col-md-12 col-lg-6">
                                                    <div class="input-group">
                                                        <div class="custom-control custom-checkbox">
                                                            <input class="custom-control-input" type="checkbox" id="salario_2" name="salario" value="1" checked>
                                                            <label for="salario_2" class="custom-control-label">Salário</label>
                                                        </div>
                                                    </div>
                                                    <div class="input-group">
                                                        <div class="custom-control custom-checkbox">
                                                            <input class="custom-control-input" type="checkbox" id="energia_2" name="energia" value="1" checked>
                                                            <label for="energia_2" class="custom-control-label">Concessionária de Energia</label>
                                                        </div>
                                                    </div>
                                                    <div class="input-group">
                                                        <div class="custom-control custom-checkbox">
                                                            <input class="custom-control-input" type="checkbox" id="agua_2" name="agua" value="1" checked>
                                                            <label for="agua_2" class="custom-control-label">Concessionária de Água</label>
                                                        </div>
                                                    </div>
                                                    <div class="input-group">
                                                        <div class="custom-control custom-checkbox">
                                                            <input class="custom-control-input" type="checkbox" id="ajuste_2" name="ajuste" value="1" checked>
                                                            <label for="ajuste_2" class="custom-control-label">Ajuste de saldo</label>
                                                        </div>
                                                    </div>
                                                    <div class="input-group">
                                                        <div class="custom-control custom-checkbox">
                                                            <input class="custom-control-input" type="checkbox" id="carro_2" name="carro" value="1" checked>
                                                            <label for="carro_2" class="custom-control-label">Carro</label>
                                                        </div>
                                                    </div>
                                                    <div class="input-group">
                                                        <div class="custom-control custom-checkbox">
                                                            <input class="custom-control-input" type="checkbox" id="moradia_2" name="moradia" value="1" checked>
                                                            <label for="moradia_2" class="custom-control-label">Moradia</label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-12 col-lg-6">
                                                    <div class="input-group">
                                                        <div class="custom-control custom-checkbox">
                                                            <input class="custom-control-input" type="checkbox" id="saude_2" name="saude" value="1" checked>
                                                            <label for="saude_2" class="custom-control-label">Saúde</label>
                                                        </div>
                                                    </div>
                                                    <div class="input-group">
                                                        <div class="custom-control custom-checkbox">
                                                            <input class="custom-control-input" type="checkbox" id="alimentacao_2" name="alimentacao" value="1" checked>
                                                            <label for="alimentacao_2" class="custom-control-label">Alimentação</label>
                                                        </div>
                                                    </div>
                                                    <div class="input-group">
                                                        <div class="custom-control custom-checkbox">
                                                            <input class="custom-control-input" type="checkbox" id="telefone_2" name="telefone" value="1" checked>
                                                            <label for="telefone_2" class="custom-control-label">Telefone/Celular</label>
                                                        </div>
                                                    </div>
                                                    <div class="input-group">
                                                        <div class="custom-control custom-checkbox">
                                                            <input class="custom-control-input" type="checkbox" id="educacao_2" name="educacao" value="1" checked>
                                                            <label for="educacao_2" class="custom-control-label">Educação</label>
                                                        </div>
                                                    </div>
                                                    <div class="input-group">
                                                        <div class="custom-control custom-checkbox">
                                                            <input class="custom-control-input" type="checkbox" id="outros_2" name="outros" value="1" checked>
                                                            <label for="outros_2" class="custom-control-label">Outros</label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            
                                        </div>
                    
                                    </div>
                                
                                    <div class="modal-footer justify-content-between">
                                      <button type="button" onClick="pular(2)" class="btn btn-default">Pular</button>
                                      <button type="submit" class="btn btn-primary">Salvar</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                        
                        <div id="fornecedor_cliente" style="display: none;">
                            <div class="card-header">
                                Fornecedores e Clientes
                                *Após o cadastro inicial, pode-se alterar e adicionar mais fornecedores e clientes.
                            </div>    
                            <div class="card-body">
                                <form name="fornecedor_cliente" enctype="multipart/form-data" >
                                    @csrf
                  
                                    <div class="row">
                                        <div class="form-group col-12">
                                            <label for="saldo">Fornecedores e Clientes:</label>
                                            <div class="row">
                                                <div class="col-md-12 col-lg-6">
                                                    <div class="input-group">
                                                        <div class="custom-control custom-checkbox">
                                                            <input class="custom-control-input" type="checkbox" id="cemig_3" name="cemig" value="1" checked>
                                                            <label for="cemig_3" class="custom-control-label">Cemig</label>
                                                        </div>
                                                    </div>
                                                    <div class="input-group">
                                                        <div class="custom-control custom-checkbox">
                                                            <input class="custom-control-input" type="checkbox" id="copasa_3" name="copasa" value="1" checked>
                                                            <label for="copasa_3" class="custom-control-label">Copasa</label>
                                                        </div>
                                                    </div>
                                                    <div class="input-group">
                                                        <div class="custom-control custom-checkbox">
                                                            <input class="custom-control-input" type="checkbox" id="tim_3" name="tim" value="1" checked>
                                                            <label for="tim_3" class="custom-control-label">Tim</label>
                                                        </div>
                                                    </div>
                                                    <div class="input-group">
                                                        <div class="custom-control custom-checkbox">
                                                            <input class="custom-control-input" type="checkbox" id="claro_3" name="claro" value="1" checked>
                                                            <label for="claro_3" class="custom-control-label">Claro</label>
                                                        </div>
                                                    </div>
                                                    <div class="input-group">
                                                        <div class="custom-control custom-checkbox">
                                                            <input class="custom-control-input" type="checkbox" id="vivo_3" name="vivo" value="1" checked>
                                                            <label for="vivo_3" class="custom-control-label">Vivo</label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-12 col-lg-6">
                                                    <div class="input-group">
                                                        <div class="custom-control custom-checkbox">
                                                            <input class="custom-control-input" type="checkbox" id="oi_3" name="oi" value="1" checked>
                                                            <label for="oi_3" class="custom-control-label">Oi</label>
                                                        </div>
                                                    </div>
                                                    <div class="input-group">
                                                        <div class="custom-control custom-checkbox">
                                                            <input class="custom-control-input" type="checkbox" id="supermercado_3" name="supermercado" value="1" checked>
                                                            <label for="supermercado_3" class="custom-control-label">Supermercado</label>
                                                        </div>
                                                    </div>
                                                    <div class="input-group">
                                                        <div class="custom-control custom-checkbox">
                                                            <input class="custom-control-input" type="checkbox" id="indefinido_3" name="indefinido" value="1" checked>
                                                            <label for="indefinido_3" class="custom-control-label">Indefinido</label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer justify-content-between">
                                      <button type="button" onClick="pular(3)" class="btn btn-default">Pular</button>
                                      <button type="submit" class="btn btn-primary">Salvar</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <div id="produto" style="display: none;">
                            <div class="card-header">
                                Produtos
                                *Após o cadastro inicial, pode-se alterar e adicionar mais fornecedores e clientes.
                            </div>    
                            <div class="card-body">
                                <form name="produto" enctype="multipart/form-data" >
                                    @csrf
                  
                                    <div class="row">
                                        <div class="form-group col-12">
                                            <label for="saldo">Produtos:</label>
                                            <div class="row">
                                                <div class="col-md-12 col-lg-6">
                                                    <div class="input-group">
                                                        <div class="custom-control custom-checkbox">
                                                            <input class="custom-control-input" type="checkbox" id="boleto_4" name="boleto" value="1" checked>
                                                            <label for="boleto_4" class="custom-control-label">Boleto</label>
                                                        </div>
                                                    </div>
                                                    <div class="input-group">
                                                        <div class="custom-control custom-checkbox">
                                                            <input class="custom-control-input" type="checkbox" id="conta_4" name="conta" value="1" checked>
                                                            <label for="conta_4" class="custom-control-label">Conta</label>
                                                        </div>
                                                    </div>
                                                    <div class="input-group">
                                                        <div class="custom-control custom-checkbox">
                                                            <input class="custom-control-input" type="checkbox" id="aluguel_4" name="aluguel" value="1" checked>
                                                            <label for="aluguel_4" class="custom-control-label">Aluguel</label>
                                                        </div>
                                                    </div>
                                                    <div class="input-group">
                                                        <div class="custom-control custom-checkbox">
                                                            <input class="custom-control-input" type="checkbox" id="consulta_4" name="consulta" value="1" checked>
                                                            <label for="consulta_4" class="custom-control-label">Consulta médica</label>
                                                        </div>
                                                    </div>
                                                    <div class="input-group">
                                                        <div class="custom-control custom-checkbox">
                                                            <input class="custom-control-input" type="checkbox" id="salario_4" name="salario" value="1" checked>
                                                            <label for="salario_4" class="custom-control-label">Salário</label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-12 col-lg-6">
                                                    <div class="input-group">
                                                        <div class="custom-control custom-checkbox">
                                                            <input class="custom-control-input" type="checkbox" id="uber_4" name="uber" value="1" checked>
                                                            <label for="uber_4" class="custom-control-label">Uber</label>
                                                        </div>
                                                    </div>
                                                    <div class="input-group">
                                                        <div class="custom-control custom-checkbox">
                                                            <input class="custom-control-input" type="checkbox" id="indefinido_4" name="indefinido" value="1" checked>
                                                            <label for="indefinido_4" class="custom-control-label">Indefinido</label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer justify-content-between">
                                      <button type="button" onClick="pular(4)" class="btn btn-default">Pular</button>
                                      <button type="submit" class="btn btn-primary">Salvar</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->

  <!-- Main Footer -->
  <footer class="main-footer">
    <strong>TiranossauroRex All rights reserved.
  </footer>
</div>
<!-- ./wrapper -->

<!-- REQUIRED SCRIPTS -->

<!-- jQuery -->
<script src="{{env('APP_URL')}}/plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap -->
<script src="{{env('APP_URL')}}/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- overlayScrollbars -->
<script src="{{env('APP_URL')}}/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
<!-- AdminLTE App -->
<script src="{{env('APP_URL')}}/dist/js/adminlte.js"></script>

<!-- PAGE PLUGINS -->
<!-- ChartJS -->
<script src="{{env('APP_URL')}}/plugins/chart.js/Chart.min.js"></script>

<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://igorescobar.github.io/jQuery-Mask-Plugin/js/jquery.mask.min.js"></script>  
<script src="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.12.6/js/standalone/selectize.min.js"></script>
<script>
    $('.dinheiro').mask('#.##0,00', {reverse: true});
    
    
    
$(function(){
  $('Form[name="saldo_inicial"]').submit(function(event){
    event.preventDefault();
    verifica=true;

    var saldo = document.getElementById("saldo");
    if(saldo.value==''){
      saldo.classList.add("is-invalid");
      verifica=false;
    }

    if(verifica){
        
      $.ajax({
        url:"{{env('APP_URL')}}/saldo_inicial",
        type: 'post',
        data: $(this).serialize(),
        dataType: 'json',
        success: function(response){
              if(response.status){
                pular(1);
              }else{
                alert(response.message);
              }
          }
      });
    }
  });
});

$(function(){
  $('Form[name="centro_custo"]').submit(function(event){
    event.preventDefault();
      $.ajax({
        url:"{{env('APP_URL')}}/centro_custo",
        type: 'post',
        data: $(this).serialize(),
        dataType: 'json',
        success: function(response){
              if(response.status){
                pular(2);
              }else{
                alert('Erro.');
              }
          }
      });
    
  });
}); 
    
$(function(){
  $('Form[name="fornecedor_cliente"]').submit(function(event){
    event.preventDefault();
      $.ajax({
        url:"{{env('APP_URL')}}/fornecedor_cliente",
        type: 'post',
        data: $(this).serialize(),
        dataType: 'json',
        success: function(response){
              if(response.status){
               pular(3);
              }else{
                alert('Erro.');
              }
          }
      });
    
  });
});   
$(function(){
  $('Form[name="produto"]').submit(function(event){
    event.preventDefault();
      $.ajax({
        url:"{{env('APP_URL')}}/produtos",
        type: 'post',
        data: $(this).serialize(),
        dataType: 'json',
        success: function(response){
              if(response.status){
               pular(4);
              }else{
                alert('Erro.');
              }
          }
      });
    
  });
});   
    
    
function pular(x){
    switch(x){
      case 1:
            document.getElementById("saldo_inicial").style.display = "none";
            document.getElementById("centro_custo").style.display = "block";
        break;
      case 2:
            document.getElementById("centro_custo").style.display = "none";
            document.getElementById("fornecedor_cliente").style.display = "block";
        break;
      case 3:
            document.getElementById("fornecedor_cliente").style.display = "none";
            document.getElementById("produto").style.display = "block";
        break;
      case 4:
            $.ajax({
            url:"{{env('APP_URL')}}/finalizar_primeiro_acesso",
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            type: 'post',
            dataType: 'json',
            success: function(response){
                  if(response.status){
                   location.reload();
                  }else{
                    alert('Erro.');
                  }
              }
          });
        break;
    }
}
    
    
    
    
    
</script>


@yield('scripts')
</body>
</html>