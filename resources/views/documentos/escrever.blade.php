@extends('layouts/main')

@section('style')
<!-- dropzonejs -->

@endsection

@section('content')
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Documentos</h1>
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
                        <form name="form_add_escrever"  method="post" enctype="multipart/form-data" action="{{env('APP_URL')}}/documentos/add_escrever">
                          @csrf 
                          <div class="row">
                            <div class="form-group col-md-7 col-12">
                              <label for="titulo_escrever">Título:</label>
                              <div class="input-group">
                                <input type="text" id="titulo_escrever" name="titulo_escrever" class="form-control" required>
                              </div>
                            </div>
                            <div class="form-group col-md-5 col-12">
                              <label for="for_cli_escrever">Cliente - Fornecedor:</label>
                              <select id="for_cli_escrever" name="for_cli_escrever"class="form-control select2bs4" style="width: 100%;">
                              <option value=""></option>
                              @foreach($for_cli as $item)
                                    <option value='{{$item->id_for_cli}}'>{{$item->nome}}</option>
                                @endforeach
                              </select>
                            </div>
                          </div>
                          <div class="modal-footer justify-content-between">
                            <button type="submit" class="btn btn-primary">Novo</button>
                          </div>
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
              
              @foreach($documentos as $item)
                  <?php
                    $tamanhoNome=strlen($item->nome);
                    $br='';
                    if($tamanhoNome<=25){
                      $br='<br><br>';
                    }else if($tamanhoNome<=50){
                      $br='<br>';
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
                          <i class="fa-solid fa-pen-nib"></i>
                        </div>
                        <div class="small-box-footer" >
                          <a href="{{env('APP_URL')}}/documentos/editar?id={{$item->id}}" class="ml-2 btn btn-default btn-sm bg-success">
                            <i class="fas fa-pen"></i>
                          </a>
                          <!--<a href="{{env('APP_URL')}}/documentos/download_escrito?id={{$item->id}}"  class="btn btn-default btn-sm bg-success" >
                            <i class="fas fa-download"></i>
                          </a>-->
                          <a href="#" class="btn btn-default btn-sm bg-danger" onClick="deletar_documento('{{$item->nome}}','{{$item->id}}')" >
                            <i class="fas fa-trash"></i>
                          </a>
                        </div>
                      </div>
                    </div>

                  @endforeach
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

<script>

$(function(){
  $('Form[name="form_add_escrever"]').submit(function(event){
    event.preventDefault();
    $.ajax({
      url:"{{env('APP_URL')}}/documentos/add_escrever",
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
        data: {'id' : id,
               'tipo': '2'},
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
}
</script>
@endsection

