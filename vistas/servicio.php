<?php
ob_start();
session_start();
//si la ariable de sesion no existe
if (!isset($_SESSION["idpersonal"])) {
  header("Location: ../index.php");
} else {
  require 'modulos/header.php';
  if ($_SESSION['almacen'] == 1) {
?>
    <!--Contenido-->
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">

      <section class="content-header">
        <br>
        <ol class="breadcrumb">

          <li><a href="inicio.php"><i class="fa fa-dashboard"></i> Inicio</a></li>

          <li class="active">Administrar Servicios</li>

        </ol>
      </section>
      <!-- Main content -->
      <section class="content">
        <div class="panel panel-default" style="border-color: #666; border-width: 3px; border-style: double;">

          <div class="panel-heading">
            <div class="box-header with-border">
              <h1 class="box-title">Servicios</h1>
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
            <a href="../reportes/rptproductos.php" target="_blank"><button class="btn btn-danger"><i class="fa fa-file"></i> Reporte</button></a>

            <!-- <a data-toggle="modal" data-target="#traslados" target="_blank"><button class="btn btn-danger" style="float: right; margin-left: 5px;"><i class="fa fa-file"></i> Traslados</button></a> -->

            <!-- <a data-toggle="modal" data-target="#desempaquetar" target="_blank"><button class="btn btn-success" style="float: right; margin-left: 5px;" onclick="llenarProductos()"><i class="fa fa-file"></i> Desempaquetar</button></a> -->

            <br><br>

            <div class="form-group col-lg-3 col-md-3 col-sm-3 col-xs-12">
              <label>Almacén:</label>
              <select id="idsucursal2" name="idsucursal2" class="form-control selectpicker" data-live-search="true" onchange="DocumentosPendientes2();">
              </select>
            </div>

            <table id="tbllistado" class="table table-striped table-bordered table-condensed table-hover" width="100%">
              <thead>
                <th>Nombre</th>
                <th style="width:10px">UM</th>
                <th>Categoría</th>
                <th>Almacén</th>
                <th>Código</th>
                <th>P. Venta</th>
                <th>Fecha Creación</th>
                <th>Imagen</th>
                <th>Estado</th>
                <th>Acciones</th>
              </thead>
              <tbody>
              </tbody>
              <tfoot>
                <th>Nombre</th>
                <th style="width:10px">UM</th>
                <th>Categoría</th>
                <th>Almacén</th>
                <th>Código</th>
                <th>P. Venta</th>
                <th>Fecha Creación</th>
                <th>Imagen</th>
                <th>Estado</th>
                <th>Acciones</th>
              </tfoot>
            </table>
          </div>
        </div>
      </section>

    </div><!-- /.content-wrapper -->
    <!--Fin-Contenido-->

    <!-- Modal -->
    <div class="modal fade" id="myModal" tabindex="-1" role="dialog">

      <div class="modal-dialog" style="width: 650px">

        <div class="modal-content">
          <!-- form -->
          <form class="form-horizontal" role="form" name="formulario" id="formulario" method="POST">

            <div class="modal-header" style="background:#3c8dbc; color:white">
              <button type="button" class="close" data-dismiss="modal" aria-hidden="true" onclick="limpiar()">&times;</button>
              <h4 class="modal-title">
                Servicios</h4>
            </div>

            <div class="modal-body">

              <div class="form-group">

                <label for="name" class="col-sm-2 control-label">Nombre:</label>
                <div class="col-sm-10">
                  <input type="hidden" name="idproducto" id="idproducto">
                  <input type="text" class="form-control" name="nombre" id="nombre" maxlength="100" placeholder="Nombre" required>
                </div>
                
              </div>

              <div class="form-group">

                <label for="name" class="col-sm-2 control-label">Almacén:</label>
                <div class="col-sm-4">
                  <select id="idsucursal" name="idsucursal" class="form-control selectpicker" data-live-search="true">
                  </select>
                </div>

                <label for="name" class="col-sm-2 control-label">Categoría: </label>
                <div class="col-sm-4">
                  <select id="idcategoria" name="idcategoria" class="form-control selectpicker" data-live-search="true" required></select>
                </div>
              </div>

              <div class="form-group">

                <label for="name" class="col-sm-2 control-label">Unidad de Medida </label>
                <div class="col-sm-4">
                  <select id="idunidad_medida" name="idunidad_medida" class="form-control selectpicker" data-live-search="true" required></select>
                </div>

                <label for="name" class="col-sm-2 control-label" hidden>Stock:</label>
                <div class="col-sm-4" hidden>
                  <input type="number" class="form-control" name="stock" id="stock" value="1">
                </div>

              </div>

              <div class="form-group">

                <label for="name" class="col-sm-2 control-label" hidden>Stock Mínimo:</label>
                <div class="col-sm-2" hidden>
                  <input type="number" class="form-control" name="stockMinimo" id="stockMinimo" value="5" required>
                </div>

                <label for="name" class="col-sm-2 control-label">Descripción: </label>
                <div class="col-sm-6">
                  <textarea type="text" class="form-control" name="descripcion" id="descripcion" cols="50">
                  </textarea>
                </div>

              </div>

              <div class="form-group">
                <label for="name" class="col-sm-2 control-label">Imagen:</label>
                <div class="col-sm-7">
                  <input type="file" class="form-control" name="imagen" id="imagen">
                  <input type="hidden" name="imagenactual" id="imagenactual">
                  <img src="" class="img-thumbnail" id="imagenmuestra" width="100px">
                </div>
              </div>

              <div class="form-group">
                <label for="name" class="col-sm-2 control-label">Código:</label>
                <div class="col-sm-7">
                  <input type="text" class="form-control" name="codigo" id="codigo" placeholder="Código Barras">
                  <button class="btn btn-success" type="button" onclick="generarbarcode()">Generar</button>
                  <button class="btn btn-info" type="button" onclick="imprimir()"><i class="fa fa-print"></i></button>
                  <div id="print">
                    <svg id="barcode"></svg>
                  </div>
                </div>
              </div>

              <div class="form-group col-12">
                <label for="name" class="col-sm-2 control-label">Precio de Venta</label>
                <div class="col-sm-4">
                  <input type="number" step="any" class="form-control" name="precio" id="precio" required>
                </div>

                <label for="name" class="col-sm-2 control-label" hidden>Precio de Compra:</label>
                <div class="col-sm-4" hidden>
                  <input type="number" step="any" class="form-control" name="precioCompra" id="precioCompra">
                </div>

              </div>

              <div class="form-group col-12" hidden>

                <label for="name" class="col-sm-2 control-label">N° Serie:</label>
                <div class="col-sm-4">
                  <input type="text" class="form-control" name="nserie" id="nserie" placeholder="Ingrese N° serie">
                </div>


              </div>

              <div class="form-group col-12">

                <label for="name" class="col-sm-2 control-label">Precio B:</label>
                <div class="col-sm-2">
                  <input type="number" step="any" class="form-control" name="precioB" id="precioB">
                </div>

                <label for="name" class="col-sm-2 control-label">Precio C:</label>
                <div class="col-sm-2">
                  <input type="number" step="any" class="form-control" name="precioC" id="precioC">
                </div>

                <label for="name" class="col-sm-2 control-label">Precio D:</label>
                <div class="col-sm-2">
                  <input type="number" step="any" class="form-control" name="precioD" id="precioD">
                </div>

              </div>

              <div class="form-group col-6">

                <label for="name" class="col-sm-2 control-label" hidden>Fecha de Vencimiento:</label>
                <div class="col-sm-4" hidden>
                  <input style="border-color: #99C0E7; text-align:center" class="form-control pull-right" type="date" name="fecha_hora" id="fecha_hora">
                </div>

                <label for="name" class="col-sm-2 control-label">Tipo Igv:</label>
                <div class="col-sm-4">
                  <div class="input-group">
                    <select id="tipoigv" name="tipoigv" class="form-control" data-live-search="true" required>
                      <option value="Gravada">Gravada</option>
                      <option value="No Gravada">No Gravada</option>
                    </select>
                  </div>
                </div>

              </div>

              <div class="form-group">
                <label for="name" class="col-sm-3 control-label">Sucursales:</label>
                <div class="col-sm-6">
                  <ul style="list-style: none;" id="sucursales">

                  </ul>
                </div>
              </div>

            </div>

            <div class="modal-footer">
              <button type="button" onclick="cancelarform()" class="btn btn-danger pull-left" data-dismiss="modal"><i class="fa fa-times"></i> Cerrar</button>
              <button class="btn btn-primary" id="btnGuardar"><i class="fa fa-save"></i> Guardar</button>
            </div>
          </form>
        </div>
      </div>
    </div>

    <!-- Modal Importar Productos -->

    

    <!-- Fin modal -->

    <div class="modal fade" id="desempaquetar" tabindex="-1" role="dialog">

      <div class="modal-dialog" style="width: 800px">

        <div class="modal-content">
          <!-- form -->
          <form class="form-horizontal" role="form" name="formularioDesempaquetar" id="formularioDesempaquetar" method="POST">

            <div class="modal-header" style="background:#3c8dbc; color:white">
              <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
              <h4 class="modal-title">
                DESEMPAQUETAR PRODUCTOS</h4>
            </div>

            <div class="modal-body">
              <div class="alert" style="background: #E0F7FA;">
                <strong><i class="fa fa-info"></i> Info!</strong> DESEMPAQUETAR: <label for="documento" id="documento"></label> Para hacer uso de este módulo <label for="deudaTotal" id="deutaTotal"></label>, debe tener en claro el producto empaquetado y el producto al cual se le va a asignar lo desempaquetado.</i></a>
              </div>

              <div class="form-group">

                <label for="name" class="col-sm-2 control-label">Producto a Desempaquetar: </label>
                <div class="col-sm-4">
                  <select id="idproductoE" name="idproductoE" class="form-control selectpicker" data-live-search="true" title="Seleccione Producto" onchange="stockProductoE()" required></select>
                </div>

                <label for="name" class="col-sm-2 control-label">Producto Asignado: </label>
                <div class="col-sm-4">
                  <select id="idproductoD" name="idproductoD" class="form-control selectpicker" data-live-search="true" title="Seleccione Producto" onchange="stockProductoD()" required></select>
                </div>

              </div>

              <div class="form-group">
                <label for="name" class="col-sm-2 control-label">Cantidad a Desempaquetar:</label>
                <div class="col-sm-4">
                  <input type="hidden" name="productoE" id="productoE">
                  El Producto tiene <label id="productoDesempaquetar" name="productoDesempaquetar">0</label>
                  <input type="text" class="form-control" name="cantidadE" id="cantidadE" placeholder="Cantidad" required>
                </div>
                
              </div>

              <div class="form-group">

                <label for="name" class="col-sm-2 control-label">¿Cuántos Productos Contiene?</label>
                <div class="col-sm-4">
                  <input type="hidden" name="productoD" id="productoD">
                  <input type="text" class="form-control" name="cantidadD" id="cantidadD" placeholder="Cantidad" required>
                </div>
              </div>

            </div>

            <div class="modal-footer">
              <button type="button" onclick="limpiarDesempaquetado()" class="btn btn-danger pull-left" data-dismiss="modal"><i class="fa fa-times"></i> Cerrar</button>
              <button class="btn btn-primary" type="submit"><i class="fa fa-save"></i> Guardar</button>
            </div>
          </form>
        </div>
      </div>
    </div>

    <div class="modal fade" id="traslados" tabindex="-1" role="dialog">

      <div class="modal-dialog" style="width: 800px">

        <div class="modal-content">
          <!-- form -->
          <form class="form-horizontal" role="form" name="formularioTraslados" id="formularioTraslados" method="POST">

            <div class="modal-header" style="background:#3c8dbc; color:white">
              <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
              <h4 class="modal-title">
                TRASLADAR PRODUCTOS</h4>
            </div>

            <div class="modal-body">
              <div class="alert" style="background: #E0F7FA;">
                <strong><i class="fa fa-info"></i> Info!</strong> TRASLADAR: <label for="documento" id="documento"></label> Para hacer uso de este módulo, debe tener en claro el producto a TRASLADAR a un almacén específico.</i></a>
              </div>

              <div class="form-group">

                <label for="name" class="col-sm-2 control-label">Almacén Origen: </label>
                <div class="col-sm-4">
                      <select id="idsucursal3" name="idsucursal3" class="form-control selectpicker" data-live-search="true" onchange="cargarComboProductos();" title="Seleccione Almacén de Origen">
                      </select>
                </div>

                <label for="name" class="col-sm-2 control-label">Almacén Destino: </label>
                <div class="col-sm-4">
                      <select id="idsucursal4" name="idsucursal4" class="form-control selectpicker" data-live-search="true" onchange="cargarComboProductos2();" title="Seleccione Almacén de Destino">
                      </select>
                </div>

              </div>

              <div class="form-group">
                <label for="name" class="col-sm-2 control-label">Producto:</label>
                <div class="col-sm-4">
                    <select id="idproducto2" name="idproducto2" class="form-control selectpicker" data-live-search="true">
                    </select>
                </div>

                <label for="name" class="col-sm-2 control-label">Producto:</label>
                <div class="col-sm-4">
                    <select id="idproducto3" name="idproducto3" class="form-control selectpicker" data-live-search="true">
                    </select>
                </div>
                
              </div>

              <div class="form-group">

                <label for="name" class="col-sm-2 control-label">¿Cantidad de Productos a Trasladar?</label>
                <div class="col-sm-4">
                  <input type="text" class="form-control" name="cantidadT" id="cantidadT" placeholder="Cantidad" required>
                </div>
              </div>

            </div>

            <div class="modal-footer">
              <button type="button" onclick="limpiarTraslado()" class="btn btn-danger pull-left" data-dismiss="modal"><i class="fa fa-times"></i> Cerrar</button>
              <button class="btn btn-primary" type="submit"><i class="fa fa-save"></i> Guardar</button>
            </div>
          </form>
        </div>
      </div>
    </div>

    <div id="getCodeModal" class="modal fade" role="dialog">
      <div class="modal-dialog modal-lg">
        <!-- Modal content-->
        <div class="modal-content panel panel-primary">

          <div class="modal-header panel-heading">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title"><span id="titulo-formulario">Vista</span> de Kardex</h4>
          </div>
          <div class="modal-body panel-body">
            <input type="hidden" id="txtCodigoSeleccionado">

            <div class="form-group col-lg-3">
              <label class="col-form-label">Código (*)</label>
              <input type="text" class="form-control" id="codigoProducto" readonly>
            </div>

            <div class="form-group col-lg-5">
              <label class="col-form-label">Producto</label>
              <input class="form-control" type="text" name="producto" id="producto" maxlength="7" readonly>
            </div>

            <div class="form-group col-lg-12 col-md-12 col-xs-12">
              <table id="tbllistadoKardex" class="table table-striped table-bordered table-condensed table-hover dataTable" cellpadding="0" cellspacing="0" aria-describedby="tblIngresos_info" width="100%" role="grid" style="width: 100%;">
                  <thead>
                    <th>Fecha</th>
                    <th>Transacción</th>
                    <th>Documento</th>
                    <th>Entrada</th>
                    <th>Salida</th>
                    <th>Precio</th>
                    <th>Valor</th>
                    <th>Stock Actual</th>
                    <th>Valor Existrencia</th>
                  </thead>
                  <tbody>
                  </tbody>
                  <tfoot>
                    <th>Fecha</th>
                    <th>Transacción</th>
                    <th>Documento</th>
                    <th>Entrada</th>
                    <th>Salida</th>
                    <th>Precio</th>
                    <th>Valor</th>
                    <th>Stock Actual</th>
                    <th>Valor Existrencia</th>
                  </tfoot>
                </table>
            </div>
          </div>
          <div class="modal-footer panel-footer">
            <button type="button" class="btn btn-danger pull-left" data-dismiss="modal"><i class="fa fa-times"></i> Cancelar</button>
          </div>
        </div>
      </div>
    </div>

  <?php
  } else {
    require 'noacceso.php';
  }
  require 'modulos/footer.php';
  ?>
  <script type="text/javascript" src="../public/js/JsBarcode.all.min.js"></script>
  <script type="text/javascript" src="../public/js/jquery.PrintArea.js"></script>
  <script type="text/javascript" src="js/servicio.js"></script>
  <script type="text/javascript" src="js/stocksbajos.js"></script>
  <script>
    document.getElementById("txt_archivo").addEventListener("change", () => {

      var fileName = document.getElementById("txt_archivo").value;
      var idxDot = fileName.lastIndexOf(".") + 1;
      var extFile = fileName.substr(idxDot, fileName.length).toLowerCase();
      if (extFile == "xlsx" || extFile == "xlsb") {

      } else {
        swal({
          title: "Error al subir el archivo",
          text: "Solo se acpetan archivos excel",
          type: "error",
          confirmButtonText: "¡Cerrar!"
        });
        document.getElementById("txt_archivo").value = "";
      }

    });
  </script>
<?php
}
ob_end_flush();
?>