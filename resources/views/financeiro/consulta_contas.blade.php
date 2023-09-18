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
            <h1>
              <?php
                if($tipo=='1'){
                  echo "Consulta Contas a receber";
                }else if($tipo=='2'){
                  echo "Consulta Contas a pagar";
                }else if($tipo=='3'){
                  echo "Fluxo de caixa";
                }
              ?>

            </h1>
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
                <form name="form_addasdas" method="post" enctype="multipart/form-data" action="{{env('APP_URL')}}/financeiro/<?php if($tipo=='1'){ echo 'consulta_contas_receber'; }else if($tipo=='2'){echo 'consulta_contas_pagar';}else if($tipo=='3'){echo 'consulta_fluxo_caixa';}     ?>">
                  @csrf 
                  <div class="row">
                    <div class="form-group col-md-4 col-12">
                      <label for="centro_custos_consulta_contas">Centro de custo:</label>
                      <select id="centro_custos_consulta_contas" multiple name="centro_custos_consulta_contas[]"class="form-control select2bs4 centro_custos_consulta_contas" >
                      <option value=""></option>
                        @foreach($centro_custo as $item)
                          <option value='{{$item->id_centro_custo}}'>{{$item->nome}}</option>
                        @endforeach
                      </select>
                    </div>
                    <div class="form-group col-md-4 col-12">
                      <label for="for_cli_consulta_contas">Cliente - Fornecedor:</label>
                      <select id="for_cli_consulta_contas" multiple  name="for_cli_consulta_contas[]"class="form-control select2bs4 for_cli_consulta_contas" >
                      <option value=""></option>
                      @foreach($for_cli as $item)
                            <option value='{{$item->id_for_cli}}'>{{$item->nome}}</option>
                        @endforeach
                      </select>
                    </div>
                    <div class="form-group col-md-4 col-12">
                      <label for="produto_consulta_contas">Produto:</label>
                      <select id="produto_consulta_contas" multiple  name="produto_consulta_contas[]"class="form-control select2bs4 produto_consulta_contas" >
                      <option value=""></option>
                        @foreach($produtos as $item)
                          <option value='{{$item->id_produto}}'>{{$item->nome}}</option>
                        @endforeach
                      </select>
                    </div>
                    <?php if($tipo!='3'){ ?>
                    <div class="form-group col-md-4 col-12">
                      <label for="pag_consulta_contas">Forma de pagamento:</label>
                      <select id="pag_consulta_contas"  multiple name="pag_consulta_contas[]"class="form-control select2bs4 pag_consulta_contas" >
                      <option value='0'>À vista</option>
                      @foreach($cartao as $item)
                            <option value='{{$item->id_pag}}'>{{$item->nome}}</option>
                        @endforeach
                      </select>
                    </div>
                    <div class="form-group col-md-4 col-12">
                      <label for="status_consulta_contas">Status:</label>
                      <select id="status_consulta_contas"  multiple name="status_consulta_contas[]"class="form-control select2bs4 status_consulta_contas" >
                      <option value=""></option>
                      @foreach($status as $item)
                            <option value='{{$item->id_status}}'>{{$item->nome}}</option>
                        @endforeach
                      </select>
                    </div>
                    <?php } ?>
                    <div class="form-group col-md-2 col-12">
                      <label for="data_inicio_consulta_contas">Data início:</label>
                      <div class="input-group">
                        <input type="date" id="data_inicio_consulta_contas" name="data_inicio_consulta_contas" class="form-control" >
                      </div>
                    </div>
                    <div class="form-group col-md-2 col-12">
                      <label for="data_fim_consulta_contas">Data fim:</label>
                      <div class="input-group">
                        <input type="date" id="data_fim_consulta_contas" name="data_fim_consulta_contas" class="form-control" >
                      </div>
                    </div>
                  </div>
                  <button type="submit" class="btn btn-primary">Consultar</button>
                </form>
              </div>
              <!-- /.card-header -->

              <div class="card-body"><!-- STACKED BAR CHART -->
                <?php if($tipo=='3'){ ?>
                <div class="card card-primary">
                  <div class="card-header">
                    <h3 class="card-title">Gráfico</h3>

                    <div class="card-tools">
                      <button type="button" class="btn btn-tool" data-card-widget="collapse">
                        <i class="fas fa-minus"></i>
                      </button>
                    </div>
                  </div>
                  <div class="card-body">
                    <div class="chart">
                      <canvas id="stackedBarChart" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
                    </div>
                  </div>
                  <!-- /.card-body -->
                </div>
                <!-- /.card -->

                <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">Saldo mês a mês</h3>
                  </div>
                  <div class="card-body ">
                    <div class="table-responsive">
                    <table class="table table-bordered table-striped">
                      <thead>
                      <tr>
                        <?php
                          $mes_extenso = array(
                            '1' => 'Janeiro',
                            '2' => 'Fevereiro',
                            '3' => 'Marco',
                            '4' => 'Abril',
                            '5' => 'Maio',
                            '6' => 'Junho',
                            '7' => 'Julho',
                            '8' => 'Agosto',
                            '9' => 'Setembro',
                            '10' => 'Outubro',
                            '11' => 'Novembro',
                            '12' => 'Dezembro'
                          );
                          foreach($grafico as $item){
                            //$entrada.=str_replace(',','',$item->entrada) .",";
                            //$saida.="-".str_replace(',','',$item->saida).",";
                            echo "<th>".$mes_extenso[$item->mes]."</th>";
                          }
                      ?>
                      </tr>
                      </thead>
                      <tbody>
                      <tr>
                      <?php
                          foreach($grafico as $item){
                            $entrada=str_replace(',','',$item->entrada);
                            $saida=str_replace(',','',$item->saida);
                            $saldo_mes_mes= $entrada-$saida;
                            echo "<th>R$ ".number_format($saldo_mes_mes, 2, ',', '.')."</th>";
                          }
                      ?>
                      </tr>
                      </tbody>
                    </table>
                    </div>
                  </div>
                  <!-- /.card-body -->
                </div>
                <!-- /.card -->

                <?php } ?>
                <table id="tabela1" class="table table-bordered table-striped">
                  <thead>
                  <tr>
                    <th>Valor</th>
                    <th>C. de custo</th>
                    <th>Forn. - Cliente</th>
                    <th>Produto</th>
                    <?php if($tipo!='3'){ ?><th>Form. Pagamento</th><th>Status</th><?php } ?>
                    <th>Vencimento</th>
                    <th>Descrição</th>
                    <th>Ações</th>
                  </tr>
                  </thead>
                  <tbody>
                  <?php
                     $total=0;
                     $sinal='';
                  ?>
                  @foreach($lancamentos as $item)
                      <tr>
                        <?php
                          $date = date_create($item->data_vencimento);
                          if($item->tipo==1){
                            $total+=$item->valor;
                            $sinal=' ';
                          }else{
                            $total-=$item->valor;
                            $sinal='-';
                          }
                          
                        ?>
                        <td data-value="{{str_replace('.',',',$item->valor)}}" id="valor_{{$item->id_lancamento}}">R$ {{$sinal}}{{number_format($item->valor, 2, ',', '')}}</td>
                        <td data-value="{{$item->id_centro_custo}}" id="centro_custos_{{$item->id_lancamento}}">{{$item->centro_custos}}</td>
                        <td data-value="{{$item->id_for_cli}}" id="for_cli_{{$item->id_lancamento}}">{{$item->for_cli}}</td>
                        <td data-value="{{$item->id_produto}}"id="produto_{{$item->id_lancamento}}">{{$item->produto}}</td>
                        <?php if($tipo!='3'){ ?><td>{{$item->nome == '' ? 'À vista' : $item->nome;}}</td><td data-value="{{$item->id_status}}" id="status_{{$item->id_lancamento}}">{{$item->status}}</td><?php } ?>
                        <td data-value="{{$item->data_vencimento}}" id="data_vencimento_{{$item->id_lancamento}}">{{date_format($date, 'd/m/Y')}}</td>
                        <td data-value="{{$item->descricao}}" id="descricao_{{$item->id_lancamento}}">{{$item->descricao}}</td>
                        <td>
                          <button type="button" onClick="editar({{$item->id_lancamento}})" class="btn btn-primary"><i class="fa fa-pen"></i></button>
                          <button type="button" onClick="deletar({{$item->id_lancamento}})" class="btn btn-danger"><i class="fa fa-trash"></i></button>
                        </td>
                      </tr>
                    @endforeach
                  </tbody>
                  <tfoot>
                  <tr>
                    <th>Total</th>
                    <th>R$ {{number_format($total, 2, ',', '.')}}</th>
                    <th colspan="<?php if($tipo!='3'){ echo '7';}else{echo '5';} ?>"></th>
                  </tr>
                  </tfoot>
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
              <h4 class="modal-title">Adicionar 
              <?php
                if($tipo=='1'){
                  echo "Contas a Receber";
                }else{
                  echo "Contas a Pagar";
                }
              ?></h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
            <form name="form_add" enctype="multipart/form-data" >
              @csrf
              <input type="hidden" id="id_contas" name="id_contas" class="form-control" >
              <input type="hidden" id="tipo_contas" name="tipo_contas" value="{{$tipo}}" class="form-control" >
              <div class="row">
                <div class="form-group col-md-3 col-12">
                  <label for="valor_contas">Valor:</label>
                  <div class="input-group">
                    <input type="text" id="valor_contas" name="valor_contas" class="valor form-control" style="display:inline-block">
                  </div>
                </div>
                <div class="form-group col-md-4 col-12">
                  <label for="centro_custos_contas">Centro de custo:</label>
                  <select id="centro_custos_contas" name="centro_custos_contas"class="form-control select2bs4" style="width: 100%;">
                  <option value=""></option>
                    @foreach($centro_custo as $item)
                      <option value='{{$item->id_centro_custo}}'>{{$item->nome}}</option>
                    @endforeach
                  </select>
                </div>
                <div class="form-group col-md-4 col-12">
                  <label for="for_cli_contas">Cliente - Fornecedor:</label>
                  <select id="for_cli_contas" name="for_cli_contas"class="form-control select2bs4" style="width: 100%;">
                  <option value=""></option>
                  @foreach($for_cli as $item)
                        <option value='{{$item->id_for_cli}}'>{{$item->nome}}</option>
                    @endforeach
                  </select>
                </div>
                <div class="form-group col-md-4 col-12">
                  <label for="status_contas">Status:</label>
                  <select id="status_contas" name="status_contas"class="form-control select2bs4" style="width: 100%;">
                  <option value=""></option>
                  @foreach($status as $item)
                        <option value='{{$item->id_status}}'>{{$item->nome}}</option>
                    @endforeach
                  </select>
                </div>
                <div class="form-group col-md-4 col-12">
                  <label for="produto_contas">Produto:</label>
                  <select id="produto_contas" name="produto_contas"class="form-control select2bs4" style="width: 100%;">
                  <option value=""></option>
                    @foreach($produtos as $item)
                      <option value='{{$item->id_produto}}'>{{$item->nome}}</option>
                    @endforeach
                  </select>
                </div>
                <div class="form-group col-md-3 col-12">
                  <label for="data_vencimento_contas">Data vencimento:</label>
                  <div class="input-group">
                    <input type="date" id="data_vencimento_contas" name="data_vencimento_contas" class="form-control" >
                  </div>
                </div>
                <div class="form-group col-md-4 col-12" id="divRepeticao">
                  <label for="repeticao_contas">Repetir:</label>
                  <select onChange="displayQut()" id="repeticao_contas" name="repeticao_contas"class="form-control select2bs4" style="width: 100%;">
                      <option value='0'>Não</option>
                      <option value='1'>Diariamente</option>
                      <option value='2'>Semanalmente</option>
                      <option value='3'>Quinzenalmente</option>
                      <option value='4'>Mensalmente</option>
                      <option value='5'>Anualmente</option>
                  </select>
                </div>
                <div class="form-group col-md-4 col-12" id="divQut" style="display: none;">
                  <label for="qut_contas">Quantidade de repetições:</label>
                  <div class="input-group">
                    <input type="number" value='1' min='1' id="qut_contas" name="qut_contas" class="form-control" >
                  </div>
                </div>
                <div class="form-group col-12">
                  <label for="descricao_contas">Descrição:</label>
                  <div class="input-group">
                    <input type="text" id="descricao_contas" name="descricao_contas" class="form-control" >
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
@include('auxiliares.funcoesTabela');
<!-- ChartJS -->
<script src="{{env('APP_URL')}}/plugins/chart.js/Chart.min.js"></script>
<script>

 $(function(){
  $('Form[name="form_add"]').submit(function(event){
    event.preventDefault();
    verifica=true;

    var produto = document.getElementById("produto_contas");
    var valor = document.getElementById("valor_contas");
    var status = document.getElementById("status_contas");
    var centro_custos = document.getElementById("centro_custos_contas");
    var for_cli = document.getElementById("for_cli_contas");
    var data_vencimento = document.getElementById("data_vencimento_contas");
    var repeticao = document.getElementById("repeticao_contas");
    var qut = document.getElementById("qut_contas");
    if(produto.value==''){
      produto.classList.add("is-invalid");
      verifica=false;
    }else{
      produto.classList.remove("is-invalid");
    }
    if(data_vencimento.value==''){
      data_vencimento.classList.add("is-invalid");
      verifica=false;
    }else{
      data_vencimento.classList.remove("is-invalid");
    }
    if(for_cli.value==''){
      for_cli.classList.add("is-invalid");
      verifica=false;
    }else{
      for_cli.classList.remove("is-invalid");
    }
    if(centro_custos.value==''){
      centro_custos.classList.add("is-invalid");
      verifica=false;
    }else{
      centro_custos.classList.remove("is-invalid");
    }
    if(status.value==''){
      status.classList.add("is-invalid");
      verifica=false;
    }else{
      status.classList.remove("is-invalid");
    }
    if(valor.value==''){
      valor.classList.add("is-invalid");
      verifica=false;
    }else{
      valor.classList.remove("is-invalid");
    }
    if(repeticao.value>0 && qut.value<=0){
      qut.classList.add("is-invalid");
      verifica=false;
    }else{
      qut.classList.remove("is-invalid");
    }

    if(verifica){
      $.ajax({
        url:"{{env('APP_URL')}}/add_conta",
        type: 'post',
        data: $(this).serialize(),
        dataType: 'json',
        success: function(response){
              if(response.status){
                  //console.log(response.status);
                document.location.reload(true);
              }else{
                alert(response.message);
              }
          }
      });
    }
  });
});

$('.valor').mask('#.##0,00', {reverse: true});
$('.telefone').mask('(00) 0 0000-0000');

function novo(){
  document.getElementById("id_contas").value='';
  document.getElementById("produto_contas").value='';
  document.getElementById("status_contas").value='';
  document.getElementById("centro_custos_contas").value='';
  document.getElementById("for_cli_contas").value='';
  document.getElementById("data_vencimento_contas").value='';
  document.getElementById("valor_contas").value='';
  document.getElementById("descricao_contas").value='';
  document.getElementById("repeticao_contas").value=0;
  document.getElementById("qut_contas").value=1;
  document.getElementById("divQut").style.display = "none";
  $("#novo").modal()
}

function editar(id){
  let element = document.getElementById("status_"+id);
  if (element) {
    $('#status_contas').val(document.getElementById("status_"+id).getAttribute('data-value')); 
    $('#status_contas').trigger('change');
  }else{
    $('#status_contas').val(1); 
    $('#status_contas').trigger('change');
  }
  $('#produto_contas').val(document.getElementById("produto_"+id).getAttribute('data-value')); 
  $('#produto_contas').trigger('change');
  $('#for_cli_contas').val(document.getElementById("for_cli_"+id).getAttribute('data-value')); 
  $('#for_cli_contas').trigger('change');
  $('#centro_custos_contas').val(document.getElementById("centro_custos_"+id).getAttribute('data-value')); 
  $('#centro_custos_contas').trigger('change');

  document.getElementById("id_contas").value=id;
  document.getElementById("data_vencimento_contas").value=document.getElementById("data_vencimento_"+id).getAttribute('data-value');
  document.getElementById("valor_contas").value=document.getElementById("valor_"+id).getAttribute('data-value');
  document.getElementById("descricao_contas").value=document.getElementById("descricao_"+id).getAttribute('data-value');
  document.getElementById("repeticao_contas").value=0;
  document.getElementById("qut_contas").value=1;
  document.getElementById("divQut").style.display = "none";
  document.getElementById("divRepeticao").style.display = "none";
  $('.valor').mask('#.##0,00', {reverse: true});
  $("#novo").modal()
}

function displayQut(){
  repeticao=document.getElementById("repeticao_contas").value;
  if(repeticao==0){
    document.getElementById("divQut").style.display = "none";
  }else{
    document.getElementById("divQut").style.display = "block";
  }
}

function deletar(id){
  produto=document.getElementById ( "produto_"+id ).innerText;
  valor=document.getElementById ( "valor_"+id ).innerText;
  Swal.fire({
  title: 'Deseja realmente deletar o lançamento do produto ' +produto+' de valor R$ '+valor+' ?',
  showDenyButton: true,
  denyButtonText: `Deletar`,
  confirmButtonText: 'Cancelar',
  }).then((result) => {
    if (result.isConfirmed) {
     
    } else if (result.isDenied) {
      $.ajax({
        url:"{{env('APP_URL')}}/del_conta",
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        type: 'post',
        data: {'id_contas' : id},
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
<?php
  foreach($array_input as $key => $array_value){
    foreach($array_value as $item){
      echo "$('.".$key."_consulta_contas option[value=$item]').attr('selected','selected');";
    }
    
  }
  foreach($array_data as $key => $array_value){
    if($array_value)
      echo "document.getElementById('data_".$key."_consulta_contas').value='$array_value';";
  }

  if($tipo=='3'){ 
    $mes='';
    $entrada='';
    $saida='';
    $mes_extenso = array(
      '1' => 'Janeiro',
      '2' => 'Fevereiro',
      '3' => 'Marco',
      '4' => 'Abril',
      '5' => 'Maio',
      '6' => 'Junho',
      '7' => 'Julho',
      '8' => 'Agosto',
      '9' => 'Setembro',
      '10' => 'Outubro',
      '11' => 'Novembro',
      '12' => 'Dezembro'
    );
    foreach($grafico as $item){
      $mes.="'".$mes_extenso[$item->mes]."',";
      $entrada.=str_replace(',','',$item->entrada) .",";
      $saida.="-".str_replace(',','',$item->saida).",";
    }

?>

$(function () {
  var areaChartData = {
      labels  : [<?php echo $mes; ?>],
      datasets: [
        {
          label               : 'Entrada',
          backgroundColor     : 'rgb(63, 103, 145, 1)',
          borderColor         : 'rgb(63, 103, 145, 0.8)',
          pointRadius          : false,
          pointColor          : '#3b8bba',
          pointStrokeColor    : 'rgba(60,141,188,1)',
          pointHighlightFill  : '#fff',
          pointHighlightStroke: 'rgba(60,141,188,1)',
          data                : [<?php echo $entrada; ?>]
        },
        {
          label               : 'Saída',
          backgroundColor     : 'rgb(231, 76, 60, 1)',
          borderColor         : 'rgb(231, 76, 60, 0.8)',
          pointRadius         : false,
          pointColor          : 'rgba(210, 214, 222, 1)',
          pointStrokeColor    : '#c1c7d1',
          pointHighlightFill  : '#fff',
          pointHighlightStroke: 'rgba(220,220,220,1)',
          data                : [<?php echo $saida; ?>]
        },
      ]
    }
  var barChartData = $.extend(true, {}, areaChartData)
  var temp0 = areaChartData.datasets[0];
  var temp1 = areaChartData.datasets[1];
    
  barChartData.datasets[0] = temp1;
  barChartData.datasets[1] = temp0;
  var stackedBarChartCanvas = $('#stackedBarChart').get(0).getContext('2d');
  var stackedBarChartData = $.extend(true, {}, barChartData);

  var stackedBarChartOptions = {
      responsive              : true,
      maintainAspectRatio     : false,
      scales: {
        xAxes: [{
          stacked: true,
        }],
        yAxes: [{
          stacked: true
        }]
      }
    }

  new Chart(stackedBarChartCanvas, {
      type: 'bar',
      data: stackedBarChartData,
      options: stackedBarChartOptions
    })
  })
<?php } ?>
</script>
@endsection