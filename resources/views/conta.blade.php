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
            <h1>Conta</h1>
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
                Geral
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <form name="form_altera_conta" enctype="multipart/form-data" >
                  <div class="row">
                    @csrf
                    <div class="form-group col-12 col-lg-4">
                      <label for="nome_conta">Nome:</label>
                      <div class="input-group">
                        <input type="text" id="nome_conta" maxlength="30" value="{{auth()->user()->name}}" name="nome_conta" class="form-control" >
                      </div>
                    </div>
                    <div class="form-group col-12 col-lg-8">
                      <label for="email_conta">Email:</label>
                      <div class="input-group">
                        <input type="email" id="email_conta" maxlength="100" value="{{auth()->user()->email}}" name="email_conta" class="form-control" >
                      </div>
                    </div>
                    <div class="form-group  col-12">
                      <button type="submit" class="btn btn-primary">Salvar</button>
                    </div>
                  </div>
                </form>
                <hr>
                <p><a href="#" onClick="alterarSenha()">Mudar senha?</a></p>
                <p><a href="#" onClick="deletarConta()">Deletar sua conta?</a></p>
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


      <div class="modal fade" id="deletar_conta">
        <div class="modal-dialog modal-lg">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title">Confirme sua senha</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
            <form name="del_conta_usuario" enctype="multipart/form-data" >
              @csrf
              <div class="row">
                <div class="form-group col-10">
                  <label for="nome_produtos">Senha:</label>
                  <div class="input-group">
                    <input type="password" id="deletar_senha" name="deletar_senha" class="form-control" required>
                  </div>
                </div>
              </div>
            </div>
            <div class="modal-footer justify-content-between">
              <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
              <button type="submit" class="btn btn-danger">Deletar</button>
            </div>
            </form>
          </div>
          <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
      </div>
      <!-- /.modal -->
      <div class="modal fade" id="alterar_senha">
        <div class="modal-dialog modal-lg">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title">Confirme sua senha</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
            <form name="alterar_senha" action="{{ route('password.update') }}" enctype="multipart/form-data" >
              @csrf
              <div class="row">
                <div class="form-group col-10">
                  <label for="nome_produtos">Senha atual:</label>
                  <div class="input-group">
                    <input type="password" id="senha_atual" name="senha_atual" class="form-control" required >
                  </div>
                </div>
                <div class="form-group col-10">
                  <label for="nome_produtos">Nova senha:</label>
                  <div class="input-group">
                    <input type="password" id="nova_senha" name="nova_senha" class="form-control" required>
                  </div>
                </div>
                <div class="form-group col-10">
                  <label for="nome_produtos">Confirmar senha:</label>
                  <div class="input-group">
                    <input type="password" id="confimar_senha" name="confimar_senha" class="form-control" required>
                  </div>
                </div>
              </div>
            </div>
            <div class="modal-footer justify-content-between">
              <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
              <button type="submit" class="btn btn-primary">Alterar</button>
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

<script>
$(function(){
  $('Form[name="form_altera_conta"]').submit(function(event){
    event.preventDefault();
    $.ajax({
      url:"{{env('APP_URL')}}/altera_conta",
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

function deletarConta(){
  Swal.fire({
  title: 'Deseja realmente deletar sua conta?',
  showDenyButton: true,
  denyButtonText: `Deletar`,
  confirmButtonText: 'Cancelar',
  }).then((result) => {
    if (result.isConfirmed) {
     
    } else if (result.isDenied) {
      $("#deletar_conta").modal();
    }
  });
}

$(function(){
  $('Form[name="alterar_senha"]').submit(function(event){
    event.preventDefault();
    senha_atual=document.getElementById("senha_atual").value;
    nova_senha=document.getElementById("nova_senha").value;
    confimar_senha=document.getElementById("confimar_senha").value;
    if(senha_atual!='' && nova_senha!='' && confimar_senha!='' && confimar_senha===nova_senha){
      $.ajax({
        url:"{{env('APP_URL')}}/alterar_senha",
        type: 'post',
        data: $(this).serialize(),
        dataType: 'json',
        success: function(response){
              if(response.status){
                alert('Senha alterada com sucesso!');
                document.location.reload(true);
              }else{
                alert(response.message);
              }
          }
      });
    }
  });
});
function alterarSenha(){
  $("#alterar_senha").modal();
}
$(function(){
  $('Form[name="del_conta_usuario"]').submit(function(event){
    event.preventDefault();
    deletar_senha=document.getElementById("deletar_senha").value;
    if(deletar_senha!='' ){
      $.ajax({
        url:"{{env('APP_URL')}}/del_conta_usuario",
        type: 'post',
        data: $(this).serialize(),
        dataType: 'json',
        success: function(response){
              if(response.status){
                alert('Conta deletada com sucesso!');
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

