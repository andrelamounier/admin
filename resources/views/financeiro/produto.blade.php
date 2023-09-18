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
            <h1>Produtos</h1>
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
                <button type="button" class="btn btn-success" onClick="novo_produtos()">
                  Adicionar <i class="fa fa-plus"></i>
                </button>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table id="tabela1" class="table table-bordered table-striped">
                  <thead>
                  <tr>
                    <th>Produto</th>
                    <th>Descrição</th>
                    <th>Ações</th>
                  </tr>
                  </thead>
                  <tbody>
                    @foreach($produtos as $item)
                      <tr>
                        <td id="nome_{{$item->id_produto}}">{{$item->nome}}</td>
                        <td id="descricao_{{$item->id_produto}}">{{$item->descricao}}</td>
                        <td>
                          <button type="button" onClick="editar_produtos({{$item->id_produto}})" class="btn btn-primary"><i class="fa fa-pen"></i></button>
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
  $('Form[name="form_add_produtos"]').submit(function(event){
    event.preventDefault();
    $.ajax({
      url:"{{env('APP_URL')}}/add_produto",
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


function novo_produtos(){
  document.getElementById("id_produtos").value='';
  document.getElementById("nome_produtos").value='';
  document.getElementById("descricao_produtos").value='';
  $("#novo_produtos_modal").modal()
}

function editar_produtos(id){
  document.getElementById("id_produtos").value=id;
  document.getElementById("nome_produtos").value=document.getElementById ( "nome_"+id ).innerText;
  document.getElementById("descricao_produtos").value=document.getElementById ( "descricao_"+id ).innerText;
 
  $("#novo_produtos_modal").modal()
}

</script>
@endsection

