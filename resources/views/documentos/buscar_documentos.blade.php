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
            <h1>Consulta de documentos</h1>
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
                <form name="form_consulta" method="post" enctype="multipart/form-data" action="{{env('APP_URL')}}/documentos/buscar_documentos">
                  @csrf 
                  <div class="row">
                    <div class="form-group col-md-4 col-12">
                      <label for="for_cli_consulta_documentos">Cliente - Fornecedor:</label>
                      <select id="for_cli_consulta_documentos" multiple  name="for_cli_consulta_documentos[]"class="form-control select2bs4 for_cli_consulta_documentos" >
                      <option value=""></option>
                      @foreach($for_cli as $item)
                            <option value='{{$item->id_for_cli}}'>{{$item->nome}}</option>
                        @endforeach
                      </select>
                    </div>
                    <div class="form-group col-md-3 col-12">
                      <label for="data_inicio_consulta_documentos">Data início:</label>
                      <div class="input-group">
                        <input type="date" id="data_inicio_consulta_documentos" name="data_inicio_consulta_documentos" class="form-control" >
                      </div>
                    </div>
                    <div class="form-group col-md-3 col-12">
                      <label for="data_fim_consulta_documentos">Data fim:</label>
                      <div class="input-group">
                        <input type="date" id="data_fim_consulta_documentos" name="data_fim_consulta_documentos" class="form-control" >
                      </div>
                    </div>
                  </div>
                  <button type="submit" class="btn btn-primary">Consultar</button>
                </form>
              </div>
              <!-- /.card-header -->

              <div class="card-body"><!-- STACKED BAR CHART -->
                <table id="tabela1" class="table table-bordered table-striped">
                  <thead>
                  <tr>
                    <th>Nome</th>
                    <th>Tipo</th>
                    <th>Forn. - Cliente</th>
                    <th>Data</th>
                    <th>Ações</th>
                  </tr>
                  </thead>
                  <tbody>
                  @foreach($documentos as $item)
                      <tr>
                        <td data-value="{{$item->nome}}" id="nome_{{$item->id}}">{{$item->nome}}</td>
                        <td>{{$item->extensao}}</td>
                        <td data-value="{{$item->id_for_cli}}" id="for_cli_{{$item->id}}">{{$item->for_cli}}</td>
                        <td data-value="{{$item->data_cria}}" id="data_{{$item->id}}">
                          <?php
                            $objeto_data = new DateTime($item->data_cria); 
                            echo date_format($objeto_data, 'd/m/Y'); 
                          ?>
                        </td>
                        <td>
                          <button type="button" onClick="editar_documento({{$item->id}})" class="btn btn-primary"><i class="fa fa-pen"></i></button>
                          <button type="button" onClick="deletar_documento('{{$item->nome}}',{{$item->id}})" class="btn btn-danger"><i class="fa fa-trash"></i></button>
                          <?php if($item->tipo!=2){ ?>
                          <a href="{{env('APP_URL')}}/documentos/download?id={{$item->id}}"  class="btn bg-success" >
                            <i class="fas fa-download"></i>
                          </a>
                          <?php } ?>
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



      <div class="modal fade" id="editar_documentos">
        <div class="modal-dialog modal-lg">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title">Editar documentos</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
            <form name="form_editar_documento" enctype="multipart/form-data" >
              @csrf
              <input type="hidden" id="id_documento" value='' name="id_documento" class="form-control" >
              <div class="row">
                <div class="form-group col-md-3 col-12">
                  <label for="nome_documento">Nome:</label>
                  <div class="input-group">
                    <input type="text" id="nome_documento" name="nome_documento" class="valor form-control" style="display:inline-block">
                  </div>
                </div>
                <div class="form-group col-md-4 col-12">
                  <label for="for_cli_documentos">Cliente - Fornecedor:</label>
                  <select id="for_cli_documentos" name="for_cli_documentos"class="form-control select2bs4" style="width: 100%;">
                  <option value="">Nenhum</option>
                  @foreach($for_cli as $item)
                        <option value='{{$item->id_for_cli}}'>{{$item->nome}}</option>
                    @endforeach
                  </select>
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


function editar_documento(id){
  $('#id_documento').val(id); 
  $('#nome_documento').val(document.getElementById("nome_"+id).getAttribute('data-value')); 
  $('#for_cli_documentos').val(document.getElementById("for_cli_"+id).getAttribute('data-value')); 
  $('#for_cli_documentos').trigger('change');
  $("#editar_documentos").modal()
}


$(function(){
  $('Form[name="form_editar_documento"]').submit(function(event){
    event.preventDefault();
    verifica=true;

    var nome = document.getElementById("nome_documento");
   
    if(nome.value==''){
      nome.classList.add("is-invalid");
      verifica=false;
    }else{
      nome.classList.remove("is-invalid");
    }
    if(verifica){
      $.ajax({
        url:"{{env('APP_URL')}}/documentos/edita_documento",
        type: 'post',
        data: $(this).serialize(),
        dataType: 'json',
        success: function(response){
              if(response.status){
                document.location.reload(true);
              }else{
                alert('Erro.');
              }
          }
      });
    }
  });
});

function deletar_documento(nome,id){
  Swal.fire({
  title: 'Deseja realmente deletar o documento ' +nome+' ?',
  showDenyButton: true,
  denyButtonText: `Deletar`,
  confirmButtonText: 'Cancelar',
  }).then((result) => {
    if (result.isConfirmed) {
     
    } else if (result.isDenied) {
      $.ajax({
        url:"{{env('APP_URL')}}/documentos/del_documento",
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        type: 'post',
        data: {'id' : id},
        dataType: 'json',
        success: function(response){
              if(response.status){
                document.location.reload(true);
              }else{
                alert('Erro.');
              }
          }
      });
    }
  });
}

</script>
@endsection