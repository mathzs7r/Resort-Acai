<?php

require_once 'Banco.php';

class ParceirosPA{
	private $con;
	public function __construct()
	{
		$this->con=new Banco();
	}
	public function Cadastrar($parceirospa)
	{
		$sql= "INSERT INTO parceiros(cnpj,nome,logo,telefone,descricao,cod_adm)VALUES(".
			$parceirospa->getCnpj().",'".
			$parceirospa->getNome()."','".
			$parceirospa->getLogo()."','".
			$parceirospa->getTelefone()."','".
			$parceirospa->getDescricao()."',".
			$parceirospa->getCodAdm().")";

		//var_dump($sql);

		$resposta=$this->con->executar($sql);
		$this->con->desconectar();
		return $resposta;			
	}
	public function listar($limite,$offset)
	{
		 $sql="SELECT * FROM parceiros ORDER BY cnpj 
		 LIMIT $limite OFFSET $offset";
		 $consulta=$this->con->consultar($sql);
		 $this->con->desconectar();
		 return $consulta;
	}

	public function contar()
	{
		$sql="SELECT COUNT(cnpj) AS 'quantidade' 
		FROM parceiros";
		$consulta=$this->con->consultar($sql);
		$linha=$consulta->fetch_assoc();
		return $linha['quantidade'];
	}

	public function buscar ($termo,$campo)
	{
		if ($campo=="cnpj"){
			$sql="SELECT * FROM parceiros WHERE cnpj LIKE '%$termo%'";
		}else if($campo=="nome"){
			$sql="SELECT * FROM parceiros WHERE nome LIKE '%$termo%'";
		}else if($campo=="telefone"){
			$sql="SELECT * FROM parceiros WHERE telefone LIKE '%$termo%'";
		}else if($campo=="descricao"){
			$sql="SELECT * FROM parceiros WHERE descricao LIKE '%$termo%'";
		}else if($campo=="cod_adm"){
			$sql="SELECT * FROM parceiros WHERE cod_adm LIKE '%$termo%'";	
		}else if($campo=="valor"){
			$sql="SELECT * FROM parceiros WHERE valor=$termo";
		}else{
			$sql="SELECT * FROM parceiros WHERE cnpj='$termo' OR nome LIKE '%$termo%' OR telefone LIKE '%$termo%' OR descricao LIKE '%$termo%'
			OR cod_adm LIKE '%$termo%'";
		}
		//var_dump($sql);
		$consulta=$this->con->consultar($sql);
		$this->con->desconectar();
		return $consulta;
	}



	public function alterar($parceiros)
	{
		$sql="UPDATE parceiros SET nome='".
		$parceiros->getNome()."', logo='".
		$parceiros->getLogo()."',telefone='".
		$parceiros->getTelefone()."', descricao='".
		$parceiros->getDescricao()."', cod_adm=".
		$parceiros->getCodAdm()." WHERE cnpj=".
		$parceiros->getCnpj();
		$resposta=$this->con->executar($sql);
		$this->con->desconectar();
		return $resposta;
	}

	public function excluir($cnpj)
	{
		$sql="DELETE FROM parceiros WHERE 
		cnpj=$cnpj";
		$resposta=$this->con->executar($sql);
		$this->con->desconectar();
		return $resposta;
	}

	public function listarNomes()
	{
		$sql="SELECT cnpj,nome FROM parceiros";
		$consulta=$this->con->consultar($sql);
		$this->con->desconectar();
		return $consulta;
	}

	public function retornarImagem($cnpj)
	{
		$sql="SELECT logo FROM parceiros WHERE cnpj=$cnpj";
		$consulta=$this->con->consultar($sql);
		$linha=$consulta->fetch_assoc();
		return $linha['logo'];
	}

	public function verificarCnpj($cnpj) //na hora de cadastar usuario, verificar se o nome de usuario/cnpj ja existe
	{
		$sql="SELECT cnpj FROM parceiros WHERE cnpj='$cnpj'";
		$consulta=$this->con->consultar($sql);
			if(!$consulta){ //se não-consulta, esse cnpj não existe ainda no banco
				return true; //pode prosseguir com o cadastro
			}else{ //usuario existente
				return false;
			}
		}
}


?>
		



