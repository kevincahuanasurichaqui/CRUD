<?php
ob_start();
session_start();
//si la ariable de sesion no existe
if (!isset($_SESSION["idpersonal"])) {
  header("Location: ../index.php");
} else {
  require 'modulos/header.php';
  //Usuario revisa el contenido
  if ($_SESSION['almacen'] == 1) {
?>
    <!--Contenido-->
    <!-- Content Wrapper. Contains page content -->
    <!-- /.content-wrapper -->
    <!--Fin-Contenido-->
    <div class="content-wrapper">
      <section class="content-header">
        <br>
        <ol class="breadcrumb">

          <li><a href="inicio
        .php"><i class="fa fa-dashboard"></i> Inicio</a></li>

          <li class="active">Administrar sucursales</li>

        </ol>
      </section>
      <section class="content">
        <div class="panel panel-default" style="border-color: #666; border-width: 3px; border-style: double;">
          <div class="panel-heading">
            <div class="box-header with-border">
              <h1 class="box-title">Sucursales  </h1>
              <div class="box-tools pull-right">
                <button class="btn btn-box-tool" data-widget="collapse">
                  <i class="fa fa-minus"></i>
                </button>
                <button class="btn btn-box-tool" data-widget="remove">
                  <i class="fa fa-times"></i>
                </button>
              </div>

            </div>
          </div>

          <div class="panel-body table-responsive" class="box-body" id="listadoregistros">
            <button class="btn btn-primary" data-toggle="modal" data-target="#myModal"><i class="fa fa-plus"> Nuevo</i>
            </button>
            <br><br>
            <table id="tbllistado" class="table table-striped table-bordered table-condensed table-hover" width="100%">
              <thead>
                <th>Almacén</th>
                <th>Acciones</th>
              </thead>
              <tbody>
              </tbody>
              <tfoot>
                <th>Nombre</th>
                <th>Acciones</th>
              </tfoot>
            </table>
          </div>
        </div>
      </section>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="myModal" tabindex="-1" role="dialog">

      <div class="modal-dialog" style="width: 480px">

        <div class="modal-content">
          <!-- form -->
          <form class="form-horizontal" role="form" name="formulario" id="formulario" method="POST">

            <div class="modal-header" style="background:#3c8dbc; color:white">
              <button type="button" class="close" data-dismiss="modal" aria-hidden="true" onclick="cancelarform();">&times;</button>
              <h4 class="modal-title">
                Sucursales</h4>
            </div>

            <div class="modal-body">
              <div class="form-group">
                <label for="name" class="col-sm-2 control-label">Nombre:</label>
                <div class="col-sm-10">
                  <input type="hidden" name="idsucursal" id="idsucursal">
                  <input type="text" class="form-control" name="nombre" id="nombre" placeholder="Nombre" required>
                </div>
              </div>

              <div class="form-group">
                <label for="name" class="col-sm-2 control-label">Dirección:</label>
                <div class="col-sm-10">
                  <input type="text" class="form-control" name="direccion" id="direccion" placeholder="Direccion" required>
                </div>
              </div>

              <div class="form-group">
                <label for="name" class="col-sm-2 control-label">Telefono:</label>
                <div class="col-sm-10">
                  <input type="text" class="form-control" name="telefono" id="telefono" maxlength="50" placeholder="Telefono" required>
                </div>
              </div>

              <div class="form-group">
                <label for="name" class="col-sm-2 control-label">Distrito:</label>
                <div class="col-sm-10">
                  <input type="text" class="form-control" name="distrito" id="distrito" maxlength="60" placeholder="Distrito" required>
                </div>
              </div>

              <div class="form-group">
                <label for="name" class="col-sm-2 control-label">Provincia:</label>
                <div class="col-sm-10">
                  <input type="text" class="form-control" name="provincia" id="provincia" maxlength="60" placeholder="Provincia" required>
                </div>
              </div>

              <div class="form-group">
                <label for="name" class="col-sm-2 control-label">Depto:</label>
                <div class="col-sm-10">
                  <input type="text" class="form-control" name="departamento" id="departamento" maxlength="60" placeholder="Departamento" required>
                </div>
              </div>

              <div class="form-group">
                <label for="name" class="col-sm-2 control-label">Ubigeo:</label>
                <div class="col-sm-10">
                  <input type="text" class="form-control" name="ubigeo" id="ubigeo" maxlength="50" placeholder="Ubigeo" required>
                </div>
              </div>

              <div class="col-lg-12 modal-body table-responsive">
                    <table id="detalles" class="table table-striped table-bordered table-condensed table-hover" width="100%">
                      <thead>
                        <th>Comprobante</th>
                        <th>Serie</th>
                        <th>Número</th>
                      </thead>
                      <tfoot>
                      </tfoot>
                      <tbody>

                      </tbody>
                    </table>

                  </div>
            </div>

            <div class="modal-footer">
              <button type="button" onclick="cancelarform()" class="btn btn-danger pull-left" data-dismiss="modal"><i class="fa fa-times"></i> Cerrar</button>
              <button class="btn btn-primary" type="submit" id="btnGuardar"><i class="fa fa-save"></i> Guardar</button>
            </div>
          </form>
        </div>
      </div>
    </div>
    <!-- Fin modal -->
  <?php
  } else {
    require 'noacceso.php';
  }
  require 'modulos/footer.php';
  ?>
  <script type="text/javascript" src="js/sucursales.js"></script>
  <script type="text/javascript" src="js/stocksbajos.js"></script>
<?php
}
ob_end_flush();
?>