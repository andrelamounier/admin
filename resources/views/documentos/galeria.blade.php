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
            <h1>Galeria</h1>
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
                <button type="button" class="btn btn-success" onClick="novaGaleria()">
                    Adicionar <i class="fa fa-plus"></i>
                  </button>
              </div>
              <!-- /.card-header -->

              <div class="card-body"><!-- STACKED BAR CHART -->
                <table id="tabela1" class="table table-bordered table-striped">
                  <thead>
                  <tr>
                    <th>Nome</th>
                    <th>Descrição</th>
                    <th>Quantidade de itens</th>
                    <th>Ações</th>
                  </tr>
                  </thead>
                  <tbody>
                  @foreach($galeria as $item)
                      <tr>
                        <td data-value="{{$item->nome}}" id="nome_{{$item->id}}">{{$item->nome}}</td>
                        <td data-value="{{$item->descricao}}" id="descricao_{{$item->id}}">{{$item->descricao}}</td>
                        <td>{{$item->total}}</td>
                        <td>
                            <a type="button" href="{{env('APP_URL')}}/documentos/perfil?id={{$item->id}}" class="btn btn-primary"><i class="fa fa-eye"></i></a>
                            <button type="button" onClick="editar_galeria({{$item->id}})" class="btn btn-primary"><i class="fa fa-pen"></i></button>
                            <button type="button" onClick="deletar_galeria('{{$item->nome}}',{{$item->id}})" class="btn btn-danger"><i class="fa fa-trash"></i></button>
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
      <div class="modal fade" id="nova_galeria">
        <div class="modal-dialog modal-lg">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title" id="titulo_modal">Nova Galeria</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
            <form name="form_nova_galeria" enctype="multipart/form-data" >
              @csrf
              <input type="hidden" id="id_galeria" value='' name="id_galeria" class="form-control" >
              <div class="row">
                <div class="form-group col-md-12 col-12">
                  <label for="nome_galeria">Nome:</label>
                  <div class="input-group">
                    <input type="text" id="nome_galeria" name="nome_galeria" class="valor form-control" style="display:inline-block">
                  </div>
                </div>
                <div class="form-group col-md-12 col-12">
                    <label for="descricao_galeria">Descrição:</label>
                    <div class="input-group">
                      <input type="text" id="descricao_galeria" name="descricao_galeria" class="valor form-control" style="display:inline-block">
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
@endsection

@section('scripts')
@include('auxiliares.funcoesTabela');
<script>


function editar_galeria(id){
  $('#id_galeria').val(id);
  $('#nome_galeria').val(document.getElementById("nome_"+id).getAttribute('data-value'));
  $('#descricao_galeria').val(document.getElementById("descricao_"+id).getAttribute('data-value'));
  $('#titulo_modal').text('Editar');
  $("#nova_galeria").modal()
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

function deletar_galeria(nome,id){
  Swal.fire({
  title: 'Deseja realmente deletar a galeria ' +nome+' ?',
  showDenyButton: true,
  denyButtonText: `Deletar`,
  confirmButtonText: 'Cancelar',
  }).then((result) => {
    if (result.isConfirmed) {

    } else if (result.isDenied) {
      $.ajax({
        url:"{{env('APP_URL')}}/documentos/del_galeria",
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

function novaGaleria(){
    $('#nome_galeria').val('')
    $('#descricao_galeria').val('')
    $('#titulo_modal').text('novo');
    $("#nova_galeria").modal()
}

$(function(){
  $('Form[name="form_nova_galeria"]').submit(function(event){
    event.preventDefault();
    verifica=true;

    var nome = document.getElementById("nome_galeria");

    if(nome.value==''){
      nome.classList.add("is-invalid");
      verifica=false;
    }else{
      nome.classList.remove("is-invalid");
    }
    if(verifica){
      $.ajax({
        url:"{{env('APP_URL')}}/documentos/nova_galeria",
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
</script>
@endsection
