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
  
  <!-- Outlined -->
<link href="https://fonts.googleapis.com/css2?family=Material+Icons+Outlined" rel="stylesheet">
 
 <!-- Filled -->
 <link href="https://fonts.googleapis.com/css2?family=Material+Icons" rel="stylesheet">
  
 <!-- Rounded -->
 <link href="https://fonts.googleapis.com/css2?family=Material+Icons+Round" rel="stylesheet">
  
 <!-- Sharp -->
 <link href="https://fonts.googleapis.com/css2?family=Material+Icons+Sharp" rel="stylesheet">
  
 <!-- Two tone -->
 <link href="https://fonts.googleapis.com/css2?family=Material+Icons+Two+Tone" rel="stylesheet">

 
  <!-- overlayScrollbars -->
  <link rel="stylesheet" href="{{env('APP_URL')}}/plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="{{env('APP_URL')}}/dist/css/adminlte.min.css">
  <link rel="stylesheet" href="{{env('APP_URL')}}/dist/css/bootstrap.css">
   <!-- Select2 -->
   <link rel="stylesheet" href="{{env('APP_URL')}}/plugins/select2/css/select2.min.css">
  <link rel="stylesheet" href="{{env('APP_URL')}}/plugins/select2-bootstrap4-theme/select2-bootstrap4.css">
  <meta name="author" content="okonan">

  <link rel="icon" type="image/png" href="{{env('APP_URL')}}/favicon.png">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <style>
  .alinhamento-icone{
    margin:5px 15px;
  }
  </style>
</head>
<body class="hold-transition dark-mode sidebar-mini layout-fixed layout-navbar-fixed layout-footer-not-fixed">
<div class="wrapper">

  <!-- Preloader -->
  <div class="preloader flex-column justify-content-center align-items-center">
    <img class="animation__wobble" src="{{env('APP_URL')}}/img/favicon.png" alt="Logo" height="60" width="60">
  </div>

  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-dark">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>
    </ul>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
      <!-- Navbar Search 
      <li class="nav-item">
        <a class="nav-link" data-widget="navbar-search" href="#" role="button">
          <i class="fas fa-search"></i>
        </a>
        <div class="navbar-search-block">
          <form class="form-inline">
            <div class="input-group input-group-sm">
              <input class="form-control form-control-navbar" type="search" placeholder="Search" aria-label="Search">
              <div class="input-group-append">
                <button class="btn btn-navbar" type="submit">
                  <i class="fas fa-search"></i>
                </button>
                <button class="btn btn-navbar" type="button" data-widget="navbar-search">
                  <i class="fas fa-times"></i>
                </button>
              </div>
            </div>
          </form>
        </div>
      </li>-->
      <li class="nav-item dropdown">
        <a class="nav-link" data-toggle="dropdown" href="#" onclick="notificacoes()" >
          <i class='far fa-bell alinhamento-icone'></i>
          <div id='icon-notifi'>
          
          </div>
        </a>
        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
          <span class="dropdown-item dropdown-header" id="texto-notifi">Notificações</span>
          
          @php
            $totalAlerta=0;
            $lida=0;
          @endphp
          @foreach($alertas as $item)
              @switch($item->tipo)
                @case(1)
                  <div class="dropdown-divider"></div>
                  <a href="#" class="dropdown-item">
                    <i class="fas fa-chart-pie mr-2"></i>
                      {{$item->qut}}
                      @if($item->qut>1)
                        Contas
                      @else
                        Conta
                      @endif
                        vencendo hoje.
                    <span class="float-right text-muted text-sm"></span>
                  </a>
                @break
                @case(2)
                  <div class="dropdown-divider"></div>
                  <a href="#" class="dropdown-item">
                    <i class="fa-solid fa-calendar-days mr-2"></i>
                      {{$item->qut}}
                      @if($item->qut>1)
                        Eventos
                      @else
                        Evento
                      @endif
                        na sua agenda hoje.
                    <span class="float-right text-muted text-sm"></span>
                  </a>
                @break
                @case(3)
                  <div class="dropdown-divider"></div>
                  <a href="#" class="dropdown-item">
                    <i class="fa-solid fa-list-check mr-2"></i>
                      {{$item->qut}}
                      @if($item->qut>1)
                        Tarefas
                      @else
                        Tarefa
                      @endif
                        marcada para hoje.
                    <span class="float-right text-muted text-sm"></span>
                  </a>
                @break
                @default
              @endswitch
              @php
                $totalAlerta++;
                if($item->lida==0){
                  $lida++;
                }
              @endphp
          @endforeach
          @php
            if($totalAlerta>0){
              if($totalAlerta==1){
                $texto=" Notificação";
              }else{
                $texto=" Notificações";
              }
               echo "<script>document.getElementById('texto-notifi').innerHTML = '".$totalAlerta.$texto."';</script>";
               if($lida>0){
                echo "<script>document.getElementById('icon-notifi').innerHTML = '<span class=\"badge badge-warning navbar-badge \">".$lida."</span>';</script>";
               }
               
            }
          @endphp
          <div class="dropdown-divider"></div>
          
        </div>
      </li>
      <li class="nav-item">
       <a class="nav-link" href="{{env('APP_URL')}}/conta" role="button" >
          Conta
        </a>
      </li>
      <li class="nav-item">
        <form action="{{env('APP_URL')}}/logout" method="POST" id="logout-form">
        @csrf
          <a class="nav-link" href="{{env('APP_URL')}}/logout" role="button" onclick="event.preventDefault();
            this.closest('form').submit();">
            Sair
          </a>
        </form>
      </li>
    </ul>
  </nav>
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="{{env('APP_URL')}}" class="brand-link">
      <img src="{{env('APP_URL')}}/img/favicon.png" alt="Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
      <span class="brand-text font-weight-light">TiranossauroRex</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="info">
          <a href="#" class="d-block">{{auth()->user()->name}}</a>
        </div>
      </div>

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
        
          <li class="nav-item">
            <a href="{{env('APP_URL')}}" class="nav-link">
              <i class="nav-icon fas fa-th"></i>
              <p>
                Início
              </p>
            </a>
          </li>
          <!--
          <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-copy"></i>
              <p>
                Site
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="menu.html" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Menu</p>
                </a>
              </li>
            </ul>
          </li>
-->
          <li class="nav-item">
            <a href="#" class="nav-link" >
              <i class="nav-icon fas fa-chart-pie"></i>
              <p>
                Financeiro
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{env('APP_URL')}}/financeiro/contas_receber" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Contas a receber</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{env('APP_URL')}}/financeiro/contas_pagar" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Contas a pagar</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="#" class="nav-link">
                  <i class="nav-icon fas fa-circle"></i>
                  <p>
                    Cadastros
                    <i class="right fas fa-angle-left"></i>
                  </p>
                </a>
                <ul class="nav nav-treeview">
                  <li class="nav-item">
                    <a href="{{env('APP_URL')}}/financeiro/cadastro_centro_custo" class="nav-link">
                      <i class="far fa-circle nav-icon"></i>
                      <p>Centro de Custo</p>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="{{env('APP_URL')}}/fonecedor_cliente" class="nav-link">
                      <i class="far fa-circle nav-icon"></i>
                      <p>Fornecedores-Clientes</p>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="{{env('APP_URL')}}/financeiro/produto" class="nav-link">
                      <i class="far fa-circle nav-icon"></i>
                      <p>Produtos</p>
                    </a>
                  </li>
                </ul>
              </li>
              <li class="nav-item">
                <a href="#" class="nav-link">
                  <i class="nav-icon fas fa-circle"></i>
                  <p>
                    Cansultas
                    <i class="right fas fa-angle-left"></i>
                  </p>
                </a>
                <ul class="nav nav-treeview">
                  <li class="nav-item">
                    <a href="{{env('APP_URL')}}/financeiro/consulta_fluxo_caixa" class="nav-link">
                      <i class="far fa-circle nav-icon"></i>
                      <p>Fluxo de caixa</p>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="{{env('APP_URL')}}/financeiro/consulta_contas_receber" class="nav-link">
                      <i class="far fa-circle nav-icon"></i>
                      <p>Contas a receber</p>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="{{env('APP_URL')}}/financeiro/consulta_contas_pagar" class="nav-link">
                      <i class="far fa-circle nav-icon"></i>
                      <p>Contas a pagar</p>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="{{env('APP_URL')}}/financeiro/consulta_centro_custo" class="nav-link">
                      <i class="far fa-circle nav-icon"></i>
                      <p>Centro de custo</p>
                    </a>
                  </li>
                </ul>
              </li>
            </ul>
          </li>
          <li class="nav-item">
            <a href="#" class="nav-link" >
            <span class="nav-icon  material-icons-outlined">group</span>
              <p>
              Clientes e Fornecedores
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{env('APP_URL')}}/fonecedor_cliente" class="nav-link">
                      <i class="far fa-circle nav-icon"></i>
                      <p>Geral</p>
                </a>
              </li>
            </ul>
          </li>
          <li class="nav-item">
            <a href="#" class="nav-link" >
              <i class="nav-icon fa-solid fa-file"></i>
              <p>
                Documentos
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{env('APP_URL')}}/documentos/buscar_documentos" class="nav-link">
                      <i class="far fa-circle nav-icon"></i>
                      <p>Buscar</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{env('APP_URL')}}/documentos/upload" class="nav-link">
                      <i class="far fa-circle nav-icon"></i>
                      <p>Upload</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{env('APP_URL')}}/documentos/escrever" class="nav-link">
                      <i class="far fa-circle nav-icon"></i>
                      <p>Escrever</p>
                </a>
              </li>
            </ul>
          </li>
          <li class="nav-item">
            <a href="#" class="nav-link" >
            <span class="nav-icon  material-icons-outlined">view_kanban</span>
              <p>
                Projetos
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{env('APP_URL')}}/projetos/tarefas" class="nav-link">
                      <i class="far fa-circle nav-icon"></i>
                      <p>Tarefas</p>
                </a>
              </li>
            </ul>
          </li>
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>

 @yield('content')


  
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
<!-- Select2 -->
<script src="{{env('APP_URL')}}/plugins/select2/js/select2.full.min.js"></script>
<!-- overlayScrollbars -->
<script src="{{env('APP_URL')}}/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
<!-- AdminLTE App -->
<script src="{{env('APP_URL')}}/dist/js/adminlte.js"></script>

<!-- PAGE PLUGINS -->
<!-- ChartJS -->
<script src="{{env('APP_URL')}}/plugins/chart.js/Chart.min.js"></script>

<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
  $(function () {
    //Initialize Select2 Elements
    $('.select2').select2()

    //Initialize Select2 Elements
    $('.select2bs4').select2({
      theme: 'bootstrap4'
    })
  });
  function buscacep(cep){
  cep = cep.replace(/[^0-9]/g, '');
  $.ajax({
      url:"{{env('APP_URL')}}/buscacep",
      headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
      type: 'post',
      data: { 'cep'     : cep
      },
      dataType: 'json',
      success: function(response){
          endereco=JSON.parse(response.status);
          if(endereco.erro){

          }else{
            //if(document.getElementById("rua_for_cli").value==''){
              document.getElementById("rua_for_cli").value=endereco.logradouro;
            //}
            //if(document.getElementById("bairro_for_cli").value==''){
              document.getElementById("bairro_for_cli").value=endereco.bairro;
            //}
            //if(document.getElementById("cidade_for_cli").value==''){
              document.getElementById("cidade_for_cli").value=endereco.localidade;
            //}
            //if(document.getElementById("estado_for_cli").value==''){
              document.getElementById("estado_for_cli").value=endereco.uf;
            //}
          }
        }
    }); 
}
  </script>

@yield('scripts')
      <div class="modal fade" id="novo_cartao_modal">
        <div class="modal-dialog modal-lg">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title">Adicionar cartão</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
            <form name="form_add_cartao" enctype="multipart/form-data" >
              @csrf
              <input type="hidden" id="id_cartao" name="id_cartao" class="form-control" >
              <div class="row">
                <div class="form-group col-md-4 col-12">
                  <label for="nome_cartao">Nome:</label>
                  <div class="input-group">
                    <input type="text" id="nome_cartao" name="nome_cartao" class="form-control" >
                  </div>
                </div>
                <div class="form-group col-md-3 col-12">
                  <label for="data_fechamento_cartao">Dia do fechamento:</label>
                  <div class="input-group">
                    <input type="number" id="data_fechamento_cartao" name="data_fechamento_cartao" min="1" max="31" class="form-control" required>
                  </div>
                </div>
                <div class="form-group col-md-3 col-12">
                  <label for="data_vencimento_cartao">Dia do vencimento:</label>
                  <div class="input-group">
                    <input type="number" id="data_vencimento_cartao" name="data_vencimento_cartao" min="1" max="31" class="form-control" required>
                  </div>
                </div>
                <div class="form-group col-md-2 col-12">
                  <label for="ativo_cartao">Ativo:</label>
                  <div class="input-group d-flex justify-content-center">
                    <input class="form-check-input" type="checkbox" id="ativo_cartao" name="ativo_cartao" checked>
                  </div>
                </div>
              </div>
            </div>
            <div class="modal-footer justify-content-between">
              <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
              <button type="submit" class="btn btn-primary">Salvar</button>
            </div>
            </form>
          </div>
          <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
      </div>
      <!-- /.modal centro_custo-->

      <div class="modal fade" id="novo_centro_custo_modal">
        <div class="modal-dialog modal-lg">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title">Adicionar centro de custo</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
            <form name="form_add_centro_custo" enctype="multipart/form-data" >
              @csrf
              <input type="hidden" id="id_centro_custo" name="id_centro_custo" class="form-control" >
              <div class="row">
                <div class="form-group col-10">
                  <label for="nome_centro_custo">Nome:</label>
                  <div class="input-group">
                    <input type="text" id="nome_centro_custo" name="nome_centro_custo" class="form-control" >
                  </div>
                </div>
                
                <div class="form-group col-2">
                  <label for="ativo_centro_custo">Ativo:</label>
                  <div class="input-group d-flex justify-content-center">
                    <input class="form-check-input" type="checkbox" id="ativo_centro_custo" name="ativo_centro_custo" checked>
                  </div>
                </div>
              </div>
            </div>
            <div class="modal-footer justify-content-between">
              <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
              <button type="submit" class="btn btn-primary">Salvar</button>
            </div>
            </form>
          </div>
          <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
      </div>
      <!-- /.modal centro_custo-->

      <div class="modal fade" id="novo_cliente_fornecedor_modal">
        <div class="modal-dialog modal-lg">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title">Adicionar Fornecedores - Clientes</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
            <form name="form_add_cliente_fornecedor" enctype="multipart/form-data" >
              @csrf
              <input type="hidden" id="id_for_cli" name="id_for_cli" class="form-control" >
              <div class="row">
                <div class="form-group col-8">
                  <label for="nome_for_cli">Nome:</label>
                  <div class="input-group">
                    <input type="text" id="nome_for_cli" name="nome_for_cli" class="form-control" >
                  </div>
                </div>
                <div class="form-group col-4">
                  <label for="telefone_for_cli">Telefone:</label>
                  <div class="input-group">
                    <input type="text" id="telefone_for_cli" name="telefone_for_cli" class="form-control" >
                  </div>
                </div>
                <div class="form-group col-8">
                  <label for="email_for_cli">Email:</label>
                  <div class="input-group">
                    <input type="text" id="email_for_cli" name="email_for_cli" class="form-control" >
                  </div>
                </div>
                <div class="form-group col-4">
                  <label for="cpfcnpj_for_cli">CPF/CNPJ:</label>
                  <div class="input-group">
                    <input type="text" id="cpfcnpj_for_cli" name="cpfcnpj_for_cli" class="form-control" >
                  </div>
                </div>
                <div class="form-group col-2">
                  <label for="cep_for_cli">CEP:</label>
                  <div class="input-group">
                    <input type="text" onChange="buscacep(this.value)" id="cep_for_cli" name="cep_for_cli" class="form-control" >
                  </div>
                </div>
                <div class="form-group col-6">
                  <label for="rua_for_cli">Rua:</label>
                  <div class="input-group">
                    <input type="text" id="rua_for_cli" name="rua_for_cli" class="form-control" >
                  </div>
                </div>
                <div class="form-group col-4">
                  <label for="bairro_for_cli">Bairro:</label>
                  <div class="input-group">
                    <input type="text" id="bairro_for_cli" name="bairro_for_cli" class="form-control" >
                  </div>
                </div>
                <div class="form-group col-4">
                  <label for="cidade_for_cli">Cidade:</label>
                  <div class="input-group">
                    <input type="text" id="cidade_for_cli" name="cidade_for_cli" class="form-control" >
                  </div>
                </div>
                <div class="form-group col-4">
                  <label for="estado_for_cli">Estado:</label>
                  <div class="input-group">
                  <select class="form-control" id="estado_for_cli" name="estado_for_cli">
                      <option value=""></option>
                      <option value="AC">Acre</option>
                      <option value="AL">Alagoas</option>
                      <option value="AP">Amapá</option>
                      <option value="AM">Amazonas</option>
                      <option value="BA">Bahia</option>
                      <option value="CE">Ceará</option>
                      <option value="DF">Distrito Federal</option>
                      <option value="ES">Espírito Santo</option>
                      <option value="GO">Goiás</option>
                      <option value="MA">Maranhão</option>
                      <option value="MT">Mato Grosso</option>
                      <option value="MS">Mato Grosso do Sul</option>
                      <option value="MG">Minas Gerais</option>
                      <option value="PA">Pará</option>
                      <option value="PB">Paraíba</option>
                      <option value="PR">Paraná</option>
                      <option value="PE">Pernambuco</option>
                      <option value="PI">Piauí</option>
                      <option value="RJ">Rio de Janeiro</option>
                      <option value="RN">Rio Grande do Norte</option>
                      <option value="RS">Rio Grande do Sul</option>
                      <option value="RO">Rondônia</option>
                      <option value="RR">Roraima</option>
                      <option value="SC">Santa Catarina</option>
                      <option value="SP">São Paulo</option>
                      <option value="SE">Sergipe</option>
                      <option value="TO">Tocantins</option>
                      <option value="EX">Estrangeiro</option>
                  </select>
                  </div>
                </div>
                <div class="form-group col-2">
                  <label for="numero_for_cli">Número:</label>
                  <div class="input-group">
                    <input type="text" id="numero_for_cli" name="numero_for_cli" class="form-control" >
                  </div>
                </div>
                <div class="form-group col-12">
                  <label for="complemento_for_cli">Complemento:</label>
                  <div class="input-group">
                    <input type="text" id="complemento_for_cli" name="complemento_for_cli" class="form-control" >
                  </div>
                </div>
                <div class="form-group col-12">
                  <label for="descricao_for_cli">Descrição:</label>
                  <div class="input-group">
                    <input type="text" id="descricao_for_cli" name="descricao_for_cli" class="form-control" >
                  </div>
                </div>
              </div>
            </div>
            <div class="modal-footer justify-content-between">
              <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
              <button type="submit" class="btn btn-primary">Salvar</button>
            </div>
            </form>
          </div>
          <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
      </div>
      <!-- /.modal -->

      
      <div class="modal fade" id="novo_produtos_modal">
        <div class="modal-dialog modal-lg">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title">Adicionar produto</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
            <form name="form_add_produtos" enctype="multipart/form-data" >
              @csrf
              <input type="hidden" id="id_produtos" name="id_produtos" class="form-control" >
              <div class="row">
                <div class="form-group col-10">
                  <label for="nome_produtos">Nome:</label>
                  <div class="input-group">
                    <input type="text" id="nome_produtos" name="nome_produtos" class="form-control" >
                  </div>
                </div>
                <div class="form-group col-10">
                  <label for="descricao_produtos">Descrição:</label>
                  <div class="input-group">
                    <input type="text" id="descricao_produtos" name="descricao_produtos" class="form-control" >
                  </div>
                </div>
              </div>
            </div>
            <div class="modal-footer justify-content-between">
              <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
              <button type="submit" class="btn btn-primary">Salvar</button>
            </div>
            </form>
          </div>
          <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
      </div>
      <!-- /.modal -->

      <script>
        function notificacoes(){
          document.getElementById('icon-notifi').innerHTML = '';
          $.ajax({
          url:"{{env('APP_URL')}}/notificacoes",
          headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
          type: 'post',
          dataType: 'json',
          success: function(response){
            }
        });
        }
      </script>
</body>
</html>
