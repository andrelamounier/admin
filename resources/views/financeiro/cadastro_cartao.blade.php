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
            <h1>Catão</h1>
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
                <table id="tabela1" class="table table-bordered table-striped">
                  <thead>
                  <tr>
                    <th>Cartão</th>
                    <th>Fechamento</th>
                    <th>Vencimento</th>
                    <th>Status</th>
                    <th>Ações</th>
                  </tr>
                  </thead>
                  <tbody>
                    @foreach($cartao as $item)
                      <tr>
                        <td id="nome_{{$item->id_pag}}">{{$item->nome}}</td>
                        <td id="data_fecha_{{$item->id_pag}}">{{$item->data_fecha}}</td>
                        <td id="data_vence_{{$item->id_pag}}">{{$item->data_vence}}</td>
                        <td id="status_{{$item->id_pag}}">
                          @if($item->status=='1')
                            Ativo
                          @else
                            Desativado
                          @endif
                        </td>
                        <td>
                        <button type="button" onClick="editar({{$item->id_pag}})" class="btn btn-primary"><i class="fa fa-pen"></i></button>
                        </td>
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





@endsection

@section('scripts')
@include('auxiliares.funcoesTabela');
<script>

$(function(){
  $('Form[name="form_add_cartao"]').submit(function(event){
    event.preventDefault();
    verifica=true;
    var nome_cartao = document.getElementById("nome_cartao");
    var data_fechamento = document.getElementById("data_fechamento_cartao");
    var data_vencimento = document.getElementById("data_vencimento_cartao");
    if(nome_cartao.value==''){
      nome_cartao.classList.add("is-invalid");
      verifica=false;
    }else{
      nome_cartao.classList.remove("is-invalid");
    }
    if(data_fechamento.value==''){
      data_fechamento.classList.add("is-invalid");
      verifica=false;
    }else{
      data_fechamento.classList.remove("is-invalid");
    }
    if(data_vencimento.value==''){
      data_vencimento.classList.add("is-invalid");
      verifica=false;
    }else{
      data_vencimento.classList.remove("is-invalid");
    }
    if(verifica){
      $.ajax({
      url:"{{env('APP_URL')}}/add_cartao",
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

$('.dinheiro').mask('#.##0,00', {reverse: true});
$('.telefone').mask('(00) 0 0000-0000');


function deletar(id){
  $.ajax({
      url:"/del_cartao",
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

function novo(){
  document.getElementById("id_cartao").value='';
  document.getElementById("nome_cartao").value='';
  $("#novo_cartao_modal").modal()
}

function editar(id){
  document.getElementById("id_cartao").value=id;
  document.getElementById("nome_cartao").value=document.getElementById("nome_"+id ).innerText;
  document.getElementById("data_fechamento_cartao").value=document.getElementById("data_fecha_"+id ).innerText;
  document.getElementById("data_vencimento_cartao").value=document.getElementById("data_vence_"+id ).innerText;
  checkbox = document.getElementById("ativo_cartao");
  if(document.getElementById ( "status_"+id ).innerText=='Ativo'){
    checkbox.checked = true;
  }else{
    checkbox.checked = false;
  }

  $("#novo_cartao_modal").modal()
}

</script>
@endsection

