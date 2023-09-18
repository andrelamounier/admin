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
            <h1>Fornecedores - Clientes</h1>
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
                <button type="button" class="btn btn-success" onClick="novo_cliente_fornecedor_modal()">
                  Adicionar <i class="fa fa-plus"></i>
                </button>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table id="tabela1" class="table table-bordered table-striped">
                  <thead>
                  <tr>
                    <th>Nome</th>
                    <th>Telefone</th>
                    <th>Email</th>
                    <th>Descrição</th>
                    <th>Cep</th>
                    <th>Rua</th>
                    <th>Bairro</th>
                    <th>Cidade</th>
                    <th>Estado</th>
                    <th>Número</th>
                    <th>Complemento</th>
                    <th>CPF/CNPJ</th>
                    <th>Ações</th>
                  </tr>
                  </thead>
                  <tbody>
                    @foreach($for_cli as $item)
                      <tr>
                        <td id="nome_{{$item->id_for_cli}}">{{$item->nome}}</td>
                        <td id="telefone_{{$item->id_for_cli}}">{{$item->telefone}}</td>
                        <td id="email_{{$item->id_for_cli}}">{{$item->email}}</td>
                        <td id="descricao_{{$item->id_for_cli}}">{{$item->descricao}}</td>
                        <td id="cep_{{$item->id_for_cli}}">{{$item->cep}}</td>
                        <td id="rua_{{$item->id_for_cli}}">{{$item->rua}}</td>
                        <td id="bairro_{{$item->id_for_cli}}">{{$item->bairro}}</td>
                        <td id="cidade_{{$item->id_for_cli}}">{{$item->cidade}}</td>
                        <td id="estado_{{$item->id_for_cli}}">{{$item->estado}}</td>
                        <td id="numero_{{$item->id_for_cli}}">{{$item->numero}}</td>
                        <td id="complemento_{{$item->id_for_cli}}">{{$item->complemento}}</td>
                        <td id="cpfcnpj_{{$item->id_for_cli}}">{{$item->cpfcnpj}}</td>
                        <td>
                          <button type="button" onClick="editar({{$item->id_for_cli}})" class="btn btn-primary"><i class="fa fa-pen"></i></button>
                          <a type="button" href="{{env('APP_URL')}}/fonecedor_cliente/perfil?id={{$item->id_for_cli}}" class="btn btn-primary"><i class="fa fa-eye"></i></a>
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




      
@endsection

@section('scripts')
@include('auxiliares.funcoesTabela');
<script>


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
              document.location.reload(true);
            }else{
              alert(response.message);
            }
        }
    });
  });
});

$('.dinheiro').mask('#.##0,00', {reverse: true});
$('.telefone').mask('(00) 0 0000-0000');


function novo_cliente_fornecedor_modal(){
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

function editar(id){
  document.getElementById("id_for_cli").value=id;
  document.getElementById("nome_for_cli").value=document.getElementById ( "nome_"+id ).innerText;
  document.getElementById("descricao_for_cli").value=document.getElementById ( "descricao_"+id ).innerText;
  document.getElementById("email_for_cli").value=document.getElementById ( "email_"+id ).innerText;
  document.getElementById("telefone_for_cli").value=document.getElementById ( "telefone_"+id ).innerText;
  document.getElementById("rua_for_cli").value=document.getElementById ( "rua_"+id ).innerText;
  document.getElementById("cep_for_cli").value=document.getElementById ( "cep_"+id ).innerText;
  document.getElementById("cidade_for_cli").value=document.getElementById ( "cidade_"+id ).innerText;
  document.getElementById("estado_for_cli").value=document.getElementById ( "estado_"+id ).innerText;
  document.getElementById("cpfcnpj_for_cli").value=document.getElementById ( "cpfcnpj_"+id ).innerText;
  document.getElementById("numero_for_cli").value=document.getElementById ( "numero_"+id ).innerText;
  document.getElementById("bairro_for_cli").value=document.getElementById ( "bairro_"+id ).innerText;
  document.getElementById("complemento_for_cli").value=document.getElementById ( "complemento_"+id ).innerText;
  $("#novo_cliente_fornecedor_modal").modal()
}


</script>
@endsection

