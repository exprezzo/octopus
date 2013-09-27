<?php
/**
  * @package Core
  */
class Modelo implements ICrud{								
	var $pk='id';
	var $nombre='';
	var $campos = array();
	
	
		
	function nuevo($params){
		$campos=$this->campos;				
		for($i=0; $i<sizeof($campos); $i++){
			$obj[$campos[$i]]='';
		}
		return $obj;		
	}
	function getError($sth = null){	
		$resp=array();
		
		if ($sth == null) {
			$pdo=$this->getPdo();
			$error=$pdo->errorInfo();
		}else{
			$error=$sth->errorInfo();
		}
		
		$resp['success']=false;			
		$resp['msg']=$error[2];
		return $resp;
	}
	
	function getPdo(){
		$db=Database::getInstance();
		return $db->pdo;
	}
	function getConexion(){
		return $this->getPdo();
	}
	
	public function ejecutarSql($sql){
		$pdo = $this->getPdo();
		$sth = $pdo->prepare($sql);						
		return $this->execute($sth);		
	}
	
	function execute($sth){
		//Ejecuta el statement y revisa errores
		
		$exito = $sth->execute();
			
		$msg='';
		if ($exito!==true){
			$error=$sth->errorInfo();			
			$success=false;
			$msg=$error[2];				
			if ($msg=='MySQL server has gone away'){
				$db=Database::getInstance();
				$db->reconectar();
				return $this->execute($sth);
			}
			$datos=array();
		}else{
			$datos = $sth->fetchAll(PDO::FETCH_ASSOC);
			$success=true;
		}
		
		return array(
			'success'	=>$success,			
			'datos' 	=>$datos,
			'msg'		=>$msg
		);			
	}
/*	===============================================================================
		ICrud
	=============================================================================== */	
	var $tabla='modelo_test';
	
	public function contar($filtros=''){
		if (!empty ($filtros) ){
		$filtros=' WHERE '.$filtros;
		}
				
		$sql = 'SELECT COUNT('.$this->pk.' ) as total FROM '.$this->tabla.$filtros;		
		
		
		$pdo = $this->getConexion();
		$sth = $con->prepare($sql);				
		$sth->execute();
		$modelos = $sth->fetchAll(PDO::FETCH_ASSOC);
		
		if ( empty($modelos) ){
			throw new Exception('La informacion buscada no fue encontrada. <br>Consulta:'.$sql.' '.$id); //TODO: agregar numero de error, crear una exception MiEscepcion
		}
		
		if ( sizeof($modelos) > 1 ){
			throw new Exception("El identificador está duplicado"); //TODO: agregar numero de error, crear una exception MiEscepcion
		}
		
		return $modelos[0]['total'];			
	}
	
	
	function obtener($params){
		// print_r($params); exit;
		
		$id=$params[$this->pk];			
		$sql = 'SELECT * FROM '.$this->tabla.' WHERE '.$this->pk.'=:id';				
		
		// echo $sql; exit;
		$con = $this->getConexion();
		$sth = $con->prepare($sql);		
		$sth->bindValue(':id',$id);		
		$sth->execute();
		$modelos = $sth->fetchAll(PDO::FETCH_ASSOC);
		
		if ( empty($modelos) ){
			//throw new Exception(); //TODO: agregar numero de error, crear una exception MiEscepcion
			
			return array('success'=>false,'error'=>'no encontrado','msg'=>'no encontrado '.$this->pk.':'.$id);
		}
		
		if ( sizeof($modelos) > 1 ){
			
			throw new Exception("El identificador está duplicado"); //TODO: agregar numero de error, crear una exception MiEscepcion
		}
		
		return $modelos[0];			
	}
	
	function guardar( $params ){
		$dbh=$this->getConexion();
		
		$id=$params[$this->pk];
		// $nombre=$params['nombre'];
		
		$nuevo = false;
		if ( empty($id) ){
			$nuevo = true;
			//           CREAR
			// $sql='INSERT INTO '.$this->tabla.' SET nombre=:nombre, fecha_de_creacion= now()';
			$sql='INSERT INTO '.$this->tabla.' SET ';
			foreach($params as $key=>$val){
				$sql.="$key=:$key, ";
			}
			$sql=substr($sql, 0, strlen($sql)-2 );
			
			// nombre=:nombre';
			$sth = $dbh->prepare($sql);							
			foreach($params as $key=>$val){
				$bind=":$key";
				$sth->bindValue($bind, $val,PDO::PARAM_STR);					
			}
			// $sth->bindValue(":nombre",$nombre,PDO::PARAM_STR);					
			$msg=$this->nombre.' Creado';	
		}else{
			//	         ACTUALIZAR
			
			$sql='UPDATE '.$this->tabla.' SET ';
			foreach($params as $key=>$val){
				if ($key==$this->pk ) continue;
				$sql.="$key=:$key, ";
			}
			$sql=substr($sql, 0, strlen($sql)-2 );
			$sql.=' WHERE '.$this->pk.'=:'.$this->pk;
			// nombre=:nombre';
			$sth = $dbh->prepare($sql);							
			foreach($params as $key=>$val){
				$bind=":$key";
				$sth->bindValue($bind, $val,PDO::PARAM_STR);					
			}
			
			$msg=$this->nombre.' Actualizado';	
		}
		$success = $sth->execute();
		
		$errCode = 0;
		if ($success != true){
			$error=$sth->errorInfo();			
			
			
			$success=false; //plionasmo apropósito
			$msg=$error[2];						
			$datos=array();
			$errCode=$error[1];
			// echo $msg.$sql; exit;
		}else{
			// $success = rowCount();			
			if ( empty( $id) ){
				$id=$dbh->lastInsertId();
			}
			$datos=$this->obtener(
				array( $this->pk =>$id )
			);
		}
		
		//si es nuevo, y success, se agrega una relacion entre el usuario y la razon social, en una transaccion
		//si no es nuevo, se completa la transaccion
		//se es un error, rollback.
		
		return array(
			'success'	=>$success,			
			'datos' 	=>$datos,
			'msg'		=>$msg,
			'errCode'	=>$errCode
		);	
				
	}
	
	function eliminar($params){
		return $this->borrar($params);
	}
	function borrar( $params ){
		if ( empty($params[$this->pk]) ){
			throw new Exception("Es necesario el parámetro '".$this->pk."'");			
		};		
		$id=$params[$this->pk];
		$sql = 'DELETE FROM '.$this->tabla.' WHERE '.$this->pk.'=:id';		
		
		$con = $this->getConexion();
		$sth = $con->prepare($sql);		
		$sth->bindValue(':id',$id,PDO::PARAM_INT);
		
		$exito = $sth->execute();					
		
		return $exito;	
	}
	
	function paginar($params){
		return $this->buscar($params);
	}
	
	
	
	function cadenaDeFiltros($filtros){
		$cadena=' WHERE ( ';
		foreach($filtros as $filtro){
			$field=empty($filtro['field'])? $filtro['dataKey'] : $filtro['field'];		
			// $field=empty($filtro['field'])? $filtro['dataKey'] : $filtro['field'];		
			switch( strtolower( $filtro['filterOperator'] ) ){
				case 'equals':	
					// 
					if ( is_numeric($filtro['filterValue']) ){
						$cadena.=' '.$field.' = :'.$filtro['dataKey'].' or ';
					}else{
						$cadena.=' '.$field.' LIKE :'.$filtro['dataKey'].' or ';
					}
					
				break;
				case 'contains':				
				case 'beginswith':					
				case 'endswith':
					$cadena.=' '.$field.' LIKE :'.$filtro['dataKey'].' or ';
				break;
				case 'greater':				
					$cadena.=' '.$field.' > :'.$filtro['dataKey'].' or ';
				break;
				case 'greaterorequal':
					$cadena.=' '.$field.' >= :'.$filtro['dataKey'].' or ';
				break;
				case 'isempty':
					$cadena.=' '.$field.' = "" or ';
				break;
				case 'lessorequal':
					$cadena.=' '.$field.' <= :'.$filtro['dataKey'].' or ';
				break;				
				case 'less':
					$cadena.=' '.$field.' < :'.$filtro['dataKey'].' or ';
				break;				
			}
		}		
		$cadena = substr($cadena, 0,-4);		
		return $cadena.' ) ';
	}
	
	
	function cadenaDeFiltrosAnd($filtros, $cadena){
		
		if (empty($cadena) ){
			$cadena=' WHERE (';
		}else{
			$cadena.=' AND ( ';
		}
		foreach($filtros as $filtro){
			$field=empty($filtro['field'])? $filtro['dataKey'] : $filtro['field'];		
			// $field=empty($filtro['field'])? $filtro['dataKey'] : $filtro['field'];		
			switch( strtolower( $filtro['filterOperator'] ) ){
				case 'equals':	
					// 
					if ( is_numeric($filtro['filterValue']) ){
						$cadena.=' '.$field.' = :'.$filtro['dataKey'].' and ';
					}else{
						$cadena.=' '.$field.' LIKE :'.$filtro['dataKey'].' and ';
					}
					
				break;
				case 'contains':				
				case 'beginswith':					
				case 'endswith':
					$cadena.=' '.$field.' LIKE :'.$filtro['dataKey'].' and ';
				break;
				case 'greater':				
					$cadena.=' '.$field.' > :'.$filtro['dataKey'].' and ';
				break;
				case 'greaterorequal':
					$cadena.=' '.$field.' >= :'.$filtro['dataKey'].' and ';
				break;
				case 'isempty':
					$cadena.=' '.$field.' = "" and ';
				break;
				case 'lessorequal':
					$cadena.=' '.$field.' <= :'.$filtro['dataKey'].' and ';
				break;				
				case 'less':
					$cadena.=' '.$field.' < :'.$filtro['dataKey'].' and ';
				break;				
			}
		}		
		$cadena = substr($cadena, 0,-5);		
		return $cadena.' ) ';
	}
	
	function bindFiltros($sth,$filtros){
		foreach($filtros as $filtro){
			$dk=$filtro['dataKey'];			
			$dk=':'.$dk;	
			switch( strtolower( $filtro['filterOperator'] ) ){
				case 'equals':		
					if (is_numeric($filtro['filterValue']) ){
						$sth->bindValue($dk, $filtro['filterValue'], PDO::PARAM_INT);
					}else{
						$sth->bindValue($dk, $filtro['filterValue'], PDO::PARAM_STR);
					}
					
				break;
				case 'contains':						
					$sth->bindValue($dk, '%'.$filtro['filterValue'].'%', PDO::PARAM_STR);																				
				break;
				case 'beginswith':					
					$sth->bindValue($dk, $filtro['filterValue'].'%', PDO::PARAM_STR);
				break;
				case 'endswith':
					$sth->bindValue($dk, '%'.$filtro['filterValue'], PDO::PARAM_STR);
				break;
				case 'greater':
					$sth->bindValue($dk, floatval( $filtro['filterValue'] ), PDO::PARAM_STR);
				break;
				case 'greaterorequal':								
					// echo "greaterorequal- $dk " .$filtro['filterValue'];
					$sth->bindValue($dk,  $filtro['filterValue'] , PDO::PARAM_STR);
				break;
				case 'lessorequal':				
					// echo "lessorequal- $dk " .$filtro['filterValue'];
					$sth->bindValue($dk,  $filtro['filterValue'] , PDO::PARAM_STR);
				break;
				case 'less':				
					// echo "lessorequal- $dk " .$filtro['filterValue'];
					$sth->bindValue($dk,  $filtro['filterValue'] , PDO::PARAM_STR);
				break;
				case 'isempty':				
					// aqui no se usan parametros (se usa campo='' ) 
				break;
			}
			
		}
	}
	
	function buscar($params){
		
		$con = $this->getConexion();
		
		$filtros='';
		if ( isset($params['filtros']) )
			$filtros=$this->cadenaDeFiltros($params['filtros']);
			
		if ( isset($params['filtrosAnd']) )
			$filtros=$this->cadenaDeFiltrosAnd($params['filtrosAnd'],$filtros);
			
		
		$sql = 'SELECT COUNT(*) as total FROM '.$this->tabla.$filtros;				
		$sth = $con->prepare($sql);
		
		if ( isset($params['filtros']) ){
			$this->bindFiltros($sth, $params['filtros']);
		}
		if ( isset($params['filtrosAnd']) ){
			$this->bindFiltros($sth, $params['filtrosAnd']);
		}
		
		
		
		$exito = $sth->execute();
		
		
		
		if ( !$exito ){
			return $this->getError( $sth );
			throw new Exception("Error listando: ".$sql); //TODO: agregar numero de error, crear una exception MiEscepcion
		}		
		// $sth = $con->query($sql); // Simple, but has several drawbacks		
		
		
		$tot = $sth->fetchAll(PDO::FETCH_ASSOC);
		$total = $tot[0]['total'];
		
		$paginar=false;
		if ( isset($params['limit']) && isset($params['start']) ){
			$paginar=true;
		}
		
		
		
		
		if ($paginar){
			$limit=$params['limit'];
			$start=$params['start'];		
			$sql = 'SELECT * FROM '.$this->tabla.$filtros.' limit :start,:limit';
		}else{			
			$sql = 'SELECT * FROM '.$this->tabla.$filtros;
		}
		
		// echo $sql; exit;
		$sth = $con->prepare($sql);
		if ($paginar){
			$sth->bindValue(':limit',$limit,PDO::PARAM_INT);
			$sth->bindValue(':start',$start,PDO::PARAM_INT);
		}
				
		if ( isset($params['filtros']) ){
			$this->bindFiltros($sth, $params['filtros']);
		}
		
		$exito = $sth->execute();

		
		if ( !$exito ){
		
			return $this->getError( $sth );
			// throw new Exception("Error listando: ".$sql); //TODO: agregar numero de error, crear una exception MiEscepcion
		}
		
		$modelos = $sth->fetchAll(PDO::FETCH_ASSOC);				
		
		return array(
			'success'=>true,
			'total'=>$total,
			'datos'=>$modelos
		);
	}
	
	function crearFiltrosOr($texto, $campos){
		$texto=trim($texto);
		if ($texto=='') return '';
		$pieces = explode(" ", $texto);
		$or='';
		foreach($pieces as $palabra){
			foreach($campos as $campo){
				$or.=' OR '.$campo.' like "%'.$palabra.'%"';
			}
		}
		$or = substr($or, 4);
		return $or;
	}
/*  ===============================================================================
		fin de ICrud
	=============================================================================== */
		
}
?>