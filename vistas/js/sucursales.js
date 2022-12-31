var tabla;

//Función que se ejecuta al inicio
function init(){
	mostrarform(false);
	listar();

	$("#myModal").on("submit",function(e)
	{
		guardaryeditar(e);	
	});
	
    $('#navConfiguracion').addClass("treeview active");
    $('#navSucursalesLi').addClass("active");

	comprobantes();

}

//Función limpiar
function limpiar()
{
	$("#nombre").val("");
	$("#idsucursal").val("");
	$("#direccion").val("");
	$("#telefono").val("");
	$("#distrito").val("");
	$("#provincia").val("");
	$("#departamento").val("");
	$("#ubigeo").val("");
}

//Función mostrar formulario
function mostrarform(flag)
{
	limpiar();
	if (flag)
	{
		$("#listadoregistros").show();
		$('#myModal').modal('show');
	}
	else
	{
		$("#listadoregistros").show();
		$("#btnagregar").show();
	}
}

function comprobantes(){

	var fila='<tr class="filas" id="fila">'+
        '<td><input style="text-align:center; width: 150px;" type="text" name="nombreSucursal[]" id="nombreSucursal[]" value="Boleta"></td>'+
        '<td><input style="text-align:center; width: 80px;" type="text" name="serie[]" id="serie[]" value="000"></td>'+    
        '<td><input style="text-align:center; width: 80px;" type="text" name="numero[]" id="numero[]" value="9999999"></td>'+
		'</tr>';

	var fila1='<tr class="filas" id="fila">'+
        '<td><input style="text-align:center; width: 150px;" type="text" name="nombreSucursal[]" id="nombreSucursal[]" value="Factura"></td>'+
        '<td><input style="text-align:center; width: 80px;" type="text" name="serie[]" id="serie[]" value="000"></td>'+    
        '<td><input style="text-align:center; width: 80px;" type="text" name="numero[]" id="numero[]" value="9999999"></td>'+
		'</tr>';

	var fila2='<tr class="filas" id="fila">'+
        '<td><input style="text-align:center; width: 150px;" type="text" name="nombreSucursal[]" id="nombreSucursal[]" value="Nota de Venta"></td>'+
        '<td><input style="text-align:center; width: 80px;" type="text" name="serie[]" id="serie[]" value="000"></td>'+    
        '<td><input style="text-align:center; width: 80px;" type="text" name="numero[]" id="numero[]" value="9999999"></td>'+
		'</tr>';

	var fila3='<tr class="filas" id="fila">'+
        '<td><input style="text-align:center; width: 150px;" type="text" name="nombreSucursal[]" id="nombreSucursal[]" value="Cotización"></td>'+
        '<td><input style="text-align:center; width: 80px;" type="text" name="serie[]" id="serie[]" value="000"></td>'+    
        '<td><input style="text-align:center; width: 80px;" type="text" name="numero[]" id="numero[]" value="9999999"></td>'+
		'</tr>';

	var fila4='<tr class="filas" id="fila">'+
        '<td><input style="text-align:center; width: 150px;" type="text" name="nombreSucursal[]" id="nombreSucursal[]" value="NC"></td>'+
        '<td><input style="text-align:center; width: 80px;" type="text" name="serie[]" id="serie[]" value="000"></td>'+    
        '<td><input style="text-align:center; width: 80px;" type="text" name="numero[]" id="numero[]" value="9999999"></td>'+
		'</tr>';

	var fila5='<tr class="filas" id="fila">'+
        '<td><input style="text-align:center; width: 150px;" type="text" name="nombreSucursal[]" id="nombreSucursal[]" value="NCB"></td>'+
        '<td><input style="text-align:center; width: 80px;" type="text" name="serie[]" id="serie[]" value="000"></td>'+    
        '<td><input style="text-align:center; width: 80px;" type="text" name="numero[]" id="numero[]" value="9999999"></td>'+
		'</tr>';

		$('#detalles').append(fila + fila1 + fila2 + fila3 + fila4 + fila5);

}

//Función cancelarform
function cancelarform()
{
	limpiar();
	mostrarform(false);
}

//Función Listar
function listar()
{
	tabla=$('#tbllistado').dataTable(
	{
		//"lengthMenu": [ 5, 10, 25, 75, 100],//mostramos el menú de registros a revisar
		"aProcessing": true,//Activamos el procesamiento del datatables
	    "aServerSide": true,//Paginación y filtrado realizados por el servidor
	    "processing": true,
	    "language": 
		{          
		"processing": "<img style='width:80px; height:80px;' src='../files/plantilla/loading-page.gif' />",
		},
	    dom: 'Bfrtip',//Definimos los elementos del control de tabla
		lengthMenu: [
            [5,10, 25, 50, 100, -1],
            ['5 filas','10 filas', '25 filas', '50 filas','100 filas', 'Mostrar todo']
        ],
        buttons: ['pageLength','copy','excel', 'pdf'],
		"ajax":
				{
					url: '../controladores/sucursal.php?op=listarSucursales',
					type : "get",
					dataType : "json",						
					error: function(e){
						console.log(e.responseText);	
					}
				},
		"bDestroy": true,
		"iDisplayLength": 5,//Paginación
	    "order": [[ 0, "desc" ]]//Ordenar (columna,orden)
	}).DataTable();
}
//Función para guardar o editar

function guardaryeditar(e)
{
	e.preventDefault(); //No se activará la acción predeterminada del evento
	//$("#btnGuardar").prop("disabled",true);
	var formData = new FormData($("#formulario")[0]);

	$.ajax({
		url: "../controladores/sucursal.php?op=guardaryeditar",
	    type: "POST",
	    data: formData,
	    contentType: false,
	    processData: false,

	    success: function(datos)
	    {                    
	          swal({
				  title: 'Sucursal',
				  type: 'success',
					text:datos
				});
              $('#myModal').modal('hide');
              	          
	          mostrarform(false);
	          tabla.ajax.reload();


	    }

	});
	limpiar();
	//location.reload();
}

function mostrar(idsucursal)
{
	$.post("../controladores/sucursal.php?op=mostrarSucursal",{idsucursal : idsucursal}, function(data, status)
	{
		data = JSON.parse(data);		
		mostrarform(true);

		$("#nombre").val(data.nombre);
		$("#direccion").val(data.direccion);
		$("#telefono").val(data.telefono);
		$("#idsucursal").val(data.idsucursal);
		$("#distrito").val(data.distrito);
		$("#provincia").val(data.provincia);
		$("#departamento").val(data.departamento);
		$("#ubigeo").val(data.ubigeo);

 	})
}

//Función para desactivar registros
function desactivar(idcategoria)
{
	swal({
						    title: "¿Desactivar?",
						    text: "¿Está seguro Que Desea Desactivar la Categoria?",
						    type: "warning",
						    showCancelButton: true,
								cancelButtonText: "No",
								cancelButtonColor: '#FF0000',
						    confirmButtonText: "Si",
						    confirmButtonColor: "#0004FA",
						    closeOnConfirm: false,
						    closeOnCancel: false,
						    showLoaderOnConfirm: true
						    },function(isConfirm){
						    if (isConfirm){
									$.post("../controladores/categoria.php?op=desactivar", {idcategoria : idcategoria}, function(e){
										swal(
											'!!! Desactivada !!!',e,'success')
					            tabla.ajax.reload();
				        	});
						    }else {
						    swal("! Cancelado ¡", "Se Cancelo la desactivacion de la Categoria", "error");
							 }
							});
}

//Función para activar registros
function activar(idcategoria)
{
	swal({
		    title: "¿Activar?",
		    text: "¿Está seguro Que desea Activar la Categoria?",
		    type: "warning",
		    showCancelButton: true,
				confirmButtonColor: '#0004FA',
				confirmButtonText: "Si",
		    cancelButtonText: "No",
				cancelButtonColor: '#FF0000',
		    closeOnConfirm: false,
		    closeOnCancel: false,
		    showLoaderOnConfirm: true
		    },function(isConfirm){
		    if (isConfirm){
						$.post("../controladores/categoria.php?op=activar", {idcategoria : idcategoria}, function(e){
						swal("!!! Activada !!!", e ,"success");
								tabla.ajax.reload();
						});
		    }else {
		    swal("! Cancelado ¡", "Se Cancelo la activacion de la Categoria", "error");
			 }
			});
}


init();