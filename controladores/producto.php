<?php 
require_once "../modelos/Producto.php";
session_start();

$producto=new Producto();

$idproducto=isset($_POST["idproducto"])? limpiarCadena($_POST["idproducto"]):"";
$idsucursal=isset($_POST["idsucursal"])? limpiarCadena($_POST["idsucursal"]):"";
$idsucursal2=isset($_POST["idsucursal2"])? limpiarCadena($_POST["idsucursal2"]):"";
$idcategoria=isset($_POST["idcategoria"])? limpiarCadena($_POST["idcategoria"]):"";
$idunidad_medida=isset($_POST["idunidad_medida"])? limpiarCadena($_POST["idunidad_medida"]):"";
$codigo=isset($_POST["codigo"])? limpiarCadena($_POST["codigo"]):"";
$nombre=isset($_POST["nombre"])? limpiarCadena($_POST["nombre"]):"";
$stock=isset($_POST["stock"])? limpiarCadena($_POST["stock"]):"";
$stockMinimo=isset($_POST["stockMinimo"])? limpiarCadena($_POST["stockMinimo"]):"";
$precio=isset($_POST["precio"])? limpiarCadena($_POST["precio"]):"";
$precioB=isset($_POST["precioB"])? limpiarCadena($_POST["precioB"]):"";
$precioC=isset($_POST["precioC"])? limpiarCadena($_POST["precioC"]):"";
$precioD=isset($_POST["precioD"])? limpiarCadena($_POST["precioD"]):"";
$precioCompra=isset($_POST["precioCompra"])? limpiarCadena($_POST["precioCompra"]):"";
$fecha=isset($_POST["fecha_hora"])? limpiarCadena($_POST["fecha_hora"]):"";
$descripcion=isset($_POST["descripcion"])? limpiarCadena($_POST["descripcion"]):"";
$imagen=isset($_POST["imagen"])? limpiarCadena($_POST["imagen"]):"";
$modelo=isset($_POST["modelo"])? limpiarCadena($_POST["modelo"]):"";
$nserie=isset($_POST["nserie"])? limpiarCadena($_POST["nserie"]):"";

$tipoigv=isset($_POST["tipoigv"])? limpiarCadena($_POST["tipoigv"]):"";

$idproductoE=isset($_POST["idproductoE"])? limpiarCadena($_POST["idproductoE"]):"";
$idproductoD=isset($_POST["idproductoD"])? limpiarCadena($_POST["idproductoD"]):"";
$cantidadE=isset($_POST["cantidadE"])? limpiarCadena($_POST["cantidadE"]):"";
$cantidadD=isset($_POST["cantidadD"])? limpiarCadena($_POST["cantidadD"]):"";
$productoEmpaquetado=isset($_POST["productoE"])? limpiarCadena($_POST["productoE"]):"";
$productoDesempaquetar=isset($_POST["productoD"])? limpiarCadena($_POST["productoD"]):"";

$almacenOrigen=isset($_POST["idsucursal3"])? limpiarCadena($_POST["idsucursal3"]):"";
$almacenDestino=isset($_POST["idsucursal4"])? limpiarCadena($_POST["idsucursal4"]):"";
$productoTrasladar=isset($_POST["idproducto2"])? limpiarCadena($_POST["idproducto2"]):"";
$productoTraslado=isset($_POST["idproducto3"])? limpiarCadena($_POST["idproducto3"]):"";
$cantidadTrasladar=isset($_POST["cantidadT"])? limpiarCadena($_POST["cantidadT"]):"";



switch ($_GET["op"]){
	case 'guardaryeditar':

		if (!file_exists($_FILES['imagen']['tmp_name']) || !is_uploaded_file($_FILES['imagen']['tmp_name']))
		{
			$imagen=$_POST["imagenactual"];
		}
		else 
		{
			$ext = explode(".", $_FILES["imagen"]["name"]);
			if ($_FILES['imagen']['type'] == "image/jpg" || $_FILES['imagen']['type'] == "image/jpeg" || $_FILES['imagen']['type'] == "image/png")
			{
				$imagen = round(microtime(true)) . '.' . end($ext);
				move_uploaded_file($_FILES["imagen"]["tmp_name"], "../files/productos/" . $imagen);
			}
		}
		if (empty($idproducto)){
			$rspta=$producto->insertar($idsucursal,$idcategoria,$idunidad_medida,$codigo,strtoupper($nombre),$stock,$stockMinimo,$precio,$precioB,$precioC,$precioD,$precioCompra,$fecha,$descripcion,$imagen,$modelo,$nserie,$tipoigv,$_POST['sucursales']);
			echo $rspta ? "Producto/Servicio registrado" : "Producto/Servicio no se pudo registrar";
		}
		else {
			$rspta=$producto->editar($idproducto,$idsucursal,$idcategoria,$idunidad_medida,$codigo,$nombre,$stock,$stockMinimo,$precio,$precioB,$precioC,$precioD,$precioCompra,$fecha,$descripcion,$imagen,$modelo,$nserie,$tipoigv,$_POST['sucursales']);
			echo $rspta ? "Producto/Servicio actualizado" : "Producto/Servicio no se pudo actualizar";
		}
	break;

	case 'actualizarProductoEmpaquetado':
			$rspta=$producto->desempaquetar($idproductoE,$idproductoD,$cantidadE,$cantidadD,$productoEmpaquetado,$productoDesempaquetar);
			echo $rspta ? "Producto desempaquetado" : "Producto no se puede desempaquetar";
	break;

	case 'trasladarProducto':
			$rspta=$producto->trasladar($almacenOrigen,$almacenDestino,$productoTrasladar,$productoTraslado,$cantidadTrasladar);
			echo $rspta ? "Producto Traslado" : "Producto no se puede Trasladar";
	break;

	case 'desactivar':
		$rspta=$producto->desactivar($idproducto);
 		echo $rspta ? "Producto Desactivado" : "Producto no se puede desactivar";
	break;

	case 'activar':
		$rspta=$producto->activar($idproducto);
 		echo $rspta ? "Producto activado" : "Producto no se puede activar";
	break;

	case 'mostrar':
		$rspta=$producto->mostrar($idproducto);
 		//Codificar el resultado utilizando json
 		echo json_encode($rspta);
	break;

	case 'porcentaje':
		$rspta=$producto->porcentaje($idcategoria);
 		//Codificar el resultado utilizando json
 		echo json_encode($rspta);
	break;

	case 'mostrarProducto':
		$rspta=$producto->mostrarProducto($idproducto);
		echo json_encode($rspta);
	break;

	case 'sucursales':
		//Obtenemos todos las sucursales de la tabla sucursales
		$rspta=$producto->listarsucursales();

		//Mostramos la lista de sucursales en la vista y si están o no marcados
		while ($reg = $rspta->fetch_object())
			{
				echo '<li> <input type="checkbox" checked name="sucursales[]" value="'.$reg->idsucursal.'">'.$reg->nombre.' </li>';
			}
	break;

	case 'listarKardex':
		$idproducto = $_GET['idproducto'];
		$rspta=$producto->listarKardex($idproducto);
 		//Vamos a declarar un array
 		$data= Array();

		$contador = 0;
		$stockUltimo = 0;

 		while ($reg=$rspta->fetch_object()){

			if($reg->cantidad > 0 && $contador == 0){
				$reg->stock = $reg->cantidad;
				$stockInicial = $reg->stock;
			}

			if($reg->cantidad > 0 && $reg->salida == 0 && $contador > 0){
				$reg->stock = $stockUltimo + $reg->cantidad;
			}else if($reg->cantidad == 0 && $reg->salida > 0 && $contador > 0){
				$reg->stock = $stockUltimo - $reg->salida;
			}



 			$data[]=array(
 				"0"=>$reg->fecha,
				"1"=>$reg->motivo,
 				"2"=>$reg->comprobante,
 				"3"=>$reg->cantidad,
 				"4"=>$reg->salida,
 				"5"=>$reg->precio,
 				"6"=>$reg->valor,
 				"7"=>$reg->stock,
 				"8"=>$reg->stock * $reg->precio
 			);

			$contador = $contador + 1;

			$stockUltimo = $reg->stock;

 		}

 		$results = array(
 			"sEcho"=>1, //Información para el datatables
 			"iTotalRecords"=>count($data), //enviamos el total registros al datatable
 			"iTotalDisplayRecords"=>count($data), //enviamos el total registros a visualizar
 			"aaData"=>$data);
 		echo json_encode($results);

	break;

	case 'listarServicio':

		$fechaActual = date('Y-m-d');

		$idsucursal2 = $_GET['idsucursal2'];

		if($_SESSION['idsucursal'] == 0){
			
			$rspta=$producto->listarS2($idsucursal2,$_SESSION['idsucursal']);

		}else{

			$rspta=$producto->listarS3($idsucursal2,$_SESSION['idsucursal']);

		}

 		//Vamos a declarar un array
 		$data= Array();

 		while ($reg=$rspta->fetch_object()){
 			$data[]=array(
 				"0"=>$reg->nombre,
				"1"=>$reg->unidad,
 				"2"=>$reg->categoria,
 				"3"=>$reg->almacen,
 				"4"=>$reg->codigo,
 				'<span class="badge bg-red">'.$reg->stock.'</span>',
 				"5"=>$reg->precio,
 				"6"=>$reg->fechac,
 				"7"=>"<img src='../files/productos/".$reg->imagen."' height='50px' width='50px' >",
 				"8"=>($reg->condicion)?'<span class="badge bg-green">ACTIVADO</span>':
 				'<span class="badge bg-red">DESACTIVADO</span>',
 				"9"=>($reg->condicion)?'<button class="btn btn-warning btn-xs" onclick="mostrar('.$reg->idproducto.')"><i class="fa fa-pencil"></i></button>'.
 					' <button class="btn btn-danger btn-xs" onclick="desactivar('.$reg->idproducto.')"><i class="fa fa-close"></i></button>':
 					'<button class="btn btn-warning btn-xs" onclick="mostrar('.$reg->idproducto.')"><i class="fa fa-pencil"></i></button>'.
 					' <button class="btn btn-primary btn-xs" onclick="activar('.$reg->idproducto.')"><i class="fa fa-check"></i></button>'
 				);
 		}
 		$results = array(
 			"sEcho"=>1, //Información para el datatables
 			"iTotalRecords"=>count($data), //enviamos el total registros al datatable
 			"iTotalDisplayRecords"=>count($data), //enviamos el total registros a visualizar
 			"aaData"=>$data);
 		echo json_encode($results);

	break;

	case 'listar':

		$fechaActual = date('Y-m-d');

		$idsucursal2 = $_GET['idsucursal2'];

		if($_SESSION['idsucursal'] == 0){
			
			$rspta=$producto->listar2($idsucursal2,$_SESSION['idsucursal']);

		}else{

			$rspta=$producto->listar3($idsucursal2,$_SESSION['idsucursal']);

		}

 		//Vamos a declarar un array
 		$data= Array();

 		while ($reg=$rspta->fetch_object()){
 			$data[]=array(
 				"0"=>$reg->nombre,
				"1"=>$reg->unidad,
 				"2"=>$reg->categoria,
 				"3"=>$reg->almacen,
 				"4"=>$reg->codigo,
 				"5"=>($reg->fecha != $fechaActual)?$reg->fecha:'<span class="badge bg-red">'.$reg->fecha.'</span>',
 				"6"=>($reg->stock > $reg->stock_minimo)?$reg->stock:
 				'<span class="badge bg-red">'.$reg->stock.'</span>',
 				"7"=>$reg->precio,
 				"8"=>$reg->precio_compra,
 				"9"=>$reg->fechac,
 				"10"=>"<img src='../files/productos/".$reg->imagen."' height='50px' width='50px' >",
 				"11"=>($reg->condicion)?'<span class="badge bg-green">ACTIVADO</span>':
 				'<span class="badge bg-red">DESACTIVADO</span>',
 				"12"=>($reg->condicion)?'<button class="btn btn-primary btn-xs" onclick="mostrarKardex('.$reg->idproducto.')"><i class="fa fa-eye"></i></button> '. '<button class="btn btn-warning btn-xs" onclick="mostrar('.$reg->idproducto.')"><i class="fa fa-pencil"></i></button>'.
 					' <button class="btn btn-danger btn-xs" onclick="desactivar('.$reg->idproducto.')"><i class="fa fa-close"></i></button>':
 					'<button class="btn btn-warning btn-xs" onclick="mostrar('.$reg->idproducto.')"><i class="fa fa-pencil"></i></button>'.
 					' <button class="btn btn-primary btn-xs" onclick="activar('.$reg->idproducto.')"><i class="fa fa-check"></i></button>'
 				);
 		}
 		$results = array(
 			"sEcho"=>1, //Información para el datatables
 			"iTotalRecords"=>count($data), //enviamos el total registros al datatable
 			"iTotalDisplayRecords"=>count($data), //enviamos el total registros a visualizar
 			"aaData"=>$data);
 		echo json_encode($results);

	break;

	case "selectCategoria2":
		require_once "../modelos/Categoria.php";
		$categoria = new Categoria();

		$rspta = $categoria->select();

		while ($reg = $rspta->fetch_object())
				{

					if($reg->nombre == 'SERVICIO'){

						echo '<option value=' . $reg->idcategoria . '>' . $reg->nombre . '</option>';

					}

				}
	break;

	case "selectCategoria":
		require_once "../modelos/Categoria.php";
		$categoria = new Categoria();

		$rspta = $categoria->select();

		while ($reg = $rspta->fetch_object())
				{
					if($reg->nombre != 'SERVICIO'){
						
					echo '<option value=' . $reg->idcategoria . '>' . $reg->nombre . '</option>';

					}
				}
	break;

	case "selectUnidadMedida":
		require_once "../modelos/UnidadMedida.php";
		$unidadmedida = new UnidadMedida();

		$rspta = $unidadmedida->select();

		while ($reg = $rspta->fetch_object())
				{
					echo '<option value=' . $reg->idunidad_medida . '>' . $reg->nombre . '</option>';
				}
	break;

	case 'mostrarStockProductoE':

		$idproducto = $_REQUEST["idproductoE"];

		$rspta = $producto->mostrarStockProductoE($idproducto);
		echo json_encode($rspta);

		break;

	case 'mostrarStockProductoD':

		$idproducto = $_REQUEST["idproductoD"];

		$rspta = $producto->mostrarStockProductoD($idproducto);
		echo json_encode($rspta);

		break;
}
?>