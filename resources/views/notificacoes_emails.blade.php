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
            <h1>Emails</h1>
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
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table id="tabela1" class="table table-bordered table-striped">
                    <thead>
                    <tr>
                        <th>Cliente</th>
                        <th>Assunto</th>
                        <th>Para</th>
                        <th>Mensagem</th>
                        <th>Data Envio</th>
                        <th>Status</th>
                        <th>Ações</th>
                    </tr>
                    </thead>
                    <tbody>
                        @foreach($emails as $email)
                        <tr>
                            <td>{{ $email->cliente_nome }}</td>
                            <td>{{ $email->assunto }}</td>
                            <td>{{ $email->para }}</td>
                            <td>
                                {{ Str::limit($email->mensagem, 10) }}...
                                <a href="#" onclick="showMessage({{ $email->id_notificacao}})">Ver mais</a>
                            </td>
                            <td>{{ \Carbon\Carbon::parse($email->data_envio)->format('d/m/Y') }}</td>
                            <td>{{ $email->enviado ? 'Enviado' : 'Não enviado' }}</td>

                            <td></td>
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
<!-- Modal -->
<div class="modal fade" id="messageModal" tabindex="-1" role="dialog" aria-labelledby="messageModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="messageModalLabel">Mensagem Completa</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="messageContent">
                <!-- A mensagem completa será inserida aqui -->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
            </div>
        </div>
    </div>
</div>

@endsection

@section('scripts')
@include('auxiliares.funcoesTabela');
<script>
    function showMessage(id) {
        $.ajax({
            url: "{{env('APP_URL')}}/getmensagem/" + id,
            method: 'GET',
            success: function(response) {
                document.getElementById('messageContent').innerHTML = response.mensagem;
                console.log(response.mensagem);
                $('#messageModal').modal('show');
            },
            error: function() {
                alert('Erro ao carregar a mensagem.');
            }
        });
    }
</script>
@endsection

