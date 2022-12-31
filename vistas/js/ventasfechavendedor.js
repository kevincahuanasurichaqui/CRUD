var tabla;

//Función que se ejecuta al inicio
function init(){
	listar();

	//cargamos los items al select almacen
	$.post("../controladores/venta.php?op=selectSucursal3", function(r){
		$("#idsucursal2").html(r);
		$('#idsucursal2').selectpicker('refresh');
	});

	//Cargamos los items al select vendedor
	$.post("../controladores/venta.php?op=selectVendedor", function(r){
	$("#idcliente").html(r);
	$('#idcliente').selectpicker('refresh');
	});
	
	$('#navConsultaV').addClass("treeview active");
    $('#navConsultaVentasVLi').addClass("active");
}


//Función Listar
function listar()
{
	var fecha_inicio = $("#fecha_inicio").val();
	var fecha_fin = $("#fecha_fin").val();
	var idcliente = $("#idcliente").val();
	var idsucursal = $("#idsucursal2").val();

	tabla=$('#tbllistado').dataTable(
	{
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
					url: '../controladores/consultas.php?op=ventasfechavendedor',
					data:{fecha_inicio: fecha_inicio,fecha_fin: fecha_fin, idcliente: idcliente,idsucursal: idsucursal},
					type : "get",
					dataType : "json",						
					error: function(e){
						console.log(e.responseText);	
					}
				},
				"footerCallback": function ( row, data, start, end, display ) {
        
					total = this.api()
						.column(6)//numero de columna a sumar
						//.column(1, {page: 'current'})//para sumar solo la pagina actual
						.data()
						.reduce(function (a, b) {
							return parseFloat(a) + parseFloat(b);
						}, 0 );
			
					$(this.api().column(6).footer()).html("S/ " + total);
						
					},
		"bDestroy": true,
		"iDisplayLength": 5,//Paginación
	    "order": [[ 0, "desc" ]]//Ordenar (columna,orden)
	}).DataTable();
}


init();