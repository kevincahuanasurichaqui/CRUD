<?php 
//Incluímos inicialmente la conexión a la base de datos
require "../configuraciones/Conexion.php";

Class Categoria
{
	//Implementamos nuestro constructor
	public function __construct()
	{

	}

	//Implementamos un método para insertar registros
	public function insertar($nombre)
	{
		$sql="INSERT INTO categoria (nombre,condicion)
		VALUES ('$nombre','1')";
		return ejecutarConsulta($sql);
	}

	//Implementamos un método para insertar registros
	public function insertarSucursal($nombre,$direccion,$telefono,$nombreSucursal,$serie_comprobante,$num_comprobante,$distrito,$provincia,$departamento,$ubigeo)
	{
		$sql="INSERT INTO sucursal (nombre,direccion,telefono,distrito,provincia,departamento,ubigeo)
		VALUES ('$nombre','$direccion','$telefono','$distrito','$provincia','$departamento','$ubigeo')";

		$idsucursalnew=ejecutarConsulta_retornarID($sql);

		$num_elementos=0;

		$sw=true;

		while ($num_elementos < count($nombreSucursal)) {

			if($serie_comprobante[$num_elementos] < 10){

				$serie_comprobante = $serie_comprobante;

			}else{

				$serie_comprobante = $serie_comprobante;

			}

			$sql="INSERT INTO comp_pago (nombre,serie_comprobante,num_comprobante,idsucursal,condicion) VALUES
				('$nombreSucursal[$num_elementos]','$serie_comprobante[$num_elementos]','$num_comprobante[$num_elementos]','$idsucursalnew','1')";

				ejecutarConsulta($sql) or $sw=false;

				$num_elementos=$num_elementos+1;

		}
		
		return $sw;
		
	}

	public function insertarComprobantes($nombre,$serie_comprobante,$num_comprobante,$idsucursal)
	{

		

	}

	//Implementamos un método para editar registros
	public function editar($idcategoria,$nombre)
	{
		$sql="UPDATE categoria SET nombre='$nombre' WHERE idcategoria='$idcategoria'";
		return ejecutarConsulta($sql);
	}

	//Implementamos un método para editar registros
	public function editarSucursal($idsucursal,$nombre,$direccion,$telefono,$distrito,$provincia,$departamento,$ubigeo)
	{
		$sql="UPDATE sucursal SET nombre='$nombre',direccion='$direccion',telefono='$telefono',distrito='$distrito',provincia='$provincia',departamento='$departamento',ubigeo='$ubigeo' WHERE idsucursal='$idsucursal'";
		return ejecutarConsulta($sql);
	}

	//Implementamos un método para desactivar categorías
	public function desactivar($idcategoria)
	{
		$sql="UPDATE categoria SET condicion='0' WHERE idcategoria='$idcategoria'";
		return ejecutarConsulta($sql);
	}

	//Implementamos un método para activar categorías
	public function activar($idcategoria)
	{
		$sql="UPDATE categoria SET condicion='1' WHERE idcategoria='$idcategoria'";
		return ejecutarConsulta($sql);
	}

	//Implementar un método para mostrar los datos de un registro a modificar
	public function mostrar($idcategoria)
	{
		$sql="SELECT * FROM categoria WHERE idcategoria='$idcategoria'";
		return ejecutarConsultaSimpleFila($sql);
	}

	//Implementar un método para mostrar los datos de un registro a modificar
	public function mostrarSucursal($idsucursal)
	{
		$sql="SELECT * FROM sucursal WHERE idsucursal='$idsucursal'";
		return ejecutarConsultaSimpleFila($sql);
	}

	//Implementar un método para listar los registros
	public function listar()
	{
		$sql="SELECT * FROM categoria";
		return ejecutarConsulta($sql);		
	}

	//Implementar un método para listar los registros
	public function listarSucursales()
	{
		$sql="SELECT * FROM sucursal";
		return ejecutarConsulta($sql);		
	}

	//Implementar un método para listar los registros y mostrar en el select
	public function select()
	{
		$sql="SELECT * FROM categoria where condicion=1";
		return ejecutarConsulta($sql);		
	}
}

?>