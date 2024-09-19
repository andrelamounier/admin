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
            <h1>Editar Email</h1>
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
                <button type="button" class="btn btn-success float-right" onClick="salvarTexto()">
                  Salvar <i class="fa fa-floppy"></i>
                </button></h2>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <div class="form-group">
                    <!-- Campo oculto para o ID da notificação -->
                    <input type="hidden" id="id_email" value="{{ $email->id_notificacao }}" name="id_email" class="form-control">

                    <!-- Campo para o Assunto -->
                    <label for="assunto">Assunto:</label>
                    <input type="text" id="assunto" name="assunto" value="{{ $email->assunto }}" class="form-control">

                    <!-- Campo para "Para" (email de destino) -->
                    <label for="para">Para:</label>
                    <input type="email" id="para" name="para" value="{{ $email->para }}" class="form-control">

                    <!-- Campo para a Data de Envio -->
                    <label for="data_envio">Data de Envio:</label>
                    <input type="date" id="data_envio" name="data_envio" value="{{ \Carbon\Carbon::parse($email->data_envio)->format('Y-m-d') }}" class="form-control">

                    <!-- Campo para o Status -->
                    <label for="status">Status:</label>
                    <select id="status" name="status" class="form-control">
                        <option value="1" {{ $email->enviado == 1 ? 'selected' : '' }}>Enviado</option>
                        <option value="0" {{ $email->enviado == 0 ? 'selected' : '' }}>Não Enviado</option>
                        <option value="2" {{ $email->enviado == 2 ? 'selected' : '' }}>Cancelado</option>
                    </select>

                    <!-- Textarea para a Mensagem com Quebras de Linha -->
                    <label for="compose-textarea">Mensagem:</label>
                    <textarea id="compose-textarea" name="mensagem" class="form-control" style="height: 300px">{{ $email->mensagem }}</textarea>
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
    id = document.getElementById("id_email").value;
    assunto = document.getElementById("assunto").value;
    para = document.getElementById("para").value;
    data = document.getElementById("data_envio").value;
    status = document.getElementById("status").value;
    if(texto!=''){
      $.ajax({
        url:"{{env('APP_URL')}}/editar_email",
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        type: 'post',
        data: { 'id' : id,
                'assunto' : assunto,
                'para' : para,
                'data' : data,
                'status' : status,
                'texto': texto},
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
  }
</script>
@endsection

