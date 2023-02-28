<?php
/*
Libreria desarrollada por Jorge Prado, se suministra tal cual, no se provee 
ninguna garantia ni soporte tecnico, se puede modificar y usar de cualquier 
forma y tampoco nos hacemos responsables de los usos que se le den.
*/
class datamanager{
	private $conexion;
	private $total_consultas;
	private $user;
	private $password;
	private $servidor;
	private $tiposerver;
	private $database;
	private $puerto;
	function __construct($usuario, $clave, $server,$tiposerver1,$db,$port){
		
		if(!isset($this->conexion)){
			$this->user=$usuario;
			$this->password=$clave;
			$this->servidor=$server;
			
			$this->database=$db;
			$this->tiposerver=$tiposerver1;
			$this->puerto=$port;
			switch($this->tiposerver)
			{
				case 1:
					$this->conexion = (mysql_connect($this->servidor,$this->user,$this->password)) or die(mysql_error());
					mysql_select_db($this->database,$this->conexion) or die(mysql_error());
					break;		
			}
		}
	}
	function __destruct()
	{
		try{
			mysql_close($this->conexion);
		} catch(Exception  $aads){}

	}
	public function consulta($consulta){
		switch ($this->tiposerver)
		{
			case 1:
				$this->total_consultas++;
				$resultado = mysql_query($consulta,$this->conexion);   
				if(!$resultado){
					return "error";
					exit;
				}
				break;
			case 2:
				break;
		}
		
		return $resultado; 
	}
	public function devolvertodos($ctabla)
	{
		return $this->consulta("Select * from ".$ctabla);
		
	}
	public function ejecutascalar($cConsulta)
	{
		$row =$this->fetch_array($this->consulta($cConsulta));
		return $row[0];
		
	}
	public function devolveruno($cTabla,$cCampo,$valor,$tipo)
	{
		$aFila=array();
		$cConsulta="Select * from ".$cTabla." where ";
		switch( $tipo)
		{
			case 1:
				$cConsulta=$cConsulta.$cCampo."=".$valor;
				break;
			case 2:
				$cConsulta=$cConsulta.$cCampo."= '".$valor."'";
				break;
		}
		$aFila=$this->fetch_array($this->consulta($cConsulta));	
		return $aFila;
	}
	public function borrar($cTabla,$cCampo,$valor,$tipo)
	{
		$cConsulta="delete from ".$cTabla." where ";
		switch( $tipo)
		{
			case 1:
				$cConsulta=$cConsulta.$cCampo."=".$valor;
				break;
			case 2:
				$cConsulta=$cConsulta.$cCampo."= '".$valor."'";
				break;
		}
		$this->consulta($cConsulta);	
	}
	public function actualizaregistro($cTabla,$cCampos,$valores,$tipos,$campoid,$valorid)
	{
		$aFila=array();
		$cConsulta="update ".$cTabla." set ";
		for($k=0;$k<sizeof($cCampos);$k++)
		{
			switch( $tipos[$k])
			{
				case 1:
					$cConsulta=$cConsulta.$cCampos[$k]."=".$valores[$k].",";
					break;
				case 2:
					$cConsulta=$cConsulta.$cCampos[$k]."= '".$valores[$k]."',";
					break;
			}
		}
		$cConsulta=substr($cConsulta,0,strlen($cConsulta)-1);
		$cConsulta = $cConsulta." where ".$campoid."=".$valorid;
		switch ($this->tiposerver)
		{
			case 1:
				$this->consulta($cConsulta);
				break;
			case 2:
				break;
		}
	}
	public function insertaregistro($cTabla,$cCampos,$valores,$tipos)
	{
		
		$cConsulta="insert into ".$cTabla." ( ";
		for($k=0;$k<sizeof($cCampos);$k++)
		{
			$cConsulta=$cConsulta.$cCampos[$k].",";
		}
		$cConsulta=substr($cConsulta,0,strlen($cConsulta)-1);
		$cConsulta=$cConsulta.") values (";
		for($k=0;$k<sizeof($cCampos);$k++)
		{
			switch( $tipos[$k])
			{
				case 1:
					$cConsulta=$cConsulta.$valores[$k].",";
					break;
				case 2:
					$cConsulta=$cConsulta."'".$valores[$k]."',";
					break;
			}
		}
		$cConsulta=substr($cConsulta,0,strlen($cConsulta)-1);
		$cConsulta=$cConsulta.")";
		switch ($this->tiposerver)
		{
			case 1:
				$this->consulta($cConsulta);
				break;
			case 2:
				break;
		}
	}
	public function ejecutastoredNO($cProcedure,$aCampos,$aValores)
	{
		switch ($this->tiposerver)
		{
			case 1:
				$cConsulta="CALL ".$cProcedure."(";
				for($k=0;$k<sizeof($aValores)-1;$k++)
					$cConsulta=$cConsulta.$aValores[$k].",";
				
				
				$cConsulta=substr(0,strlen($cConsulta)-1).")";
				break;
			case 2:
				break;
		}
		$this->consulta($cConsulta);
	}
	public function ejecutastoredSI($cProcedure,$aCampos,$aValores)
	{
		switch ($this->tiposerver)
		{
			case 1:
				$cConsulta="CALL ".$cProcedure."(";
				for($k=0;$k<sizeof($aValores)-1;$k++)
					$cConsulta=$cConsulta.$aValores[$k].",";
				
				
				$cConsulta=substr(0,strlen($cConsulta)-1).")";
				break;
			case 2:
				break;
		}
		return $this->consulta($cConsulta);
	}
	public function fetch_array($consulta){ 
		switch  ($this->tiposerver)
		{
			case 1:
				return mysql_fetch_array($consulta);
				break;
		}
	}
	public function traeestructura($tabla)
	{
		switch  ($this->tiposerver)
		{
			case 1:
				return $this->consulta('SHOW FIELDS FROM '.$tabla);
				break;
		}
	}

	public function num_rows($consulta){ 
		switch  ($this->tiposerver)
		{
			case 1:
				return mysql_num_rows($consulta);
				break;
		}
		
	}
	public function getTotalConsultas(){
		return $this->total_consultas;
	}
	public function traetablas()
	{
		
		switch  ($this->tiposerver)
		{
			case 1:
                //return $this->consulta("select * from INFORMATION_SCHEMA.columns where table_name=\"productos\" and table_schema=\"".$GLOBALS['database']."\"");
				return $this->consulta("show tables");
				break;
		}
	}
}?>