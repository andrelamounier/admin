@extends('layouts/main')

@section('style')
<!-- DataTables -->
<link rel="stylesheet" href="{{env('APP_URL')}}/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" href="{{env('APP_URL')}}/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
<link rel="stylesheet" href="{{env('APP_URL')}}/plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
<link rel="stylesheet" href="{{env('APP_URL')}}/resources/css/dropzone.min.css" />
<style>
.nooverflow{
  overflow-x: hidden !important;
}
  
</style>
@endsection

@section('content')
 <!-- Content Wrapper. Contains page content -->
 <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Perfil</h1>
          </div>
          <div class="col-sm-6">
           
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-3">

            <!-- Profile Image -->
            <div class="card card-primary card-outline">
              <div class="card-body box-profile">
                <h3 class="profile-username text-center">{{$for_cli[0]->nome}}</h3>

                <ul class="list-group list-group-unbordered mb-3">
                  <li class="list-group-item">
                    <b>Lançamentos</b> <a class="float-right">{{$qut_lancamentos}}</a>
                  </li>
                  <li class="list-group-item">
                    <b>Documentos</b> <a class="float-right">{{$qut_documentos}}</a>
                  </li>
                </ul>

              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->

            <!-- About Me Box -->
            <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title">Sobre</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <strong><i class="fas fa-map-marker-alt mr-1"></i> Endereço</strong>

                <p class="text-muted">
                  <?php
                    echo $for_cli[0]->rua;
                    echo $for_cli[0]->rua ? ', '.$for_cli[0]->numero : $for_cli[0]->numero;
                    echo $for_cli[0]->numero ? ', '.$for_cli[0]->complemento : $for_cli[0]->complemento;
                    echo $for_cli[0]->complemento ? ' - '.$for_cli[0]->bairro : $for_cli[0]->bairro;
                    echo $for_cli[0]->bairro ? ', '.$for_cli[0]->cidade : $for_cli[0]->cidade;
                    echo $for_cli[0]->cidade ? ' - '.$for_cli[0]->estado : $for_cli[0]->estado;
                    echo $for_cli[0]->estado ? ', '.$for_cli[0]->cep : $for_cli[0]->cep;
                
                  ?>
                <hr>

                <strong><i class="fas fa-book mr-1"></i> Contatos</strong>

                <p class="text-muted">{{$for_cli[0]->telefone}}</p>
                <p class="text-muted">{{$for_cli[0]->email}}</p>
                <hr>

                <strong><i class="far fa-file-alt mr-1"></i> Descrição</strong>

                <p class="text-muted">{{$for_cli[0]->descricao}}</p>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
          <!-- /.col -->
          <div class="col-md-9">
            <div class="card">
              <div class="card-header p-2">
                <ul class="nav nav-pills">
                  <li class="nav-item"><a class="nav-link active" href="#geral" data-toggle="tab">Geral</a></li>
                  <li class="nav-item"><a class="nav-link" href="#lancamentos" data-toggle="tab">Lançamentos</a></li>
                  <li class="nav-item"><a class="nav-link" href="#documentos" data-toggle="tab">Documentos</a></li>
                </ul>
              </div><!-- /.card-header -->
              <div class="card-body ">
                <div class="tab-content table-responsive">
                  <div class="active tab-pane nooverflow" id="geral">
                    <div class="row">
                      <div class="col-md-6">
                        <!-- DIRECT CHAT -->
                        <div class="card direct-chat">
                          <div class="card-header">
                            <h3 class="card-title">Agenda</h3>
                          </div>
                          <!-- /.card-header -->
                          <div class="card-body">
                            <div class="direct-chat-messages">
                            <table class="table m-0">
                              <thead>
                                <tr>
                                  <th>Título</th>
                                  <th>Data</th>
                                  <th>Ações</th>
                                </tr>
                              </thead>
                              <tbody>
                              <input type="hidden" value="{{$for_cli[0]->id_for_cli}}" id="for_cli_id" class="form-control" >
                              @foreach($agendas as $item)
                              <?php
                                $d=date('d/m/Y',strtotime($item->data));
                                $h=date('H:i',strtotime($item->data));
                                if($h=='00:00' || $h==null){
                                  $h='';
                                }
                              ?>
                                <input type="hidden" value="{{date('Y-m-d',strtotime($item->data))}}" id="data_evento_modal_{{$item->id}}" class="form-control" >
                                <input type="hidden" value="{{$h}}" id="hora_evento_modal_{{$item->id}}" class="form-control" >
                                <input type="hidden" value="{{$item->descricao}}" id="descricao_evento_modal_{{$item->id}}" class="form-control" >
                                <input type="hidden" value="{{$item->titulo}}" id="titulo_evento_modal_{{$item->id}}" class="form-control" >
                                <tr>
                                  <td>{{$item->titulo}}</td>
                                  <td>{{$d}} {{$h}}</td>
                                  <td><button type="button" onClick="abrirAgenda({{$item->id}})" class="btn btn-primary"><i class="fa fa-eye"></i></button></td>
                                </tr>
                              @endforeach
                              </tbody>
                            </table>
                            </div>
                          </div>
                          <!-- /.card-body -->
                          <div class="card-footer">
                          </div>
                          <!-- /.card-footer-->
                        </div>
                        <!--/.direct-chat -->
                      </div>
                      <div class="col-md-6">
                        <!-- DIRECT CHAT -->
                        <div class="card direct-chat">
                          <div class="card-header">
                            <h3 class="card-title"></h3>
                          </div>
                          <!-- /.card-header -->
                          <div class="card-body">
                            <div class="direct-chat-messages">
                          
                            </div>
                          </div>
                          <!-- /.card-body -->
                          <div class="card-footer">
                          </div>
                          <!-- /.card-footer-->
                        </div>
                        <!--/.direct-chat -->
                      </div>
                    </div>
                  </div>
                  <!-- /.tab-pane -->
                  <div class="tab-pane" id="lancamentos">
                  <table id="example1" class="display table table-bordered table-striped" >
                  <thead>
                  <tr>
                    <th>Valor</th>
                    <th>C. de custo</th>
                    <th>Forn. - Cliente</th>
                    <th>Produto</th>
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
                          $total+=$item->valor;
                        ?>
                        <td data-value="{{str_replace('.',',',$item->valor)}}" id="valor_{{$item->id_lancamento}}">R$ {{number_format($item->valor, 2, ',', '')}}</td>
                        <td data-value="{{$item->id_centro_custo}}" id="centro_custos_{{$item->id_lancamento}}">{{$item->centro_custos}}</td>
                        <td data-value="{{$item->id_for_cli}}" id="for_cli_{{$item->id_lancamento}}">{{$item->for_cli}}</td>
                        <td data-value="{{$item->id_produto}}"id="produto_{{$item->id_lancamento}}">{{$item->produto}}</td>
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
                    <th colspan="7">R$ {{number_format($total, 2, ',', '.')}}</th>
                  </tr>
                  </tfoot>
                </table>



                  </div>
                  <!-- /.tab-pane -->

                  <div class="tab-pane" id="documentos">
                  <form name="form_add_projetos" action="{{env('APP_URL')}}/documentos/dropzoneStorage" class="dropzone dz-clickable bg-info" id="documentosupload" method="post" enctype="multipart/form-data" >
                  @csrf 
                  <div>
                    <input type="hidden" id="id_cli_for" name="id_cli_for" value="{{$for_cli[0]->id_for_cli}}" class="form-control" >
                    <h3 class="text-center">Click ou solte um arquivo para fazer upload.</h3>
                  </div>
                  <div class="dz-default dz-message"></div>
                </form>
                <hr>
                <div class="row" id="itens_documentos">
                  @foreach($documentos as $item)
                  <?php
                    $tamanhoNome=strlen($item->nome);
                    $br='';
                    if($tamanhoNome<=25){
                      $br='<br><br>';
                    }else if($tamanhoNome<=50){
                      $br='<br>';
                    }
                    $fileNameParts = explode('.', $item->caminho);
                    if($item->tipo!='2'){
                      $extension = end($fileNameParts);
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
                  }else{
                      $icon='<i class="fa-solid fa-pen-nib"></i>';
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
                          <a href="#" onClick="editar_documento('{{$item->nome}}',{{$item->id}},{{$for_cli[0]->id_for_cli}})" class="ml-2 btn btn-default btn-sm bg-success">
                            <i class="fas fa-pen"></i>
                          </a>
                          <?php if($item->tipo!=2){ ?>
                          <a href="{{env('APP_URL')}}/documentos/download?id={{$item->id}}"  class="btn btn-default btn-sm  bg-success" >
                            <i class="fas fa-download"></i>
                          </a>
                          <?php } ?>
                          <a href="#" class="btn btn-default btn-sm bg-danger" onClick="deletar_documento('{{$item->nome}}','{{$item->id}}')" >
                            <i class="fas fa-trash"></i>
                          </a>
                        </div>
                      </div>
                    </div>

                  @endforeach
                  </div>

                  </div>
                  <!-- /.tab-pane -->
                </div>
                <!-- /.tab-content -->
              </div><!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->


      <div class="modal fade" id="calendario_modal">
        <div class="modal-dialog modal-lg">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title">Evento</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
            <form name="form_add_evento" enctype="multipart/form-data" >
              @csrf
              <input type="hidden" id="id_evento_modal" name="id_evento_modal" class="form-control" >
              <div class="row">
                <div class="form-group col-8">
                  <label for="titulo_evento_modal">Título:</label>
                  <div class="input-group">
                    <input type="text" id="titulo_evento_modal" name="titulo_evento_modal" class="form-control" >
                  </div>
                </div>
                <div class="form-group col-4">
                  <label for="data_evento_modal">Data:</label>
                  <div class="input-group">
                    <input type="date" id="data_evento_modal" name="data_evento_modal" class="form-control" >
                  </div>
                </div>
                <div class="form-group col-4">
                  <label for="hora_evento_modal">Hora:</label>
                  <div class="input-group">
                    <input type="time" id="hora_evento_modal" name="hora_evento_modal" class="form-control" >
                  </div>
                </div>
                <div class="form-group col-4">
                  <label for="for_cli_evento_modal">Cliente - Fornecedor:</label>
                  <select id="for_cli_evento_modal" name="for_cli_evento_modal"class="form-control select2bs4">
                  <option value=""></option>
                  @foreach($for_cli_all as $item)
                        <option value='{{$item->id_for_cli}}'>{{$item->nome}}</option>
                    @endforeach
                  </select>
                </div>
                <div class="form-group col-12">
                  <label for="desc_evento_modal">Descrição:</label>
                  <div class="input-group">
                    <textarea id="desc_evento_modal" name="desc_evento_modal" class="form-control" rows="4" cols="50"></textarea>
                  </div>
                </div>
              </div>
            </div>
            <div class="modal-footer justify-content-between">
              <button type="button" onClick="del_evento()" class="btn btn-danger" data-dismiss="modal">Deletar</button>
              <button type="submit" class="btn btn-primary">Alterar</button>
            </div>
            </form>
          </div>
          <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
      </div>
      <!-- /.modal --> 

      <div class="modal fade" id="editar_documentos">
        <div class="modal-dialog modal-lg">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title">Editar documentos</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
            <form name="form_editar_documento" enctype="multipart/form-data" >
              @csrf
              <input type="hidden" id="id_documento" value='' name="id_documento" class="form-control" >
              <div class="row">
                <div class="form-group col-md-3 col-12">
                  <label for="nome_documento">Nome:</label>
                  <div class="input-group">
                    <input type="text" id="nome_documento" name="nome_documento" class="valor form-control" style="display:inline-block">
                  </div>
                </div>
                <div class="form-group col-md-4 col-12">
                  <label for="for_cli_documentos">Cliente - Fornecedor:</label>
                  <select id="for_cli_documentos" name="for_cli_documentos"class="form-control select2bs4" style="width: 100%;">
                  <option value="">Nenhum</option>
                  @foreach($for_cli_all as $item)
                        <option value='{{$item->id_for_cli}}'>{{$item->nome}}</option>
                    @endforeach
                  </select>
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


      
  <div class="modal fade" id="novo">
        <div class="modal-dialog modal-lg">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title">Editar Contas </h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
            <form name="form_add" enctype="multipart/form-data" >
              @csrf
              <input type="hidden" id="id_contas" name="id_contas" class="form-control" >
              <div class="row">
                <div class="form-group col-md-3 col-12">
                  <label for="valor_contas">Valor:</label>
                  <div class="input-group">
                    <input type="text" id="valor_contas" name="valor_contas" class="valor form-control" style="display:inline-block">
                  </div>
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
                  @foreach($for_cli_all as $item)
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
                  <label for="status_contas">Status:</label>
                  <select id="status_contas" name="status_contas"class="form-control select2bs4" style="width: 100%;">
                  <option value=""></option>
                  @foreach($status as $item)
                        <option value='{{$item->id_status}}'>{{$item->nome}}</option>
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
        console.log(response.status);
        //document.location.reload(true);
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

 $(document).ready(function() {
    $('#example1').DataTable( {
      responsive: true,
        dom: 'Bfrtip',
        "aaSorting": [],
        language: {
            url: 'https://cdn.datatables.net/plug-ins/1.12.1/i18n/pt-BR.json'
        },
        buttons: [
            'excelHtml5',
            'pdfHtml5',
            "colvis"
        ]
    } );
} );

function abrirAgenda(id){
  document.getElementById("id_evento_modal").value=id;
  document.getElementById("data_evento_modal").value=document.getElementById("data_evento_modal_"+id).value;
  document.getElementById("hora_evento_modal").value=document.getElementById("hora_evento_modal_"+id).value;
  document.getElementById("desc_evento_modal").value=document.getElementById("descricao_evento_modal_"+id).value;
  document.getElementById("titulo_evento_modal").value=document.getElementById("titulo_evento_modal_"+id).value;
  $("#for_cli_evento_modal").val(document.getElementById("for_cli_id").value).trigger('change');
  $("#calendario_modal").modal();
}

function del_evento(){
    id=document.getElementById("id_evento_modal").value;
    $.ajax({
      url:"{{env('APP_URL')}}/del_agenda",
      headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
      type: 'post',
      data: { 'id'     : id
      },
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

$(function(){
  $('Form[name="form_add_evento"]').submit(function(event){
    event.preventDefault();
    $.ajax({
      url:"{{env('APP_URL')}}/add_agenda",
      type: 'post',
      data: $(this).serialize(),
      dataType: 'json',
      success: function(response){
            if(response.status){
              document.location.reload(true);
            }else{
              alert('Erro.');
            }
        }
    });
  });
});


function editar_documento(nome,id,id_for_cli){
  $('#id_documento').val(id); 
  $('#nome_documento').val(nome); 
  $('#for_cli_documentos').val(id_for_cli); 
  $('#for_cli_documentos').trigger('change');
  $("#editar_documentos").modal()
}


$(function(){
  $('Form[name="form_editar_documento"]').submit(function(event){
    event.preventDefault();
    verifica=true;

    var nome = document.getElementById("nome_documento");
   
    if(nome.value==''){
      nome.classList.add("is-invalid");
      verifica=false;
    }else{
      nome.classList.remove("is-invalid");
    }
    if(verifica){
      $.ajax({
        url:"{{env('APP_URL')}}/documentos/edita_documento",
        type: 'post',
        data: $(this).serialize(),
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
});
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
</script>
@endsection

