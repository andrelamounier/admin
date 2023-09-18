@extends('layouts/main')

@section('style')
<link rel="stylesheet" href="{{env('APP_URL')}}/plugins/summernote/summernote-bs4.min.css">
@endsection

@section('content')
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Editar Documentos</h1>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
        
          <!-- /.col -->
          <div class="col-md-12">
            <div class="card card-primary card-outline">
              <div class="card-header">
                <h2>{{$documentos[0]->nome}}
                <button type="button" class="btn btn-success float-right" onClick="salvarTexto()">
                  Salvar <i class="fa fa-floppy"></i>
                </button></h2>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <div class="form-group">
                    <input type="hidden" id="id_documento" value="{{$documentos[0]->id}}" name="id_documento" class="form-control" >
                    <textarea id="compose-textarea" class="form-control" style="height: 300px">{{$documentos[0]->texto}}</textarea>
                </div>
              </div>
              <!-- /.card-body -->
              <div class="card-footer">
                
              </div>
              <!-- /.card-footer -->
            </div>
            <!-- /.card -->
          </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->



@endsection

@section('scripts')
<!-- Summernote -->
<script src="{{env('APP_URL')}}/plugins/summernote/summernote-bs4.min.js"></script>
<script>
  $(function () {
    //Add text editor
    $('#compose-textarea').summernote()
  })

  $("#compose-textarea").summernote({
        toolbar: [
            [ 'style', [ 'style' ] ],
            [ 'font', [ 'bold', 'italic', 'underline', 'strikethrough', 'superscript', 'subscript', 'clear'] ],
            [ 'fontname', [ 'fontname' ] ],
            [ 'fontsize', [ 'fontsize' ] ],
            [ 'color', [ 'color' ] ],
            [ 'para', [ 'ol', 'ul', 'paragraph', 'height' ] ],
            [ 'table', [ 'table' ] ],
            [ 'insert', [ 'link'] ],
            [ 'view', [ 'undo', 'redo', 'fullscreen', 'codeview', 'help' ] ]
        ]
    });

  function salvarTexto(){
    texto = document.getElementById("compose-textarea").value;
    id = document.getElementById("id_documento").value;
    
    if(texto!=''){
      $.ajax({
        url:"{{env('APP_URL')}}/documentos/editar_documento",
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        type: 'post',
        data: {'id' : id,
               'texto': texto},
        dataType: 'json',
        success: function(response){
              if(response.status){
                //console.log(response.status);
                document.location.reload(true);
              }else{
                alert('Erro.');
              }
          }
      });
    }
  }
</script>
@endsection

