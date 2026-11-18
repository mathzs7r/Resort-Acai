<?php require_once 'Banco.php';

class QuartoPA{

	public function __construct()
	{
		$this->con=new Banco();
	}
	public function cadastrar($quarto)
	{
		$sql="INSERT INTO quarto(numero,status,cama,nivel,descricao,foto,valor) VALUES (".
			$quarto->getNumero().",".
			$quarto->getStatus().",".
			$quarto->getCama().",".
			$quarto->getNivel().",'".
			$quarto->getDescricao()."','".
			$quarto->getFoto()."',".
			$quarto->getValor().")";
		//var_dump($sql);
		$resposta=$this->con->executar($sql);
		$this->con->desconectar();
		return $resposta;
	}
	public function listar($limite,$offset)
	{
		$sql="SELECT numero,status,cama,nivel,descricao,foto,valor from quarto order by numero  LIMIT $limite OFFSET $offset";
		$consulta=$this->con->consultar($sql);
		$this->con->desconectar();
		return $consulta;
	}

	public function buscar ($termo,$campo)
	{
		if ($campo=="numero"){
			$sql="SELECT * FROM quarto WHERE numero = '$termo'";
		}else if($campo=="status"){
			//var_dump($termo);
			if(strtolower($termo)=="ocupado"){
				$sql="SELECT * FROM quarto WHERE status = 0";
			}else if(strtolower($termo)=="disponível"){
				$sql="SELECT * FROM quarto WHERE status = 1";
			}else{
			$sql="SELECT * FROM quarto WHERE status LIKE '%$termo%'";
			}
			// $sql="SELECT * FROM quarto WHERE status LIKE '%$termo%'";
		}else if($campo=="nivel"){
			$termo=str_replace(["á","Á"],"a",$termo);
			if(strtolower($termo)=="basico"){
				
				$sql="SELECT * FROM quarto WHERE nivel = 1";
			}else if(strtolower($termo)=="luxo"){
				$sql="SELECT * FROM quarto WHERE nivel = 2";
			}else if(strtolower($termo)=="premium"){
				$sql="SELECT * FROM quarto WHERE nivel = 3";
			}else if(strtolower($termo)=="master"){
				$sql="SELECT * FROM quarto WHERE nivel = 4";
			}else{
			$sql="SELECT * FROM quarto WHERE status LIKE '%$termo%'";
			}
			//$sql="SELECT * FROM quarto WHERE nivel LIKE '%$termo%'";
		}else if($campo=="descricao"){
			$sql="SELECT * FROM quarto WHERE descricao LIKE '%$termo%'";
		}else if($campo=="cama"){
			$sql="SELECT * FROM quarto WHERE cama = '$termo'";	
		}else if($campo=="valor"){
			$sql="SELECT * FROM quarto WHERE valor=$termo";
		}else{
			$sql="SELECT * FROM quarto WHERE numero='$termo' OR status LIKE '%$termo%' OR nivel LIKE '%$termo%' OR descricao LIKE '%$termo%'
			OR cama LIKE '%$termo%' OR valor LIKE '%$termo%'";
		}
		//var_dump($sql);
		$consulta=$this->con->consultar($sql);
		$this->con->desconectar();
		return $consulta;
	}

	public function alterar($quarto)

	{
		$sql="UPDATE quarto SET 
		foto='".$quarto->getFoto()."',
		status=".$quarto->getStatus().",
		nivel=".$quarto->getNivel().",
		descricao='".$quarto->getDescricao()."',
		valor=".$quarto->getValor().",
		cama=".$quarto->getCama()."
		
		WHERE numero=".$quarto->getNumero();
		
		$resposta=$this->con->executar($sql);
		$this->con->desconectar();
		return $resposta;
	}

	public function excluir($quarto)
	{
		$sql="DELETE FROM quarto WHERE numero=$quarto";
		$resposta=$this->con->executar($sql);
		//var_dump($sql);
		$this->con->desconectar();
		return $resposta;
	}


	public function listarQuartos()
	{
		$sql="SELECT numero,valor,status FROM quarto";
		return $this->con->consultar($sql);
	}

	public function contar()
	{
		$sql="SELECT COUNT(numero) AS 'quantidade' FROM quarto";
		$consulta=$this->con->consultar($sql);
		$linha=$consulta->fetch_assoc();
		return $linha['quantidade'];
	}

	public function verificarDisponibilidade($numero)
	{
		$sql="SELECT status FROM quarto WHERE numero=$numero";
		$consulta=$this->con->consultar($sql);
		$linha=$consulta->fetch_assoc();
	if($linha['status']==1){ //status 1 = disponivel
		return true;
	}else{
		return false;
	}
}

public function ocupar($quarto)

	{
		$sql="UPDATE quarto SET 
		
		status=0
		
		WHERE numero=".$quarto->getNumero()."";
		$resposta=$this->con->executar($sql);
		//$this->con->desconectar();
		return $resposta;
	}


	public function desocupar($quarto)

	{
		$sql="UPDATE quarto SET 
		
		status=1
		
		WHERE numero=".$quarto->getNumero()."";
		$resposta=$this->con->executar($sql);
		//$this->con->desconectar();
		return $resposta;
	}

	public function retornarImagem($numero)
	{
		$sql="SELECT foto FROM quarto WHERE 
		numero=$numero";
		$consulta=$this->con->consultar($sql);
		$linha=$consulta->fetch_assoc();
		return $linha['foto'];
	}




}


?>