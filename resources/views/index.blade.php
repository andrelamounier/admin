@extends('layouts/main')


@section('style')

  <!-- fullCalendar -->
  <link rel="stylesheet" href="{{env('APP_URL')}}/plugins/fullcalendar/main.css">
  <link rel="stylesheet" href="{{env('APP_URL')}}/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
@endsection

@section('content')
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Dashboard</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
           
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <!-- Info boxes -->
        <div class="row">
          <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box">
              <span class="info-box-icon bg-info elevation-1"><i class="fa-solid fa-landmark"></i></span>

              <div class="info-box-content">
                <span class="info-box-text">Saldo</span>
                <span class="info-box-number">
                <?php
                  $total=0;
                ?>
                @foreach($lancamentos as $item)
                <?php
                  if($item->tipo=='1' && $item->id_status=='1'){
                    $total+=$item->valor;
                  }else if($item->tipo=='2' && $item->id_status=='1'){
                    $total-=$item->valor;
                  }
                ?>
                @endforeach
                R$ {{number_format($total, 2, ',', '.')}}
                </span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>
          <!-- /.col -->
          <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box mb-3">
              <span class="info-box-icon bg-danger elevation-1"><i class="fas fa-shopping-cart"></i></span>

              <div class="info-box-content">
                <span class="info-box-text">Contas em aberto</span>
                <span class="info-box-number">
                <?php
                  $total=0;
                ?>
                @foreach($lancamentos as $item)
                <?php
                  if($item->tipo=='2' && $item->id_status=='2'){
                    $total+=$item->valor;
                  }
                ?>
                @endforeach
                R$ {{number_format($total, 2, ',', '.')}}

                </span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>
          <!-- /.col -->

          <!-- fix for small devices only -->
          <div class="clearfix hidden-md-up"></div>

          <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box mb-3">
              <span class="info-box-icon bg-success elevation-1"><i class="fa fa-money-bill"></i></span>

              <div class="info-box-content">
                <span class="info-box-text">Saldo a receber</span>
                <span class="info-box-number">
                <?php
                  $total=0;
                ?>
                @foreach($lancamentos as $item)
                <?php
                  if($item->tipo=='1' && $item->id_status=='2'){
                    $total+=$item->valor;
                  }
                ?>
                @endforeach
                R$ {{number_format($total, 2, ',', '.')}}

                </span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>
          <!-- /.col -->
          <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box mb-3">
              <span class="info-box-icon bg-warning elevation-1"><i class="fa-solid fa-landmark"></i></span>

              <div class="info-box-content">
                <span class="info-box-text">Saldo do mês</span>
                <span class="info-box-number">
                <?php
                  $total=0;
                  $data_inicio=date("Y-m-d",mktime(0,0,0,date('m'),1));
                  $data_fim=date("Y-m-t",mktime(0,0,0,date('m')));
                ?>
                @foreach($lancamentos as $item)
                <?php
                  if($item->tipo=='1' && $item->id_status=='1' && $item->data_vencimento>=$data_inicio && $item->data_vencimento<=$data_fim){
                    $total+=$item->valor;
                    
                  }else if($item->tipo=='2' && $item->id_status=='1' && $item->data_vencimento>=$data_inicio && $item->data_vencimento<=$data_fim){
                    $total-=$item->valor;
                  }
                  
                ?>
                @endforeach
                R$ {{number_format($total, 2, ',', '.')}}


                </span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->

        <div class="row">
          <div class="col-md-12">
          <div class="card card-success">
              <div class="card-body">
                <div class="chart">
                  <canvas id="barChart" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
                </div>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->
      
        
      </div><!--/. container-fluid -->
    </section>
    <!-- /.content -->
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Agenda</h1>
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
            <div class="sticky-top mb-3">
              <div class="card" style="display: none;">>
                <div class="card-header">
                  <h4 class="card-title">Eventos</h4>
                </div>
                <div class="card-body">
                  <!-- the events -->
                  <div id="external-events">
                   
                    <div class="checkbox">
                      <label for="drop-remove">
                        <input type="checkbox" id="drop-remove">
                        Remover depois de adicionar
                      </label>
                    </div>
                  </div>
                </div>
                <!-- /.card-body -->
              </div>
              <!-- /.card -->
              <div class="card">
                <div class="card-header">
                  <h3 class="card-title">Adicionar na Agenda</h3>
                </div>
                <div class="card-body">
                  <div class="btn-group" style="width: 100%; margin-bottom: 10px;">
                    <ul class="fc-color-picker" id="color-chooser">
                      <li><a class="text-primary" href="#"><i class="fas fa-square"></i></a></li>
                      <li><a class="text-warning" href="#"><i class="fas fa-square"></i></a></li>
                      <li><a class="text-success" href="#"><i class="fas fa-square"></i></a></li>
                      <li><a class="text-danger" href="#"><i class="fas fa-square"></i></a></li>
                      <li><a class="text-muted" href="#"><i class="fas fa-square"></i></a></li>
                    </ul>
                  </div>
                  <!-- /btn-group -->
                  <div class="input-group">
                        <input id="data_evento" placeholder="Data" type="date" class="form-control">
                  </div>
                  <div class="input-group">
                        <input id="hora_evento" type="time" value="00:00" class="form-control">
                  </div>
                  <div class="input-group">
                    <select id="for_cli_evento" name="for_cli_evento"class=" select2bs4 form-control  ">
                      <option value="">Cliente - Fornecedor</option>
                      @foreach($for_cli as $item)
                          <option value='{{$item->id_for_cli}}'>{{$item->nome}}</option>
                      @endforeach
                    </select>
                  </div>
                  <div class="input-group">
                        <textarea id="desc_evento" placeholder="Descrição" name="desc_evento" class="form-control" rows="4" cols="50"></textarea>
                  </div> 
                  <div class="input-group">
                    <input id="new-event" name="titulo_evento_modal" type="text" class="form-control" placeholder="Título do evento">
                  <div class="input-group-append">
                      <button id="add-new-event" type="button" class="btn btn-primary">Add</button>
                  </div>
                    <!-- /btn-group -->
                  </div>
                  <!-- /input-group -->
                </div>
              </div>
            </div>
          </div>
          <!-- /.col -->
          <div class="col-md-9">
            <div class="card card-primary">
              <div class="card-body p-0">
                <!-- THE CALENDAR -->
                <div id="calendar"></div>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
          <!-- /.col -->
          <div class="col-md-5">
          <div class="card">
              <div class="card-header">
                <h3 class="card-title">
                  Lista
                </h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                @foreach($tarefas as $item)
                  <?php 
                    $i=0;
                  ?>
                  <input id="titulo_{{$item->id}}"  type="hidden" value="{{$item->titulo}}" class="form-control">
                  <div class="card card-white card-outline collapsed-card">
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
                    </div>
                    <div class="card-footer">
                    </div>
                  </div>
                @endforeach
              </div>
              <!-- /.card-body -->
              <div class="card-footer clearfix">
                <button type="button" class="btn btn-primary float-right" onClick="novaLista()"><i class="fas fa-plus"></i> Adicionar</button>
              </div>
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
              <input type="hidden" id="cor_evento_modal" name="cor_evento_modal" class="form-control" >
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
                  @foreach($for_cli as $item)
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

<div class="modal fade" id="modalTarefas">
        <div class="modal-dialog modal-lg">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title" id="tituloModal"></h4>
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
<script src="{{env('APP_URL')}}/dist/js/pages/dashboard2.js"></script>
<!-- jQuery UI -->
<script src="{{env('APP_URL')}}/plugins/jquery-ui/jquery-ui.min.js"></script>
<!-- fullCalendar 2.2.5 -->
<script src="{{env('APP_URL')}}/plugins/moment/moment.min.js"></script>
<script src="{{env('APP_URL')}}/plugins/fullcalendar/main.js"></script>
<script src="{{env('APP_URL')}}/resources/assets/calendario/js//pt-br.js"></script>
<script>
    var areaChartData = {
      labels  : [
        <?php
          $total=0;
          $total_mes=0;
          $mes_extenso = array(
            'Jan' => 'Janeiro',
            'Feb' => 'Fevereiro',
            'Mar' => 'Marco',
            'Apr' => 'Abril',
            'May' => 'Maio',
            'Jun' => 'Junho',
            'Jul' => 'Julho',
            'Aug' => 'Agosto',
            'Nov' => 'Novembro',
            'Sep' => 'Setembro',
            'Oct' => 'Outubro',
            'Dec' => 'Dezembro'
          );
          $mes_extenso_aux='';
          $verificador=false;
          foreach($lancamentos_semestral as $item){
            
              $mes = new DateTime( $item->data_vencimento);
              $mes_aux=$mes->format('M');
              
              if($mes_extenso_aux!=$mes_extenso["$mes_aux"]){

                  $mes_extenso_aux=$mes_extenso["$mes_aux"];
                  if( $verificador){
                  echo ",";
                  }
                  echo "'$mes_extenso_aux'";
                  $verificador=true;
              }
            

          }
          ?>
      ],
      datasets: [
        {
          label               : 'Saldo do mês',
          backgroundColor     : 'rgba(210, 214, 222, 1)',
          borderColor         : 'rgba(210, 214, 222, 1)',
          pointRadius         : false,
          pointColor          : 'rgba(210, 214, 222, 1)',
          pointStrokeColor    : '#c1c7d1',
          pointHighlightFill  : '#fff',
          pointHighlightStroke: 'rgba(220,220,220,1)',
          data                : [
            <?php
              $verificador=0;
              $mes_x='';
              $total_mes=0;
              foreach($lancamentos_semestral as $item){
               

                  $mes = new DateTime( $item->data_vencimento);
                  $mes_y=$mes->format('m');
                  if($mes_x!=$mes_y){
                    $mes_x=$mes_y;
                    if($verificador==1){
                      echo $total_mes;
                      $total_mes=0;
                    }else if($verificador>1){
                      echo ',';
                      echo $total_mes;
                      $total_mes=0;
                    }
                    $verificador++;
                  }
                  if($item->tipo=='1'){
                    $total_mes+=$item->valor;
                  }else if($item->tipo=='2'){
                    $total_mes-=$item->valor;
                  }
                      
                
              }
              if($verificador==1){
                echo $total_mes;
              }else if($verificador>1){
                echo ',';
                echo $total_mes;
              }
            ?>
          ]
        },
        {
          label               : 'Saldo',
          backgroundColor     : 'rgba(60,141,188,0.9)',
          borderColor         : 'rgba(60,141,188,0.8)',
          pointRadius          : false,
          pointColor          : '#3b8bba',
          pointStrokeColor    : 'rgba(60,141,188,1)',
          pointHighlightFill  : '#fff',
          pointHighlightStroke: 'rgba(60,141,188,1)',
          data                : [
            <?php
              $verificador=0;
              $mes_x='';
              $total=0;
              $saldo_anterior=0;
              foreach($lancamentos_saldo_anterior as $item){
                if($item->tipo=='1'){
                  $saldo_anterior+=$item->valor;
                }else if($item->tipo=='2'){
                  $saldo_anterior-=$item->valor;
                }
              }
              $total= $saldo_anterior;
              foreach($lancamentos_semestral as $item){
                  $mes = new DateTime( $item->data_vencimento);
                  $mes_y=$mes->format('m');
                  if($mes_x!=$mes_y){
                    $mes_x=$mes_y;
                    if($verificador==1){
                      echo $total;
                    }else if($verificador>1){
                      echo ',';
                      echo $total;
                    }
                    $verificador++;
                  }
                  if($item->tipo=='1'){
                    $total+=$item->valor;
                  }else if($item->tipo=='2'){
                    $total-=$item->valor;
                  }
                      
                
              }
              if($verificador==1){
                echo $total;
              }else if($verificador>1){
                echo ',';
                echo $total;
              }
            ?>
          ]
        },
        
      ]
    }

  var barChartCanvas = $('#barChart').get(0).getContext('2d')
    var barChartData = $.extend(true, {}, areaChartData)
    var temp0 = areaChartData.datasets[0]
    var temp1 = areaChartData.datasets[1]
    barChartData.datasets[0] = temp1
    barChartData.datasets[1] = temp0

    var barChartOptions = {
      responsive              : true,
      maintainAspectRatio     : false,
      datasetFill             : false
    }

    new Chart(barChartCanvas, {
      type: 'bar',
      data: barChartData,
      options: barChartOptions
    })
  
  
  //calendario
  
  $(function () {

    /* initialize the external events
     -----------------------------------------------------------------*/
    function ini_events(ele) {
        
      ele.each(function () {

        // create an Event Object (https://fullcalendar.io/docs/event-object)
        // it doesn't need to have a start or end
        var eventObject = {
          title: $.trim($(this).text()) // use the element's text as the event title
        }

        // store the Event Object in the DOM element so we can get to it later
        $(this).data('eventObject', eventObject)

        // make the event draggable using jQuery UI
        $(this).draggable({
          zIndex        : 1070,
          revert        : true, // will cause the event to go back to its
          revertDuration: 0  //  original position after the drag
        })

      })
    }

    ini_events($('#external-events div.external-event'))

    /* initialize the calendar
     -----------------------------------------------------------------*/
    //Date for the calendar events (dummy data)
    var date = new Date()
    var d    = date.getDate(),
        m    = date.getMonth(),
        y    = date.getFullYear()

    var Calendar = FullCalendar.Calendar;
    var Draggable = FullCalendar.Draggable;

    var containerEl = document.getElementById('external-events');
    var checkbox = document.getElementById('drop-remove');
    var calendarEl = document.getElementById('calendar');

    // initialize the external events
    // -----------------------------------------------------------------

    new Draggable(containerEl, {
      itemSelector: '.external-event',
      eventData: function(eventEl) {
        return {
          title: eventEl.innerText,
          backgroundColor: window.getComputedStyle( eventEl ,null).getPropertyValue('background-color'),
          borderColor: window.getComputedStyle( eventEl ,null).getPropertyValue('background-color'),
          textColor: window.getComputedStyle( eventEl ,null).getPropertyValue('color'),
        };
      }
    });
    <?php
            $aux='';
            foreach($agenda as $item){
                $d=date('Y-m-d',strtotime($item->data));
                $h=date('H:i',strtotime($item->data));
                if($h=='00:00' || $h==null){
                  $allDay='true';
                }else{$allDay='false';}
                $aux.="{
                      title          : '$item->titulo',
                      start          : '$item->data',
                      backgroundColor: '$item->cor', 
                      borderColor    : '$item->cor',
                      allDay         : $allDay,
                      id             : '$item->id',
                      descricao      : '$item->descricao',
                      data           : '$d',
                      hora           : '$h',
                      forcli         : '$item->id_for_cli'
                    },";
            }
          ?>



    var calendar = new Calendar(calendarEl, {
      headerToolbar: {
        left  : 'prev,next today',
        center: 'title',
        right : 'dayGridMonth,timeGridWeek,timeGridDay'
      },eventClick: function(info) {
        //alert('Event: ' + info.event.title);
        //alert('Coordinates: ' + info.jsEvent.pageX + ',' + info.jsEvent.pageY);
        //alert('View: ' + info.view.type);
    
        // change the border color just for fun
        document.getElementById("titulo_evento_modal").value=info.event.title;
        document.getElementById("data_evento_modal").value=info.event._def.extendedProps.data;
        document.getElementById("hora_evento_modal").value=info.event._def.extendedProps.hora;
        document.getElementById("cor_evento_modal").value=info.event.backgroundColor;
        texto=info.event._def.extendedProps.descricao;
        texto = texto.replace(/<br\s*[\/]?>/gi, "\r");
        document.getElementById("desc_evento_modal").value=texto;
        $("#for_cli_evento_modal").val(info.event._def.extendedProps.forcli).trigger('change');
        document.getElementById("id_evento_modal").value=info.event.id;
        $("#calendario_modal").modal();
        //info.el.style.borderColor = 'red';
      },
      eventDrop: function(info) {
        id_evento=info.event.id;
        hora=info.event._def.extendedProps.hora;
        data_nova=moment.utc(info.event.start.toISOString()).format('YYYY-MM-DD'); 
        data_evento=data_nova+' '+hora+':00';
        $.ajax({
        url:"{{env('APP_URL')}}/add_agenda",
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        type: 'post',
        data: { 
                'id_evento_modal'   :id_evento,
                'data_evento_modal' :data_evento,
                'titulo_evento_modal':info.event.title,
                'tipo'              : 'drop',
                'cor_evento_modal'  :info.event.backgroundColor
        },
        dataType: 'json',
        success: function(response){
              if(response.status){
                //document.location.reload(true);
              }else{
                alert('Erro.');
              }
          }
      });
        
      },
      timeZone: 'UTC',
      themeSystem: 'bootstrap',
      //Random default events
      events: [<?php echo $aux;?>],
      editable  : true,
      locale    : 'pt-br',
      droppable : true, // this allows things to be dropped onto the calendar !!!
      drop      : function(info) {
          
        // is the "remove after drop" checkbox checked?
        if (checkbox.checked) {
          // if so, remove the element from the "Draggable Events" list
          info.draggedEl.parentNode.removeChild(info.draggedEl);
          
        }
      }
      
      
      
    });

    calendar.render();
    // $('#calendar').fullCalendar()

    /* ADDING EVENTS */
    var currColor = '#3c8dbc' //Red by default
    // Color chooser button
    $('#color-chooser > li > a').click(function (e) {
      e.preventDefault()
      // Save color
      currColor = $(this).css('color')
      // Add color effect to button
      $('#add-new-event').css({
        'background-color': currColor,
        'border-color'    : currColor
      })
    })
    $('#add-new-event').click(function (e) {
      e.preventDefault()
      // Get value and make sure it is not null
      var val = $('#new-event').val()
      if (val.length == 0) {
        return
      }
      var val2 = $('#data_evento').val()
      if (val2.length == 0) {
        return
      }
      desc_evento=document.getElementById("desc_evento").value;
      for_cli_evento=document.getElementById("for_cli_evento").value;
      data_evento=document.getElementById("data_evento").value+' '+document.getElementById("hora_evento").value+':00';

    $.ajax({
        url:"{{env('APP_URL')}}/add_agenda",
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        type: 'post',
        data: {'cor_evento_modal' : currColor,
                'titulo_evento_modal' : val,
                'desc_evento_modal'   :desc_evento,
                'data_evento_modal'   :data_evento,
                'for_cli_evento_modal':for_cli_evento
        },
        dataType: 'json',
        success: function(response){
              if(response.status){
                document.location.reload(true);
                $('#new-event').val('');
                $('#data_evento').val('');
                $('#hora_evento').val('');
                $('#desc_evento').val('');
                $('#for_cli_evento').val('');
              }else{
                alert(response.message);
              }
          }
      });
      
    })
  })

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
              alert(response.message);
            }
        }
    });
  });
});

function del_evento(){
    id=document.getElementById("id_evento_modal").value;
    $.ajax({
      url:"{{env('APP_URL')}}/del_agenda",
      headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
      type: 'post',
      data: { 'id' : id
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
                alert('Erro.');
              }
          }
      });
    }
  });
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
                'status_cria_tarefas': 4,
                'data_cria_tarefas' : new Date().toISOString().slice(0, 10),
                'jsonLista':jsonLista
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
              console.log(response.status);
            }else{
              alert('Erro.');
            }
        }
    });
}
addid=1;
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
  document.getElementById('tituloModal').innerHTML = "Editar Lista";
  $("#modalTarefas").modal()
}

function novaLista(){
  document.getElementById("id_tarefas_modal").value='';
  document.getElementById("titulo_tarefas_modal").value='';
  document.getElementById('div_lista_tarefas_modal').innerHTML = "";
  document.getElementById('tituloModal').innerHTML = "Criar Lista";
  $("#modalTarefas").modal()
}
</script>
@endsection