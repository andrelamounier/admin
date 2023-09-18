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
            <h1>Consulta por Centro de custo</h1>
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
              <form name="form_addasdas" method="post" enctype="multipart/form-data" action="{{env('APP_URL')}}/financeiro/consulta_centro_custo">
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
                <div class="form-group col-md-4 col-12">
                  <label for="status_consulta_contas">Status:</label>
                  <select id="status_consulta_contas"  multiple name="status_consulta_contas[]"class="form-control select2bs4 status_consulta_contas" >
                  <option value=""></option>
                  @foreach($status as $item)
                        <option value='{{$item->id_status}}'>{{$item->nome}}</option>
                    @endforeach
                  </select>
                </div>
                <div class="form-group col-md-3 col-12">
                  <label for="data_inicio_consulta_contas">Data início:</label>
                  <div class="input-group">
                    <input type="date" id="data_inicio_consulta_contas" name="data_inicio_consulta_contas" class="form-control" >
                  </div>
                </div>
                <div class="form-group col-md-3 col-12">
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
              <div class="card-body">
                <table id="tabela1" class="table table-bordered table-striped">
                  <thead>
                  <tr>
                    <th>Centro de custo</th>
                    <th>Entrada</th>
                    <th>Saída</th>
                    <th>Saldo</th>
                  </tr>
                  </thead>
                  <tbody>
                  <?php
                     $total=0;
                     $entrada=0;
                     $saida=0;
                  ?>
                  @foreach($lancamentos as $item)
                      <tr>
                        <?php
                          $total=$total+$item->saldo-$item->debito;
                          $saldo=$item->saldo-$item->debito;
                          $entrada+=$item->saldo;
                          $saida+=$item->debito;
                        ?>
                        <td>{{$item->descricao}}</td>
                        <td>R$ {{number_format($item->saldo, 2, ',', '')}}</td>
                        <td>R$ <?php echo $item->debito >0 ? '-' : ''?> {{number_format($item->debito, 2, ',', '')}}</td>
                        <td>R$ {{number_format($saldo, 2, ',', '')}}</td>
                      </tr>
                    @endforeach
                  </tbody>
                  <tfoot>
                    <tr>
                      <th>Total</th>
                      <th>R$ {{number_format($entrada, 2, ',', '.')}}</th>
                      <th>R$ <?php echo $saida >0 ? '-' : ''?>{{number_format($saida, 2, ',', '.')}}</th>
                      <th>R$ {{number_format($total, 2, ',', '.')}}</th>
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




@endsection



@section('scripts')
@include('auxiliares.funcoesTabela');
<script>
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
?>
</script>
@endsection

