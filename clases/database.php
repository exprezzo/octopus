<?php
/**
  * @package Core
  */
  
 /**
  * Gestiona la conexion a la base de datos con pdo, pdo se obtiene asi: Database::getInstance()->pdo
  */
class Database{
	private static $instancia;
	
	/**
	 * La funcion es privada para impedir crear mas de una instancia, en lugar de esta, use Database::getInstance()
	 */
	 function conectar(){
		if ( !empty($_SESSION['isLoged']) && !empty($_SESSION['DB_CONFIG']) ){
			$DB_CONFIG=array(
				'DB_SERVER'=>$_SESSION['DB_CONFIG']['host'],
				'DB_NAME'=>$_SESSION['DB_CONFIG']['db_name'],
				'DB_USER'=>$_SESSION['DB_CONFIG']['db_user'],
				'DB_PASS'=>$_SESSION['DB_CONFIG']['db_pass']
			);
		}else{
			global $DB_CONFIG;
		}
		
		try {
			$db = @new PDO('mysql:host='.$DB_CONFIG['DB_SERVER'].';dbname='.$DB_CONFIG{'DB_NAME'}.';charset=UTF8', $DB_CONFIG['DB_USER'], $DB_CONFIG['DB_PASS'],array(
				PDO::ATTR_PERSISTENT => false
			));				
			$this->pdo=$db;
		} catch (PDOException $e) {			
			
			//$msg='Error al conectarse con la base de datos';
			$msg=$e->getMessage();
			
			$resp=array(
				'success'=>false,
				'msg'=>$msg
			);			
			throw new Exception($msg);			
		}
	 }
	function reconectar(){
		return $this->conectar();
		
	}
    private function __construct(){		
		$this->conectar();
    }
   
	/**
	 * Devuelve un objeto que representa la conexion a la base de datos, este objeto tiene la propiedad pdo
	 */
	public static function getInstance(){
      if (  !self::$instancia instanceof self){
         self::$instancia = new self;
      }
      return self::$instancia;
   }
}
?>