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
                  echo "Contas a receber";
                }else{
                  echo "Contas a pagar";
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
                <button type="button" class="btn btn-success" onClick="novo()">
                  Adicionar <i class="fa fa-plus"></i>
                </button>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table id="example1" class="table table-bordered table-striped">
                  <thead>
                  <tr>
                    <th>Valor</th>
                    <th>C. de custo</th>
                    <th>Forn. - Cliente</th>
                    <th>Produto</th>
                    <th>Form. Pagamento</th>
                    <th>Status</th>
                    <th>Vencimento</th>
                    <th>Descrição</th>
                    <th>Ações</th>
                  </tr>
                  </thead>
                  <tbody>
                  <?php
                     $total=0;
                  ?> 
                  @foreach($lancamentos as $item)
                      <tr>
                        <?php
                          $date = date_create($item->data_vencimento);
                          $total+= ($item->id_status == '1') ? $item->valor:0;
                        ?>
                        <td data-value="{{str_replace('.',',',$item->valor)}}" id="valor_{{$item->id_lancamento}}">R$ {{number_format($item->valor, 2, ',', '')}}</td>
                        <td data-value="{{$item->id_centro_custo}}" id="centro_custos_{{$item->id_lancamento}}">{{$item->centro_custos}}</td>
                        <td data-value="{{$item->id_for_cli}}" id="for_cli_{{$item->id_lancamento}}">{{$item->for_cli}}</td>
                        <td data-value="{{$item->id_produto}}"id="produto_{{$item->id_lancamento}}">{{$item->produto}}</td>
                        <td>{{$item->nome == '' ? 'À vista' : $item->nome;}}</td>
                        <td data-value="{{$item->id_status}}" id="status_{{$item->id_lancamento}}">{{$item->status}}</td>
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
                    <th colspan="7"></th>
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
              <h4 class="modal-title">Adicionar Contas a {{ $tipo == '1' ? 'Receber' : 'Pagar' }}</h4>
              
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              
            <form name="form_add" enctype="multipart/form-data">
              @csrf
              <input type="hidden" id="id_contas" name="id_contas" class="form-control" >
              <input type="hidden" id="tipo_contas" name="tipo_contas" value="{{$tipo}}" class="form-control" >
              <div class="row">
              <div class="form-group col-md-3 col-12">
                  <label for="pag_contas">Forma de pagamento:</label>
                  <select onChange="displayPag()" id="pag_contas" name="pag_contas"class="form-control select2bs4" style="width: 100%;">
                      <option value='0'>À vista</option>
                      @foreach($cartao as $item)
                        <option value='{{$item->id_pag}}'>{{$item->nome}}</option>
                      @endforeach
                  </select>
                </div>
                <div class="form-group col-md-3 col-12">
                  <label for="valor_contas">Valor:</label>
                  <div class="input-group">
                    <input type="text" id="valor_contas" name="valor_contas" class="valor form-control " style="display:inline-block">
                  </div>
                </div>
                <div class="form-group col-md-2 col-12">
                  <label for="status_contas">Status:</label>
                  <select id="status_contas" name="status_contas"class="form-control select2bs4" style="width: 100%;">
                  <option value=""></option>
                    @foreach($status as $item)
                        <option value='{{$item->id_status}}'>{{$item->nome}}</option>
                    @endforeach
                  </select>
                </div>
                <div class="form-group col-md-4 col-12">
                  <label for="centro_custos_contas">Centro de custo: 
                      <button type="button" onClick="addCC()" class="btn btn-primary btn-sm" title="Adicionar">
                        <i class="fas fa-plus"></i>
                      </button></label>
                  <select id="centro_custos_contas" name="centro_custos_contas"class="form-control select2bs4" style="width: 100%;">
                  <option value=""></option>
                    @foreach($centro_custo as $item)
                      <option value='{{$item->id_centro_custo}}'>{{$item->nome}}</option>
                    @endforeach
                  </select>
                </div>
                <div class="form-group col-md-4 col-12">
                  <label for="for_cli_contas">Cliente - Fornecedor:
                      <button type="button" onClick="addCF()" class="btn btn-primary btn-sm" title="Adicionar">
                        <i class="fas fa-plus"></i>
                      </button></label>
                  </label>
                  <select id="for_cli_contas" name="for_cli_contas"class="form-control select2bs4" style="width: 100%;">
                  <option value=""></option>
                  @foreach($for_cli as $item)
                        <option value='{{$item->id_for_cli}}'>{{$item->nome}}</option>
                    @endforeach
                  </select>
                </div>
                <div class="form-group col-md-4 col-12">
                  <label for="produto_contas">Produto:
                      <button type="button" onClick="addProd()" class="btn btn-primary btn-sm" title="Adicionar">
                        <i class="fas fa-plus"></i>
                      </button></label>
                  </label>
                  <select id="produto_contas" name="produto_contas"class="form-control select2bs4" style="width: 100%;">
                  <option value=""></option>
                    @foreach($produtos as $item)
                      <option value='{{$item->id_produto}}'>{{$item->nome}}</option>
                    @endforeach
                  </select>
                </div>
                <div class="form-group col-md-4 col-12">
                  <label for="data_vencimento_contas">Data vencimento:</label>
                  <div class="input-group">
                    <input type="date" id="data_vencimento_contas"  name="data_vencimento_contas" class="form-control" >
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
                  </select>
                </div>
                <div class="form-group col-md-4 col-12" id="divQut" style="display: none;">
                  <label for="qut_contas">Quantidade de repetições:</label>
                  <div class="input-group">
                    <input type="number" value='1' min='1' id="qut_contas" name="qut_contas" class="form-control" >
                  </div>
                </div>
                <div class="form-group col-md-4 col-12" id="divQut_cartao" style="display: none;">
                  <label for="qut_contas_cartao">Parcelas:</label>
                  <div class="input-group">
                    <input type="number" value='1' min='1' id="qut_contas_cartao" name="qut_contas_cartao" class="form-control" >
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
<!-- DataTables  & Plugins -->
<script src="{{env('APP_URL')}}/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="{{env('APP_URL')}}/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="{{env('APP_URL')}}/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="{{env('APP_URL')}}/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
<script src="{{env('APP_URL')}}/plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
<script src="{{env('APP_URL')}}/plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
<script src="{{env('APP_URL')}}/plugins/jszip/jszip.min.js"></script>
<script src="{{env('APP_URL')}}/plugins/pdfmake/pdfmake.min.js"></script>
<script src="{{env('APP_URL')}}/plugins/pdfmake/vfs_fonts.js"></script>
<script src="{{env('APP_URL')}}/plugins/datatables-buttons/js/buttons.html5.min.js"></script>
<script src="{{env('APP_URL')}}/plugins/datatables-buttons/js/buttons.print.min.js"></script>
<script src="{{env('APP_URL')}}/plugins/datatables-buttons/js/buttons.colVis.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.form/4.3.0/jquery.form.min.js"></script>
<script src="https://igorescobar.github.io/jQuery-Mask-Plugin/js/jquery.mask.min.js"></script>  
<script src="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.12.6/js/standalone/selectize.min.js"></script>


<script>

 $(document).ready(function() {
    $('#example1').DataTable( {
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
  $('#produto_contas').val(''); 
  $('#produto_contas').trigger('change');
  $('#status_contas').val(''); 
  $('#status_contas').trigger('change');
  $('#centro_custos_contas').val(''); 
  $('#centro_custos_contas').trigger('change');
  $('#for_cli_contas').val(''); 
  $('#for_cli_contas').trigger('change');
  $('#valor_contas').val(''); 
  $('#descricao_contas').val(''); 
  $('#repeticao_contas').val('0'); 
  $('#repeticao_contas').trigger('change');
  $('#pag_contas').val('0'); 
  $('#pag_contas').trigger('change');
  document.getElementById("qut_contas").value=1;
  document.getElementById("qut_contas_cartao").value=1;
  document.getElementById("divQut_cartao").style.display = "none";
  document.getElementById("divQut").style.display = "none";
  document.getElementById("divRepeticao").style.display = "block";
  var inputDate = document.getElementById('data_vencimento_contas');
  var dataAtual = new Date().toISOString().split('T')[0];
  inputDate.value = dataAtual;
  $("#novo").modal()
}


function editar(id){
  $('#status_contas').val(document.getElementById("status_"+id).getAttribute('data-value')); 
  $('#status_contas').trigger('change');
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

function addCC(){
  document.getElementById("id_centro_custo").value='';
  document.getElementById("nome_centro_custo").value='';
  $("#novo_centro_custo_modal").modal();
}
$(function(){
  $('Form[name="form_add_centro_custo"]').submit(function(event){
    event.preventDefault();
    $.ajax({
      url:"{{env('APP_URL')}}/add_custo",
      type: 'post',
      data: $(this).serialize(),
      dataType: 'json',
      success: function(response){
            if(response.status){
              atualizarCC();
            }else{
              alert(response.message);
            }
        }
    });
  });
});
function atualizarCC(){
    $.ajax({
        url:"{{env('APP_URL')}}/buscar_cc",
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        type: 'post',
        data: {'id_contas' : 'id'},
        dataType: 'json',
        success: function(response){
              if(response.status){
                $("#centro_custos_contas").html(response.options);
                $("#novo_centro_custo_modal").modal("hide");
              }else{
                alert(response.message);
              }
          }
      });
}


function addCF(){
  document.getElementById("id_for_cli").value='';
  document.getElementById("nome_for_cli").value='';
  document.getElementById("descricao_for_cli").value='';
  document.getElementById("email_for_cli").value='';
  document.getElementById("telefone_for_cli").value='';
  document.getElementById("rua_for_cli").value='';
  document.getElementById("cep_for_cli").value='';
  document.getElementById("cidade_for_cli").value='';
  document.getElementById("estado_for_cli").value='';
  document.getElementById("cpfcnpj_for_cli").value='';
  document.getElementById("numero_for_cli").value='';
  document.getElementById("bairro_for_cli").value='';
  document.getElementById("complemento_for_cli").value='';
  $("#novo_cliente_fornecedor_modal").modal()
}
$(function(){
  $('Form[name="form_add_cliente_fornecedor"]').submit(function(event){
    event.preventDefault();
    $.ajax({
      url:"{{env('APP_URL')}}/add_for_cli",
      type: 'post',
      data: $(this).serialize(),
      dataType: 'json',
      success: function(response){
            if(response.status){
              atualizarFC();
            }else{
              alert(response.message);
            }
        }
    });
  });
});
function atualizarFC(){
    $.ajax({
        url:"{{env('APP_URL')}}/buscar_fc",
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        type: 'post',
        data: {'id_contas' : 'id'},
        dataType: 'json',
        success: function(response){
              if(response.status){
                $("#for_cli_contas").html(response.options);
                $("#novo_cliente_fornecedor_modal").modal("hide");
              }else{
                alert(response.message);
              }
          }
      });
}

function addProd(){
  document.getElementById("id_produtos").value='';
  document.getElementById("nome_produtos").value='';
  document.getElementById("descricao_produtos").value='';
  $("#novo_produtos_modal").modal()
}
$(function(){
  $('Form[name="form_add_produtos"]').submit(function(event){
    event.preventDefault();
    $.ajax({
      url:"{{env('APP_URL')}}/add_produto",
      type: 'post',
      data: $(this).serialize(),
      dataType: 'json',
      success: function(response){
            if(response.status){
              atualizarProd();
            }else{
              alert(response.message);
            }
        }
    });
  });
});
function atualizarProd(){
    $.ajax({
        url:"{{env('APP_URL')}}/buscar_Prod",
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        type: 'post',
        data: {'id_contas' : 'id'},
        dataType: 'json',
        success: function(response){
              if(response.status){
                $("#produto_contas").html(response.options);
                $("#novo_produtos_modal").modal("hide");
              }else{
                alert(response.message);
              }
          }
      });
}

function displayPag(){
  pag=document.getElementById("pag_contas").value;
  if(pag==0){
    document.getElementById("divRepeticao").style.display = "block";
    $('#repeticao_contas').val('0'); 
    $('#repeticao_contas').trigger('change');
    document.getElementById("divQut").style.display = "none";
    document.getElementById("divQut_cartao").style.display = "none";
    document.querySelector('label[for="data_vencimento_contas"]').textContent = "Data vencimento:";
    document.querySelector('label[for="valor_contas"]').textContent = "Valor:";
  }else{
    document.getElementById("divRepeticao").style.display = "none";
    document.getElementById("divQut").style.display = "none";
    document.getElementById("divQut_cartao").style.display = "block";
    document.querySelector('label[for="data_vencimento_contas"]').textContent = "Data da compra:";
    document.querySelector('label[for="valor_contas"]').textContent = "Valor da parcela:";
  }
  
}
</script>
@endsection
