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
            <h1>Nova medição</h1>
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
                <button type="button" class="btn btn-success" onclick="salvarMedicao()">
                  Salvar <i class="fa fa-plus"></i>
                </button>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <form id="formNovaMedicao" method="POST" name="formNovaMedicao" action="">
                <table id="tabela1" class="table table-bordered table-striped">
                    <thead>
                    <tr>
                        <th>Contrato</th>
                        <th>Cliente</th>
                        <th>Valor</th>
                        <th>Ano/Mês</th>
                        <th>Vencimento</th>
                        <th>Produto</th>
                        <th>Notificação<i class="fas fa-question-circle" data-toggle="tooltip" title="Escolha quando deseja enviar um alerta sobre o vencimento para o cliente."></i></th>
                        <th>Ações</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    function obterPrimeiroDiaUtil(\DateTime $data){
                        while ($data->format('N') >= 6) { // 6 = Sábado, 7 = Domingo
                            $data->modify('+1 day');
                        }
                        return $data;
                    }
                    function obterQuintoDiaUtil(\DateTime $data){
                        $contador = 0;
                        while($contador < 5) {
                            if($data->format('N') < 6){ // 6 = Sábado, 7 = Domingo
                                $contador++;
                            }
                            if($contador < 5){
                                $data->modify('+1 day');
                            }
                        }
                        return $data;
                    }
                    ?>

                    @foreach($contratos as $item)
                    <?php
                    if(empty($item->ano_mes_referencia)){
                        $ano_mes_referencia = date('Y-m');
                    }else{
                        $ano_mes_referencia = $item->ano_mes_referencia;
                    }

                    $ano = substr($ano_mes_referencia, 0, 4);
                    $mes = substr($ano_mes_referencia, 5, 2);
                    $primeiro_dia = new \DateTime("{$ano}-{$mes}-01");
                    $ultimo_dia = (new \DateTime("{$ano}-{$mes}-01"))->format('t');


                    // Determina o dia de vencimento
                    if ($item->data_pagamento == 32) {
                        $data_vencimento = obterPrimeiroDiaUtil($primeiro_dia)->format('Y-m-d');
                    } elseif ($item->data_pagamento == 33) {
                        $quinto_dia_util = obterQuintoDiaUtil(clone $primeiro_dia)->format('Y-m-d');
                        $data_vencimento = $quinto_dia_util;
                    } else {
                        $dia = min($item->data_pagamento, $ultimo_dia);
                        $data_vencimento = new \DateTime("{$ano}-{$mes}-{$dia}");
                        $data_vencimento = $data_vencimento->format('Y-m-d');
                    }

                    ?>
                    <tr>
                        <td>{{ $item->numero_contrato }}</td>
                        <td>{{ $item->cliente }}</td>
                        <td>
                            <input type="text" name="valor_{{ $item->id_contrato }}" class="form-control dinheiro" value="{{$item->valor}}" />
                        </td>
                        <td>
                            <input type="month" name="ano_mes_referencia_{{ $item->id_contrato }}" class="form-control" value="{{ $ano_mes_referencia }}" />
                        </td>
                        <td>
                            <input type="date" name="data_vencimento_{{ $item->id_contrato }}" class="form-control" value="{{ $data_vencimento }}" />
                        </td>
                        <td>{{ $item->produto }}</td>
                        <td><select name="alerta_vencimento_{{ $item->id_contrato }}" class="form-control">
                          <option value="0">Não</option>
                          <option value="1">3 dias antes</option>
                          <option value="2">Dia do vencimento</option>
                          <option value="3">1 dia após</option>
                          <option value="4">2 dias após</option>
                          <option value="5">3 dias após</option>
                          <option value="6">5 dias após</option>
                      </select>
                      </td>
                        <td>
                            <input type="checkbox" name="selecionado[]" value="{{ $item->id_contrato }}" checked />
                        </td>
                    </tr>

                    @endforeach

                    </tbody>
                </table>
                </form>
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

$('.dinheiro').mask('#.##0,00', {reverse: true});
function salvarMedicao(){
    var form = document.getElementById('formNovaMedicao');

    if (!form) {
        console.error('Formulário não encontrado.');
        return;
    }

    var checkboxes = form.querySelectorAll('input[name="selecionado[]"]:checked');
    var dados = [];
    let formValido = false;

    checkboxes.forEach(function(checkbox) {
        formValido = true;
        var id = checkbox.value;
        var valor = form.querySelector('input[name="valor_' + id + '"]').value;
        var ano_mes_referencia = form.querySelector('input[name="ano_mes_referencia_' + id + '"]').value;
        var data_vencimento = form.querySelector('input[name="data_vencimento_' + id + '"]').value;
        var notificacao = form.querySelector('select[name="alerta_vencimento_' + id + '"]').value;

        dados.push({
            id: id,
            valor: valor,
            ano_mes_referencia: ano_mes_referencia,
            notificacao: notificacao,
            data_vencimento: data_vencimento
        });
    });
    if(formValido){
        $.ajax({
            url:"{{env('APP_URL')}}/salvar_medicao",
            type: 'POST',
            data: {
                _token: '{{ csrf_token() }}',
                medicoes: dados
            },
            success: function(response) {
                if(response.status){
                    window.location.href = '{{env('APP_URL')}}/medicao';
                }
            },
            error: function(xhr, status, error) {
                console.error(error);
            }
        });
    }

}
</script>
@endsection

