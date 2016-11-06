<?php
require_once"AccesoDatos.php";
class Estacionamiento
{

	private $id;
	private $patente;
 	private $fecha;


  	public function GetId()
	{
		return $this->id;
	}
	public function Getfecha()
	{
		return $this->fecha;
	}
	public function Getpatente()
	{
		return $this->patente;
	}

	public function SetId($valor)
	{
		$this->id = $valor;
	}
	public function Setfecha($valor)
	{
		$this->fecha = $valor;
	}
	public function Setpatente($valor)
	{
		$this->patente = $valor;
	}
	

	public function __construct($id=NULL)
	{
		if($id != NULL){
			$obj = Estacionamiento::TraerUnAuto($id);
			
			$this->id = $id;
			$this->patente = $obj->patente;
			$this->fecha = $obj->fecha;
		}
	}
	
  	public function ToString()
	{
	  	return $this->patente."-".$this->fecha;
	}



	public static function InsertarAuto($patente)
	{	
		$objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
		$consulta =$objetoAccesoDato->RetornarConsulta("INSERT into Estacionamiento (patente,fingreso,habilitado)values(:patente,:fecha,1)");
		$consulta->bindValue(':patente',$patente, PDO::PARAM_STR);
		$consulta->bindValue(':fecha', date("d-m-Y h:i:s"), PDO::PARAM_STR);
		$consulta->execute();		
		return $objetoAccesoDato->RetornarUltimoIdInsertado();
	
				
	}	
		
	public static function TraerUnAuto($idParametro) 
	{	
		$objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
		$consulta =$objetoAccesoDato->RetornarConsulta("select * from Estacionamiento where id =:id");
		$consulta->bindValue(':id', $idParametro, PDO::PARAM_INT);
		$consulta->execute();
		$autoBuscado= $consulta->fetchObject('Estacionamiento');
		return $personaBuscada;	
					
	}
	
	public static function TraerTodosLosAutos()
	{
		$objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
		$consulta =$objetoAccesoDato->RetornarConsulta("select fingreso, patente from Estacionamiento where fsalida is null");
		$consulta->execute();			
		//$arrEstacionamiento= $consulta->fetchAll(PDO::FETCH_CLASS, "Estacionamiento");
		$arrEstacionamiento= $consulta->fetchAll();	
		return $arrEstacionamiento;
	}
	
	public static function BorrarAuto($idParametro)
	{	
		$objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
		$consulta =$objetoAccesoDato->RetornarConsulta("delete from Estacionamiento	WHERE id=:id");		
		$consulta->bindValue(':id',$idParametro, PDO::PARAM_INT);		
		$consulta->execute();
		return $consulta->rowCount();
		
	}


}