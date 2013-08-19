<?php
class Database{
	private static $instancia;
	
    private function __construct(){
		global $DB_CONFIG;
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
   
	public static function getInstance(){
      if (  !self::$instancia instanceof self){
         self::$instancia = new self;
      }
      return self::$instancia;
   }
}
?>