@extends('layouts/main')

@section('style')
<!-- DataTables -->
<link rel="stylesheet" href="{{env('APP_URL')}}plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" href="{{env('APP_URL')}}plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
<link rel="stylesheet" href="{{env('APP_URL')}}plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
@endsection

@section('content')
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Status</h1>
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
                <button type="button" class="btn btn-success" onClick="novo()">
                  Adicionar <i class="fa fa-plus"></i>
                </button>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table id="example1" class="table table-bordered table-striped">
                  <thead>
                  <tr>
                    <th>Nome</th>
                    <th>Status</th>
                    <th>Ações</th>
                  </tr>
                  </thead>
                  <tbody>
                    @foreach($status as $item)
                      <tr>
                        <td id="nome_{{$item->id_status}}">{{$item->nome}}</td>
                        <td id="status_{{$item->id_status}}">
                          @if($item->status=='1')
                            Ativo
                          @else
                            Desativado
                          @endif
                        </td>
                        <td>
                          <button type="button" onClick="editar({{$item->id_status}})" class="btn btn-primary"><i class="fa fa-pen"></i></button>
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




  <div class="modal fade" id="novo">
        <div class="modal-dialog modal-lg">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title">Adicionar status</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
            <form name="form_add" enctype="multipart/form-data" >
              @csrf
              <input type="hidden" id="id" name="id" class="form-control" >
              <div class="row">
                <div class="form-group col-10">
                  <label for="nome">Nome:</label>
                  <div class="input-group">
                    <input type="text" id="nome" name="nome" class="form-control" >
                  </div>
                </div>
                
                <div class="form-group col-2">
                  <label for="ativo">Ativo:</label>
                  <div class="input-group d-flex justify-content-center">
                    <input class="form-check-input" type="checkbox" id="ativo" name="ativo" checked>
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
<!-- DataTables  & Plugins -->
<script src="{{env('APP_URL')}}plugins/datatables/jquery.dataTables.min.js"></script>
<script src="{{env('APP_URL')}}plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="{{env('APP_URL')}}plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="{{env('APP_URL')}}plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
<script src="{{env('APP_URL')}}plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
<script src="{{env('APP_URL')}}plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
<script src="{{env('APP_URL')}}plugins/jszip/jszip.min.js"></script>
<script src="{{env('APP_URL')}}plugins/pdfmake/pdfmake.min.js"></script>
<script src="{{env('APP_URL')}}plugins/pdfmake/vfs_fonts.js"></script>
<script src="{{env('APP_URL')}}plugins/datatables-buttons/js/buttons.html5.min.js"></script>
<script src="{{env('APP_URL')}}plugins/datatables-buttons/js/buttons.print.min.js"></script>
<script src="{{env('APP_URL')}}plugins/datatables-buttons/js/buttons.colVis.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.form/4.3.0/jquery.form.min.js"></script>
<script src="https://igorescobar.github.io/jQuery-Mask-Plugin/js/jquery.mask.min.js"></script>  
<script src="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.12.6/js/standalone/selectize.min.js"></script>
<script>
$(document).ready(function() {
    $('#example1').DataTable( {
        "iDisplayLength": 50,
        dom: 'Bfrtip',
        "aaSorting": [],
        language: {
            url: 'https://cdn.datatables.net/plug-ins/1.12.1/i18n/pt-BR.json'
        },
        "responsive": true,
        buttons: [
            'excelHtml5',
            'pdfHtml5',
            "colvis"
        ]
    } );
} );

$(function(){
  $('Form[name="form_add"]').submit(function(event){
    event.preventDefault();
    $.ajax({
      url:"/add_status",
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
  });
});

$('.dinheiro').mask('#.##0,00', {reverse: true});
$('.telefone').mask('(00) 0 0000-0000');

function novo(){
  document.getElementById("id").value='';
  document.getElementById("nome").value='';
  $("#novo").modal()
}

function editar(id){
  document.getElementById("id").value=id;
  document.getElementById("nome").value=document.getElementById ( "nome_"+id ).innerText;
  checkbox = document.getElementById("ativo");
  if(document.getElementById ( "status_"+id ).innerText=='Ativo'){
    checkbox.checked = true;
  }else{
    checkbox.checked = false;
  }

  $("#novo").modal()
}

</script>
@endsection

