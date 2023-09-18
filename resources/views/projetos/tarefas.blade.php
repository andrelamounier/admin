@extends('layouts/main')

@section('style')
<link rel="stylesheet" href="{{env('APP_URL')}}/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
@endsection

@section('content')
<div class="content-wrapper kanban">
    <section class="content-header">
      <div class="container-fluid">
        <div class="row">
          <div class="col-sm-6">
            <h1>Tarefas</h1>
          </div>
          <div class="col-sm-6 d-none d-sm-block">
            
          </div>
        </div>
      </div>
    </section>

    <section class="content pb-3">
      <div class="container-fluid h-100">
        <div class="card card-row card-secondary">
          <div class="card-header">
            <h3 class="card-title">
              Criar
            </h3>
          </div>
          <div class="card-body">
            <div class="card card-info card-outline">
              <div class="card-header">
                
              </div>
              <div class="card-body">
                <form name="form_add_projetos" method="post" enctype="multipart/form-data" action="{{env('APP_URL')}}/projetos/add">
                  @csrf 
                  <div class="form-group">
                    <label for="titulo_cria_tarefas">Título:</label>
                    <input id="titulo_cria_tarefas" name="titulo_cria_tarefas" type="text" value="" class="form-control" required>
                  </div>
                  <div class="form-group">
                    <label for="descricao_cria_tarefas">Descrição:</label>
                    <textarea id="descricao_cria_tarefas" placeholder="" name="descricao_cria_tarefas" class="form-control" rows="4" cols="50"></textarea>
                  </div>
                  <div class="form-group">
                    <label for="data_cria_tarefas">Data:</label>
                    <input id="data_cria_tarefas" name="data_cria_tarefas" type="date" value="" class="form-control" required>
                  </div>
                  <div class="form-group">
                    <label for="status_cria_tarefas">Status:</label>
                    <select id="status_cria_tarefas" name="status_cria_tarefas"class="form-control" required>
                      <option value="1">Pendências</option>
                      <option value="2">Em progesso</option>
                      <option value="3">Concluído</option>
                    </select>
                  </div>
                  <div class="form-group">
                    <label>Itens:
                      <button type="button" onClick="addInput()" class="btn btn-primary btn-sm" title="Adicionar">
                        <i class="fas fa-plus"></i>
                      </button>
                    </label>
                  </div>
                  <div class="form-group" id="div_lista_cria_tarefas">
                    <input name="lista_cria_tarefas[]" type="text" value="" class="form-control"><br>
                  </div>
                
              </div>
              <div class="card-footer">
                <button type="submit" class="btn btn-primary">
                  Salvar
                </button>
                </form>
              </div>
            </div>
          </div>
        </div>
        <div class="card card-row card-primary">
          <div class="card-header">
            <h3 class="card-title">
              Lista de pendências
            </h3>
          </div>
          <div class="card-body">
          @foreach($tarefas as $item)
          <?php 
            if($item->status=='1'){
            $data=date_create($item->data);
            $color='white';
            if(strtotime(date_format($data,"Y-m-d"))<strtotime(date("Y-m-d"))){
              $color='red';
            }else if(date_format($data,"Y-m-d")==date("Y-m-d")){
              $color='green';
            }
            $i=0;
          ?>
          <input id="titulo_{{$item->id}}"  type="hidden" value="{{$item->titulo}}" class="form-control">
          <input id="descricao_{{$item->id}}"  type="hidden" value="{{$item->descricao}}" class="form-control">
          <input id="data_{{$item->id}}"  type="hidden" value="{{$item->data}}" class="form-control">
          <input id="status_{{$item->id}}"  type="hidden" value="{{$item->status}}" class="form-control">
            <div class="card card-{{$color}} card-outline collapsed-card">
              <div class="card-header">
                <h5 class="card-title" data-card-widget="collapse">{{$item->titulo}}</h5>
                <div class="card-tools">
                  <a href="#" class="btn-tool text-decoration-none" data-card-widget="collapse">
                    <i class="fas fa-plus"></i>
                  </a>
                  <a href="#" onClick="modalTarefa({{$item->id}})" class="btn-tool text-decoration-none">
                    <i class="fas fa-pen"></i>
                  </a>
                  <a href="#" onClick="del_tarefa({{$item->id}})" class="btn-tool text-decoration-none">
                    <i class="fa fa-trash"></i>
                  </a>
                </div>
              </div>
              <div class="card-body">
                <p>
                  {{$item->descricao}}
                </p>
                @foreach(json_decode($item->lista,true) as $lista)
                  <div class="form-group clearfix">
                    <div class="icheck-success d-inline">
                      <input type="checkbox"  id="checkboxTarefas{{$item->id.$i}}" onClick="marcarLista({{$item->id}},{{$i}})" {{$lista['input']}}>
                      <input id="checkbox_{{$item->id.$i}}" data-value="{{$i}}" name="lista_{{$item->id}}[]"  type="hidden" value="{{$lista['text']}}" class="form-control">
                      <label for="checkboxTarefas{{$item->id.$i}}" >
                       {{$lista['text']}}
                      </label>
                    </div>
                  </div>
                  <?php $i++; ?>
                @endforeach
<!--
                <div class="form-group clearfix">
                  <div class="d-inline">
                    <a href="#" class="text-white"><i class="fas fa-paperclip"></i> Sep2014-report.pdf</a> 
                  </div>
                </div>
-->           
              </div>
              <div class="card-footer">
                <span class="direct-chat-timestamp float-right text-{{$color}}">{{date_format($data,"d/m/Y")}}</span>
              </div>
            </div>
          
          <?php } ?>
          @endforeach
          </div>
        </div>

        <div class="card card-row card-default">
          <div class="card-header bg-info">
            <h3 class="card-title">
              Em progesso
            </h3>
          </div>
          <div class="card-body">
          @foreach($tarefas as $item)
          <?php 
            if($item->status=='2'){
            $data=date_create($item->data);
            $color='white';
            if(strtotime(date_format($data,"Y-m-d"))<strtotime(date("Y-m-d"))){
              $color='red';
            }else if(date_format($data,"Y-m-d")==date("Y-m-d")){
              $color='green';
            }
            $i=0;
          ?>
          <input id="titulo_{{$item->id}}"  type="hidden" value="{{$item->titulo}}" class="form-control">
          <input id="descricao_{{$item->id}}"  type="hidden" value="{{$item->descricao}}" class="form-control">
          <input id="data_{{$item->id}}"  type="hidden" value="{{$item->data}}" class="form-control">
          <input id="status_{{$item->id}}"  type="hidden" value="{{$item->status}}" class="form-control">
            <div class="card card-{{$color}} card-outline collapsed-card">
              <div class="card-header">
                <h5 class="card-title" data-card-widget="collapse">{{$item->titulo}}</h5>
                <div class="card-tools">
                  <a href="#" class="btn-tool text-decoration-none" data-card-widget="collapse">
                    <i class="fas fa-plus"></i>
                  </a>
                  <a href="#" onClick="modalTarefa({{$item->id}})" class="btn-tool text-decoration-none">
                    <i class="fas fa-pen"></i>
                  </a>
                  <a href="#" onClick="del_tarefa({{$item->id}})" class="btn-tool text-decoration-none">
                    <i class="fa fa-trash"></i>
                  </a>
                </div>
              </div>
              <div class="card-body">
                <p>
                  {{$item->descricao}}
                </p>
                @foreach(json_decode($item->lista,true) as $lista)
                  <div class="form-group clearfix">
                    <div class="icheck-success d-inline">
                      <input type="checkbox"  id="checkboxTarefas{{$item->id.$i}}" onClick="marcarLista({{$item->id}},{{$i}})" {{$lista['input']}}>
                      <input id="checkbox_{{$item->id.$i}}" data-value="{{$i}}" name="lista_{{$item->id}}[]"  type="hidden" value="{{$lista['text']}}" class="form-control">
                      <label for="checkboxTarefas{{$item->id.$i}}" >
                       {{$lista['text']}}
                      </label>
                    </div>
                  </div>
                  <?php $i++; ?>
                @endforeach
<!--
                <div class="form-group clearfix">
                  <div class="d-inline">
                    <a href="#" class="text-white"><i class="fas fa-paperclip"></i> Sep2014-report.pdf</a> 
                  </div>
                </div>
-->           
              </div>
              <div class="card-footer">
                <span class="direct-chat-timestamp float-right text-{{$color}}">{{date_format($data,"d/m/Y")}}</span>
              </div>
            </div>
          <?php } ?>
          @endforeach
          </div>
        </div>

        <div class="card card-row card-success">
          <div class="card-header">
            <h3 class="card-title">
              Concluído
            </h3>
          </div>
          <div class="card-body">
          @foreach($tarefas as $item)
          <?php 
            if($item->status=='3'){
            $data=date_create($item->data);
            $color='blue';
            $i=0;
          ?>
          <input id="titulo_{{$item->id}}"  type="hidden" value="{{$item->titulo}}" class="form-control">
          <input id="descricao_{{$item->id}}"  type="hidden" value="{{$item->descricao}}" class="form-control">
          <input id="data_{{$item->id}}"  type="hidden" value="{{$item->data}}" class="form-control">
          <input id="status_{{$item->id}}"  type="hidden" value="{{$item->status}}" class="form-control">
            <div class="card card-{{$color}} card-outline collapsed-card">
              <div class="card-header">
                <h5 class="card-title" data-card-widget="collapse">{{$item->titulo}}</h5>
                <div class="card-tools">
                  <a href="#" class="btn-tool text-decoration-none" data-card-widget="collapse">
                    <i class="fas fa-plus"></i>
                  </a>
                  <a href="#" onClick="modalTarefa({{$item->id}})" class="btn-tool text-decoration-none">
                    <i class="fas fa-pen"></i>
                  </a>
                  <a href="#" onClick="del_tarefa({{$item->id}})" class="btn-tool text-decoration-none">
                    <i class="fa fa-trash"></i>
                  </a>
                </div>
              </div>
              <div class="card-body">
                <p>
                  {{$item->descricao}}
                </p>
                @foreach(json_decode($item->lista,true) as $lista)
                  <div class="form-group clearfix">
                    <div class="icheck-success d-inline">
                      <input type="checkbox"  id="checkboxTarefas{{$item->id.$i}}" onClick="marcarLista({{$item->id}},{{$i}})" {{$lista['input']}}>
                      <input id="checkbox_{{$item->id.$i}}" data-value="{{$i}}" name="lista_{{$item->id}}[]"  type="hidden" value="{{$lista['text']}}" class="form-control">
                      <label for="checkboxTarefas{{$item->id.$i}}" >
                       {{$lista['text']}}
                      </label>
                    </div>
                  </div>
                  <?php $i++; ?>
                @endforeach
<!--
                <div class="form-group clearfix">
                  <div class="d-inline">
                    <a href="#" class="text-white"><i class="fas fa-paperclip"></i> Sep2014-report.pdf</a> 
                  </div>
                </div>
-->           
              </div>
              <div class="card-footer">
                <span class="direct-chat-timestamp float-right text-{{$color}}">{{date_format($data,"d/m/Y")}}</span>
              </div>
            </div>
          <?php } ?>
          @endforeach
          </div>
        </div>
      </div>
    </section>
  </div>



  <div class="modal fade" id="modalTarefas">
        <div class="modal-dialog modal-lg">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title">Editar Tarefa</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
            <form name="form_add_modal" enctype="multipart/form-data" >
              @csrf
              <input type="hidden" id="id_tarefas_modal" name="id" class="form-control" >
                  <div class="row">
                    <div class="form-group col-12 col-lg-6" >
                      <label for="titulo_tarefas_modal">Título:</label>
                      <input id="titulo_tarefas_modal" name="titulo_tarefas_modal" type="text" value="" class="form-control">
                    </div>
                    <div class="form-group col-12 col-lg-3">
                      <label for="data_tarefas_modal">Data:</label>
                      <input id="data_tarefas_modal" name="data_tarefas_modal" type="date" value="" class="form-control">
                    </div>
                    <div class="form-group col-12 col-lg-3">
                      <label for="status_tarefas_modal">Status:</label>
                      <select id="status_tarefas_modal" name="status_tarefas_modal"class="form-control">
                        <option value="1">Pendências</option>
                        <option value="2">Em progesso</option>
                        <option value="3">Concluído</option>
                      </select>
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="descricao_tarefas_modal">Descrição:</label>
                    <textarea id="descricao_tarefas_modal" placeholder="" name="descricao_tarefas_modal" class="form-control" rows="4" cols="50"></textarea>
                  </div>
                  <div class="form-group">
                    <label>Itens:
                      <button type="button" onClick="addInputModal()" class="btn btn-primary btn-sm" title="Adicionar">
                        <i class="fas fa-plus"></i>
                      </button>
                    </label>
                  </div>
                  
                  <div  id="div_lista_tarefas_modal">
                 
                  </div>
              </div>
              <div class="modal-footer justify-content-between">
              <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
              <button type="button" class="btn btn-primary" onClick="editarTarefa()">Salvar</button>
            </div>
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
  addid=1;
function addInput(){
    var addList = document.getElementById('div_lista_cria_tarefas');
    var docstyle = addList.style.display;
    if (docstyle == 'none') addList.style.display = '';

    addid++;
    var text = document.createElement('div');
    text.id = 'additem_' + addid;
    text.innerHTML = "<input name='lista_cria_tarefas[]' type='text' value='' class='form-control'><br>";
    addList.appendChild(text);

}

function addInputModal(){
    var addList = document.getElementById('div_lista_tarefas_modal');
    var docstyle = addList.style.display;
    addid++;
    if (docstyle == 'none'){addList.style.display = ''};
    
    var text = document.createElement('div');
    text.id = 'additem_modal_' + addid;
    text.innerHTML = "<div class='form-group col-1' ><div class='icheck-success d-inline'><input  type='checkbox' id='check"+addid+"' ><label for='check"+addid+"' ></label></div></div><div class='form-group col-11' ><input  data-value='"+addid+"' id='lista_cria_tarefas_modal' name='lista_cria_tarefas_modal[]' type='text' value='' class='form-control'></div>";
     
    addList.appendChild(text);
    var element = document.getElementById('additem_modal_' + addid);   
    element.classList.add("row"); 
}

$(function(){
  $('Form[name="form_add_projetos"]').submit(function(event){
    event.preventDefault();
    $.ajax({
      url:"{{env('APP_URL')}}/projetos/add",
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

function marcarLista(id,i){
  check='';
  if($("#checkboxTarefas"+id+i).is(':checked')){
    check='checked';
  }
  
  $.ajax({
      url:"{{env('APP_URL')}}/projetos/altera_check",
      headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
      type: 'post',
      data: { 'id' : id,
              'posicao': i,
              'check':check
      },
      dataType: 'json',
      success: function(response){
            if(response.status){
              //console.log(response.status);
            }else{
              alert(response.message);
            }
        }
    });
}

function modalTarefa(id){
  document.getElementById("id_tarefas_modal").value=id;
  $('#titulo_tarefas_modal').val($('#titulo_'+id).val()); 
  $('#data_tarefas_modal').val($('#data_'+id).val()); 
  $('#descricao_tarefas_modal').val($('#descricao_'+id).val());
  $('#status_tarefas_modal').val($('#status_'+id).val());
  document.getElementById('div_lista_tarefas_modal').innerHTML = "";
  var input = document.getElementsByName('lista_'+id+'[]');
  var addList = document.getElementById('div_lista_tarefas_modal');
  
  for (var i = 0; i < input.length; i++) {
    var a = input[i];
    var docstyle = addList.style.display;
    cont=a.getAttribute('data-value');
    if (docstyle == 'none') addList.style.display = '';
    addid++;
    var text = document.createElement('div');
    text.id = 'additem_modal_' + addid;

    checked_item_modal='';
    if($("#checkboxTarefas"+id+cont).is(':checked')){
      checked_item_modal='checked';
    }
    text.innerHTML = "<div class='form-group col-1' ><div class='icheck-success d-inline'><input "+checked_item_modal+" type='checkbox' id='check"+addid+"' ><label for='check"+addid+"' ></label></div></div><div class='form-group col-11' ><input data-value='"+addid+"'  id='lista_cria_tarefas_modal' name='lista_cria_tarefas_modal[]' type='text' value='"+a.value+"' class='form-control'></div>";
    addList.appendChild(text);

    var element = document.getElementById('additem_modal_' + addid);   
    element.classList.add("row");          
  }
  $("#modalTarefas").modal()
}



function editarTarefa(){
  id=document.getElementById("id_tarefas_modal").value;
  lista=document.getElementsByName('lista_cria_tarefas_modal[]');
  jsonLista='[';
  lista.forEach((item, index, array) => {
    if(item.value!=''){
      jsonLista+='{';
      if($("#check"+item.getAttribute('data-value')).is(':checked')){
        jsonLista+='"input":"checked",';
      }else{
        jsonLista+='"input":"",';
      }
      jsonLista+='"text":"'+item.value+'"},';
    }
  })
  if(jsonLista!='['){
    jsonLista = jsonLista.substring(0, jsonLista.length - 1);
  }
  jsonLista+=']';

  $.ajax({
        url:"{{env('APP_URL')}}/projetos/add",
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        type: 'post',
        data: { 'id_cria_tarefas' : id,
                'titulo_cria_tarefas':$('#titulo_tarefas_modal').val(),
                'descricao_cria_tarefas':$('#descricao_tarefas_modal').val(),
                'data_cria_tarefas': $('#data_tarefas_modal').val(),
                'status_cria_tarefas': $('#status_tarefas_modal').val(),
                'jsonLista':jsonLista
        },
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

function del_tarefa(id){
  titulo=$('#titulo_'+id).val();
  Swal.fire({
  title: 'Deseja realmente deletar a tarefa ' +titulo+' ?',
  showDenyButton: true,
  denyButtonText: 'Deletar',
  confirmButtonText: 'Cancelar',
  }).then((result) => {
    if (result.isConfirmed) {
     
    } else if (result.isDenied) {
      $.ajax({
        url:"{{env('APP_URL')}}/projetos/del_tarefa",
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        type: 'post',
        data: {'id' : id},
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

