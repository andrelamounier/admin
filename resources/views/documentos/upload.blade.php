@extends('layouts/main')

@section('style')
<!-- dropzonejs -->
<link rel="stylesheet" href="{{env('APP_URL')}}/resources/css/dropzone.min.css" />
@endsection

@section('content')
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Upload</h1>
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
              <div class="row">
          <div class="col-md-12">
            <div class="card card-default">
             
              <div class="card-body">
                <form name="form_add_projetos" class="dropzone dz-clickable bg-info" id="documentosupload" method="post" enctype="multipart/form-data" action="{{env('APP_URL')}}/documentos/dropzoneStorage">
                  @csrf 
                  <div>
                    <h3 class="text-center">Click ou solte um arquivo para fazer upload.</h3>
                  </div>
                  <div class="dz-default dz-message"></div>
                </form>
             
              </div>
              <!-- /.card-body -->
             
            </div>
            <!-- /.card -->
          </div>
        </div>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <div class="row" id="itens_documentos">
                  @foreach($documentos as $item)
                  <?php
                    $fileNameParts = explode('.', $item->caminho);
                    $extension = end($fileNameParts);
                    $icon='';
                    $tamanhoNome=strlen($item->nome);
                    $br='';
                    if($tamanhoNome<=25){
                      $br='<br><br>';
                    }else if($tamanhoNome<=50){
                      $br='<br>';
                    }
                    switch($extension){
                      case 'pdf':
                          $icon='<i class="far fa-file-pdf"></i>';
                          break;
                      case 'doc' :
                      case 'docx':
                          $icon='<i class="far fa-file-word"></i>';
                          break;
                      case 'jpg' : case 'png' : case  'jpeg' : case  'webp':
                          $icon='<i class="fas fa-camera"></i>';
                          break;
                      default:
                          $icon='<i class="fas fa-paperclip"></i>';
                    }
                  ?>

                    <div class="col-lg-3 col-6" >
                      <!-- small card -->
                      <div class="small-box bg-info">
                        <div class="inner">
                          <p>{{$item->nome}}</p>
                          <?php echo $br; ?>
                        </div>
                        <div class="icon">
                          <?php echo $icon; ?>
                        </div>
                        <div class="small-box-footer" >
                          <a href="{{env('APP_URL')}}/documentos/download?id={{$item->id}}"  class="btn btn-default btn-sm bg-success" >
                            <i class="fas fa-download"></i>
                          </a>
                          <a href="#" class="btn btn-default btn-sm bg-danger" onClick="deletar_documento('{{$item->nome}}','{{$item->id}}')" >
                            <i class="fas fa-trash"></i>
                          </a>
                        </div>
                      </div>
                    </div>

                  @endforeach
                </div>
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
<!-- dropzonejs -->
<script src="{{env('APP_URL')}}/resources/js/dropzone.min.js"></script>

<script>
Dropzone.options.documentosupload = { // camelized version of the `id`
    paramName: "file", // The name that will be used to transfer the file
    maxFilesize: 3, // MB
    acceptedFiles: 'image/*,.pdf,.doc,.docx',
    success:function(file, response){
      if(response.status=='erro'){
        $(document).Toasts('create', {
          class: 'bg-danger',
          title: 'Erro!',
          subtitle: '',
          body: response.msg
        })
      }else{
        document.getElementById('itens_documentos').innerHTML = response.status;
      }
    
  }
}

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

