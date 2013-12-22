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
	 function conectar( $DB_CONFIG=array() ){
		// print_r($DB_CONFIG);
		if ( !empty($DB_CONFIG) ){
			//ASI SE KEDA
		} else if ( isLoged()  ){
			$DB_CONFIG=getSessionVar('DB_CONFIG');
			if ( !empty($DB_CONFIG) ){
				$DB_CONFIG=array(
					'DB_SERVER'=>$DB_CONFIG['host'],
					'DB_NAME'=>$DB_CONFIG['db_name'],
					'DB_USER'=>$DB_CONFIG['db_user'],
					'DB_PASS'=>$DB_CONFIG['db_pass']
				);
			}else{
				global $DB_CONFIG;
			}
			
			
			
		}else{
			global $DB_CONFIG;
		}
		   
		try {
			 
			$db = @new PDO('mysql:host='.$DB_CONFIG['DB_SERVER'].';dbname='.$DB_CONFIG['DB_NAME'].';charset=UTF8', $DB_CONFIG['DB_USER'], $DB_CONFIG['DB_PASS'],array(
				PDO::ATTR_PERSISTENT => true
			));				
			$this->pdo=$db;
			$db->exec('USE '.$DB_CONFIG['DB_NAME']);
			// echo 'USE '.$DB_CONFIG['DB_NAME'];
			
			$msg='Conectado a la BD';
		} catch (PDOException $e) {			
			
			
			$msg=$e->getMessage();
			$msg='Error al conectarse con la base de datos';
			
			$resp=array(
				'success'=>false,
				'msg'=>$msg
			);			
			throw new Exception($msg);			
		}
		$resp=array(
			'success'=>true,
			'msg'=>$msg
		);	
			return $resp;
	 }
	 
	function reconectar( $DB_CONFIG=array() ){
		return $this->conectar( $DB_CONFIG );		
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