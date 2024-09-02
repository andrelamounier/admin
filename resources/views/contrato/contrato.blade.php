@extends('layouts/main')

@section('style')
<!-- DataTables -->
<link rel="stylesheet" href="{{env('APP_URL')}}/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" href="{{env('APP_URL')}}/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
<link rel="stylesheet" href="{{env('APP_URL')}}/plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
@endsection

@section('content')
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Contratos</h1>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">
            <div class="card">
              <div class="card-header">
                <button type="button" class="btn btn-success" onClick="novo_contrato_modal()">
                  Adicionar <i class="fa fa-plus"></i>
                </button>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table id="tabela1" class="table table-bordered table-striped">
                  <thead>
                  <tr>
                    <th>Número</th>
                    <th>Cliente</th>
                    <th>Valor</th>
                    <th>Status</th>
                    <th>Vencimento</th>
                    <th>Inicio</th>
                    <th>Encerramento</th>
                    <th>Reajuste</th>
                    <th>Produto</th>
                    <th>Ações</th>
                  </tr>
                  </thead>
                  <tbody>
                    @foreach($contratos as $item)
                    <?php
                    $data_inicio = $item->data_inicio ? (new DateTime($item->data_inicio))->format('d/m/Y') : '';
                    $data_fim = $item->data_fim ? (new DateTime($item->data_fim))->format('d/m/Y') : '';
                    $data_reajuste = $item->data_reajuste ? (new DateTime($item->data_reajuste))->format('d/m/Y') : '';
                    ?>
                      <tr>
                        <td id="numero_{{$item->id_contrato}}">{{$item->numero_contrato}}</td>
                        <td data-value="{{$item->id_for_cli}}" id="cliente_{{$item->id_contrato}}">{{$item->cliente}}</td>
                        <td data-value="{{$item->valor}}" id="valor_{{$item->id_contrato}}">R$ {{number_format($item->valor, 2, ',', '')}}</td>
                        <td data-value="{{$item->status}}" id="status_{{$item->id_contrato}}">
                            @if($item->status == 1)
                             Ativo
                            @elseif($item->status == 2)
                             Cncelado
                            @endif
                        </td>

                        <td data-value="{{$item->data_pagamento}}" id="data_pagamento_{{$item->id_contrato}}">
                            @if($item->data_pagamento == 32)
                                Primeiro dia útil
                            @elseif($item->data_pagamento == 33)
                                Quinto dia útil
                            @elseif($item->data_pagamento != '')
                                 Dia {{$item->data_pagamento}}
                            @endif
                        </td>
                        <td data-value="{{$item->data_inicio}}" id="data_inicio_{{$item->id_contrato}}">{{$data_inicio}}</td>
                        <td data-value="{{$item->data_fim}}" id="data_fim_{{$item->id_contrato}}">{{$data_fim}}</td>
                        <td data-value="{{$item->data_reajuste}}" id="reajuste_{{$item->id_contrato}}">{{$data_reajuste}}</td>
                        <td data-value="{{$item->id_produto}}" id="produto_{{$item->id_contrato}}">{{$item->produto}}</td>
                        <input type="hidden" id="descricao_{{$item->id_contrato}}" value="{{$item->descricao}}">
                        <input type="hidden" id="centro_custo_{{$item->id_contrato}}" value="{{$item->id_centro_custo}}">
                        <td>
                          <button type="button" onClick="editar({{$item->id_contrato}})" class="btn btn-primary"><i class="fa fa-pen"></i></button>
                        </td>
                      </tr>
                    @endforeach
                  </tbody>
                </table>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->
      </div>
      <!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->


  <div class="modal fade" id="novo_contrato_modal">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Adicionar Contrato</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
        <form name="form_add_contrato" enctype="multipart/form-data" >
          @csrf
          <input type="hidden" id="id_contrato" name="id_contrato" class="form-control" >
          <div class="row">
            <div class="form-group col-3">
              <label for="numero_contrato">Numero:</label>
              <div class="input-group">
                <input type="text" id="numero_contrato" name="numero_contrato" class="form-control" >
              </div>
            </div>
            <div class="form-group col-md-4 col-12">
                <label for="for_cli_contrato">Cliente:
                    <button type="button" onClick="addCF()" class="btn btn-primary btn-sm" title="Adicionar">
                      <i class="fas fa-plus"></i>
                    </button></label>
                </label>
                <select id="for_cli_contrato" name="for_cli_contrato"class="form-control select2bs4" style="width: 100%;">
                <option value=""></option>
                @foreach($for_cli as $item)
                      <option value='{{$item->id_for_cli}}'>{{$item->nome}}</option>
                  @endforeach
                </select>
            </div>
            <div class="form-group col-md-4 col-12">
                <label for="produto_contrato">Produto:
                    <button type="button" onClick="addProd()" class="btn btn-primary btn-sm" title="Adicionar">
                      <i class="fas fa-plus"></i>
                    </button></label>
                </label>
                <select id="produto_contrato" name="produto_contrato"class="form-control select2bs4" style="width: 100%;">
                <option value=""></option>
                  @foreach($produtos as $item)
                    <option value='{{$item->id_produto}}'>{{$item->nome}}</option>
                  @endforeach
                </select>
            </div>
            <div class="form-group col-md-2 col-12">
                <label for="valor_contrato">Valor:</label>
                <div class="input-group">
                  <input type="text" id="valor_contrato" name="valor_contrato" class="valor form-control " style="display:inline-block">
                </div>
            </div>
            <div class="form-group col-md-4 col-12">
                <label for="centro_custo_contrato">Centro de custo:
                    <button type="button" onClick="addCC()" class="btn btn-primary btn-sm" title="Adicionar">
                      <i class="fas fa-plus"></i>
                    </button></label>
                <select id="centro_custo_contrato" name="centro_custo_contrato"class="form-control select2bs4" style="width: 100%;">
                <option value=""></option>
                  @foreach($centro_custo as $item)
                    <option value='{{$item->id_centro_custo}}'>{{$item->nome}}</option>
                  @endforeach
                </select>
              </div>
            <div class="form-group col-md-3 col-12" id="divRepeticao">
                <label for="status_contrato">Status:</label>
                <select id="status_contrato" name="status_contrato"class="form-control select2bs4" style="width: 100%;">
                    <option value=''></option>
                    <option value='1'>Ativo</option>
                    <option value='2'>Cancelado</option>
                </select>
            </div>
            <div class="form-group col-md-3 col-12">
              <label for="data_vencimento_contrato">Dia pagamento:</label>
              <select id="data_vencimento_contrato" name="data_vencimento_contrato" class="form-control select2bs4" style="width: 100%;">
                  <option value="32">Primeiro dia útil</option>
                  <option value="33">Quinto dia útil</option>
                  <option value="1">1</option>
                  <option value="2">2</option>
                  <option value="3">3</option>
                  <option value="4">4</option>
                  <option value="5">5</option>
                  <option value="6">6</option>
                  <option value="7">7</option>
                  <option value="8">8</option>
                  <option value="9">9</option>
                  <option value="10">10</option>
                  <option value="11">11</option>
                  <option value="12">12</option>
                  <option value="13">13</option>
                  <option value="14">14</option>
                  <option value="15">15</option>
                  <option value="16">16</option>
                  <option value="17">17</option>
                  <option value="18">18</option>
                  <option value="19">19</option>
                  <option value="20">20</option>
                  <option value="21">21</option>
                  <option value="22">22</option>
                  <option value="23">23</option>
                  <option value="24">24</option>
                  <option value="25">25</option>
                  <option value="26">26</option>
                  <option value="27">27</option>
                  <option value="28">28</option>
                  <option value="29">29</option>
                  <option value="30">30</option>
                  <option value="31">31</option>
              </select>
            </div>

            <div class="form-group col-md-3 col-12">
                <label for="data_inicio_contrato">Data inicio:</label>
                <div class="input-group">
                  <input type="date" id="data_inicio_contrato"  name="data_inicio_contrato" class="form-control" >
                </div>
            </div>
            <div class="form-group col-md-3 col-12">
                <label for="data_reajuste_contrato">Data reajuste:</label>
                <div class="input-group">
                  <input type="date" id="data_reajuste_contrato"  name="data_reajuste_contrato" class="form-control" >
                </div>
            </div>
            <div class="form-group col-md-3 col-12">
                <label for="data_fim_contrato">Data fim:</label>
                <div class="input-group">
                  <input type="date" id="data_fim_contrato"  name="data_fim_contrato" class="form-control" >
                </div>
            </div>
            <div class="form-group col-12">
              <label for="descricao_contrato">Descrição:</label>
              <div class="input-group">
                <input type="text" id="descricao_contrato" name="descricao_contrato" class="form-control" >
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


@endsection

@section('scripts')
@include('auxiliares.funcoesTabela');
<script>

$('.dinheiro').mask('#.##0,00', {reverse: true});


function novo_contrato_modal(){
console.log(1)
  document.getElementById("id_contrato").value='';
  document.getElementById("numero_contrato").value='';
  document.getElementById("for_cli_contrato").value='';
  document.getElementById("produto_contrato").value='';
  document.getElementById("centro_custo_contrato").value='';
  document.getElementById("valor_contrato").value='';
  document.getElementById("status_contrato").value='';
  document.getElementById("data_vencimento_contrato").value='';
  document.getElementById("data_inicio_contrato").value='';
  document.getElementById("data_reajuste_contrato").value='';
  document.getElementById("data_fim_contrato").value='';
  document.getElementById("descricao_contrato").value='';
  $('#for_cli_contrato').trigger('change');
  $('#produto_contrato').trigger('change');
  $('#centro_custo_contrato').trigger('change');
  $('#status_contrato').trigger('change');
  $('#data_vencimento_contrato').trigger('change');
  $('.valor').mask('#.##0,00', {reverse: true});
  var inputDate = document.getElementById('data_inicio_contrato');
  var dataAtual = new Date().toISOString().split('T')[0];
  inputDate.value = dataAtual;
  $("#novo_contrato_modal").modal()
}

function editar(id){
  $('#status_contrato').val(document.getElementById("status_"+id).getAttribute('data-value'));
  $('#status_contrato').trigger('change');
  $('#produto_contrato').val(document.getElementById("produto_"+id).getAttribute('data-value'));
  $('#produto_contrato').trigger('change');
  $('#centro_custo_contrato').val(document.getElementById("centro_custo_"+id).value);
  $('#centro_custo_contrato').trigger('change');
  $('#for_cli_contrato').val(document.getElementById("cliente_"+id).getAttribute('data-value'));
  $('#for_cli_contrato').trigger('change');
  $('#data_vencimento_contrato').val(document.getElementById("data_pagamento_"+id).getAttribute('data-value'));
  $('#data_vencimento_contrato').trigger('change');

  document.getElementById("id_contrato").value=id;
  document.getElementById("for_cli_contrato").value=document.getElementById("cliente_"+id).getAttribute('data-value');
  document.getElementById("numero_contrato").value=document.getElementById( "numero_"+id ).innerText;
  document.getElementById("produto_contrato").value=document.getElementById("produto_"+id).getAttribute('data-value');
  document.getElementById("valor_contrato").value=document.getElementById("valor_"+id).getAttribute('data-value');
  document.getElementById("status_contrato").value=document.getElementById( "status_"+id ).getAttribute('data-value');
  document.getElementById("data_inicio_contrato").value=document.getElementById("data_inicio_"+id).getAttribute('data-value');
  document.getElementById("data_reajuste_contrato").value=document.getElementById("reajuste_"+id).getAttribute('data-value');
  document.getElementById("data_fim_contrato").value=document.getElementById("data_fim_"+id).getAttribute('data-value');
  document.getElementById("descricao_contrato").value=document.getElementById( "descricao_"+id ).value;
  document.getElementById("centro_custo_contrato").value=document.getElementById("centro_custo_"+id).value;
  $('.valor').mask('#.##0,00', {reverse: true});
  $("#novo_contrato_modal").modal()
}

function addCF(){
  document.getElementById("id_for_cli").value='';
  document.getElementById("nome_for_cli").value='';
  document.getElementById("descricao_for_cli").value='';
  document.getElementById("email_for_cli").value='';
  document.getElementById("telefone_for_cli").value='';
  document.getElementById("rua_for_cli").value='';
  document.getElementById("cep_for_cli").value='';
  document.getElementById("cidade_for_cli").value='';
  document.getElementById("estado_for_cli").value='';
  document.getElementById("cpfcnpj_for_cli").value='';
  document.getElementById("numero_for_cli").value='';
  document.getElementById("bairro_for_cli").value='';
  document.getElementById("complemento_for_cli").value='';
  $("#novo_cliente_fornecedor_modal").modal()
}
$(function(){
  $('Form[name="form_add_cliente_fornecedor"]').submit(function(event){
    event.preventDefault();
    $.ajax({
      url:"{{env('APP_URL')}}/add_for_cli",
      type: 'post',
      data: $(this).serialize(),
      dataType: 'json',
      success: function(response){
            if(response.status){
              atualizarFC();
            }else{
              alert(response.message);
            }
        }
    });
  });
});
function atualizarFC(){
    $.ajax({
        url:"{{env('APP_URL')}}/buscar_fc",
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        type: 'post',
        dataType: 'json',
        success: function(response){
              if(response.status){
                $("#for_cli_contrato").html(response.options);
                $("#novo_cliente_fornecedor_modal").modal("hide");
              }else{
                alert(response.message);
              }
          }
      });
}

function addCC(){
  document.getElementById("id_centro_custo").value='';
  document.getElementById("nome_centro_custo").value='';
  $("#novo_centro_custo_modal").modal();
}
$(function(){
  $('Form[name="form_add_centro_custo"]').submit(function(event){
    event.preventDefault();
    $.ajax({
      url:"{{env('APP_URL')}}/add_custo",
      type: 'post',
      data: $(this).serialize(),
      dataType: 'json',
      success: function(response){
            if(response.status){
              atualizarCC();
            }else{
              alert(response.message);
            }
        }
    });
  });
});
function atualizarCC(){
    $.ajax({
        url:"{{env('APP_URL')}}/buscar_cc",
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        type: 'post',
        dataType: 'json',
        success: function(response){
              if(response.status){
                $("#centro_custo_contrato").html(response.options);
                $("#novo_centro_custo_modal").modal("hide");
              }else{
                alert(response.message);
              }
          }
      });
}

function addProd(){
  document.getElementById("id_produtos").value='';
  document.getElementById("nome_produtos").value='';
  document.getElementById("descricao_produtos").value='';
  $("#novo_produtos_modal").modal()
}
$(function(){
  $('Form[name="form_add_produtos"]').submit(function(event){
    event.preventDefault();
    $.ajax({
      url:"{{env('APP_URL')}}/add_produto",
      type: 'post',
      data: $(this).serialize(),
      dataType: 'json',
      success: function(response){
            if(response.status){
              atualizarProd();
            }else{
              alert(response.message);
            }
        }
    });
  });
});
function atualizarProd(){
    $.ajax({
        url:"{{env('APP_URL')}}/buscar_Prod",
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        type: 'post',
        dataType: 'json',
        success: function(response){
              if(response.status){
                $("#produto_contrato").html(response.options);
                $("#novo_produtos_modal").modal("hide");
              }else{
                alert(response.message);
              }
          }
      });
}

$(function(){
  $('Form[name="form_add_contrato"]').submit(function(event){
    event.preventDefault();
    verifica=true;

    var produto = document.getElementById("produto_contrato");
    var valor = document.getElementById("valor_contrato");
    var status_contrato = document.getElementById("status_contrato");
    var data_vencimento = document.getElementById("data_vencimento_contrato");
    var for_cli = document.getElementById("for_cli_contrato");
    var data_inicio = document.getElementById("data_inicio_contrato");
    var id_contrato = document.getElementById("id_contrato");
    var numero_contrato = document.getElementById("numero_contrato");
    var data_reajuste = document.getElementById("data_reajuste_contrato");
    var data_fim = document.getElementById("data_fim_contrato");
    var descricao = document.getElementById("descricao_contrato");
    var centro_custo = document.getElementById("centro_custo_contrato");

    if(for_cli.value==''){
      for_cli.classList.add("is-invalid");
      verifica=false;
    }else{
      for_cli.classList.remove("is-invalid");
    }
    if(status_contrato.value==''){
      status_contrato.classList.add("is-invalid");
      verifica=false;
    }else{
      status_contrato.classList.remove("is-invalid");
    }
    if(centro_custo.value==''){
        centro_custo.classList.add("is-invalid");
      verifica=false;
    }else{
        centro_custo.classList.remove("is-invalid");
    }
    if(numero_contrato.value==''){
        numero_contrato.classList.add("is-invalid");
      verifica=false;
    }else{
        numero_contrato.classList.remove("is-invalid");
    }

    if(verifica){
      $.ajax({
        url:"{{env('APP_URL')}}/add_contrato",
        type: 'post',
        data: $(this).serialize(),
        dataType: 'json',
        success: function(response){
              if(response.status){
                document.location.reload(true);
              }else{
                alert(response.message);
              }
          }
      });
    }
  });
});
</script>
@endsection

