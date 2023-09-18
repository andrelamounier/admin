<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>TiranossauroRex | ADMIN</title>
  @yield('style')
  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome Icons -->
  <link rel="stylesheet" href="{{env('APP_URL')}}/plugins/fontawesome-free/css/all.min.css">
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
  <!-- overlayScrollbars -->
  <link rel="stylesheet" href="{{env('APP_URL')}}/plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="{{env('APP_URL')}}/dist/css/adminlte.min.css">
  <link rel="stylesheet" href="{{env('APP_URL')}}/dist/css/bootstrap.css">
  <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<body class="hold-transition dark-mode sidebar-mini layout-fixed layout-navbar-fixed layout-footer-not-fixed">
<div class="wrapper" style="padding:55px 0px;">

    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
           
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>
    <section class="content">
        <div class="container-fluid" >
            <div class="row">
                <div class="col-12">
                    <div class="card" style="min-height:70vh;">
                        <div id="saldo_inicial">
                            <div class="card-header">
                            <h1>Termos de Uso</h1>
                            </div>    
                            <div class="card-body">
                                <h2><span>1. Termos</span></h2><p><span >Ao acessar ao site <a href="https://tiranossaurorex.com.br/admin">tiranossaurorex</a>, concorda em cumprir estes termos de serviço, todas as leis e regulamentos aplicáveis ​​e concorda que é responsável pelo cumprimento de todas as leis locais aplicáveis. Se você não concordar com algum desses termos, está proibido de usar ou acessar este site. Os materiais contidos neste site são protegidos pelas leis de direitos autorais e marcas comerciais aplicáveis.</span></p><h2><span >2. Uso de Licença</span></h2><p><span >É concedida permissão para baixar temporariamente uma cópia dos materiais (informações ou software) no site tiranossaurorex , apenas para visualização transitória pessoal e não comercial. Esta é a concessão de uma licença, não uma transferência de título e, sob esta licença, você não pode:&nbsp;</span></p><ol><li><span >modificar ou copiar os materiais;&nbsp;</span></li><li><span >usar os materiais para qualquer finalidade comercial ou para exibição pública (comercial ou não comercial);&nbsp;</span></li><li><span >tentar descompilar ou fazer engenharia reversa de qualquer software contido no site tiranossaurorex;&nbsp;</span></li><li><span >remover quaisquer direitos autorais ou outras notações de propriedade dos materiais; ou&nbsp;</span></li><li><span >transferir os materiais para outra pessoa ou 'espelhe' os materiais em qualquer outro servidor.</span></li></ol><p><span >Esta licença será automaticamente rescindida se você violar alguma dessas restrições e poderá ser rescindida por tiranossaurorex a qualquer momento. Ao encerrar a visualização desses materiais ou após o término desta licença, você deve apagar todos os materiais baixados em sua posse, seja em formato eletrónico ou impresso.</span></p><h2><span >3. Isenção de responsabilidade</span></h2><ol><li><span >Os materiais no site da tiranossaurorex são fornecidos 'como estão'. tiranossaurorex não oferece garantias, expressas ou implícitas, e, por este meio, isenta e nega todas as outras garantias, incluindo, sem limitação, garantias implícitas ou condições de comercialização, adequação a um fim específico ou não violação de propriedade intelectual ou outra violação de direitos.</span></li><li><span >Além disso, o tiranossaurorex não garante ou faz qualquer representação relativa à precisão, aos resultados prováveis ​​ou à confiabilidade do uso dos materiais em seu site ou de outra forma relacionado a esses materiais ou em sites vinculados a este site.</span></li></ol><h2><span >4. Limitações</span></h2><p><span >Em nenhum caso o tiranossaurorex ou seus fornecedores serão responsáveis ​​por quaisquer danos (incluindo, sem limitação, danos por perda de dados ou lucro ou devido a interrupção dos negócios) decorrentes do uso ou da incapacidade de usar os materiais em tiranossaurorex, mesmo que tiranossaurorex ou um representante autorizado da tiranossaurorex tenha sido notificado oralmente ou por escrito da possibilidade de tais danos. Como algumas jurisdições não permitem limitações em garantias implícitas, ou limitações de responsabilidade por danos conseqüentes ou incidentais, essas limitações podem não se aplicar a você.</span></p><h2><span >5. Precisão dos materiais</span></h2><p><span >Os materiais exibidos no site da tiranossaurorex podem incluir erros técnicos, tipográficos ou fotográficos. tiranossaurorex não garante que qualquer material em seu site seja preciso, completo ou atual. tiranossaurorex pode fazer alterações nos materiais contidos em seu site a qualquer momento, sem aviso prévio. No entanto, tiranossaurorex não se compromete a atualizar os materiais.</span></p><h2><span >6. Links</span></h2><p><span >O tiranossaurorex não analisou todos os sites vinculados ao seu site e não é responsável pelo conteúdo de nenhum site vinculado. A inclusão de qualquer link não implica endosso por tiranossaurorex do site. O uso de qualquer site vinculado é por conta e risco do usuário.</span></p><p><br></p><h3><span >Modificações</span></h3><p><span >O tiranossaurorex pode revisar estes termos de serviço do site a qualquer momento, sem aviso prévio. Ao usar este site, você concorda em ficar vinculado à versão atual desses termos de serviço.</span></p><h3><span >Lei aplicável</span></h3><p><span >Estes termos e condições são regidos e interpretados de acordo com as leis do tiranossaurorex e você se submete irrevogavelmente à jurisdição exclusiva dos tribunais naquele estado ou localidade.</span></p>
                            </div>
                        </div>
                        
                    </div>
                </div>
            </div>
        </div>
    </section>
  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->

  <!-- Main Footer -->
  <footer class="main-footer">
    <strong>TiranossauroRex All rights reserved.
  </footer>
</div>
<!-- ./wrapper -->

<!-- REQUIRED SCRIPTS -->

<!-- jQuery -->
<script src="{{env('APP_URL')}}/plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap -->
<script src="{{env('APP_URL')}}/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- overlayScrollbars -->
<script src="{{env('APP_URL')}}/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
<!-- AdminLTE App -->
<script src="{{env('APP_URL')}}/dist/js/adminlte.js"></script>

<!-- PAGE PLUGINS -->
<!-- ChartJS -->
<script src="{{env('APP_URL')}}/plugins/chart.js/Chart.min.js"></script>

<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://igorescobar.github.io/jQuery-Mask-Plugin/js/jquery.mask.min.js"></script>  
<script src="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.12.6/js/standalone/selectize.min.js"></script>


@yield('scripts')
</body>
</html>