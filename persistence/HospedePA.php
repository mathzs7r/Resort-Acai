<?php
require_once 'Banco.php';

class HospedePA{

	private $con;

	public function __construct(){
		$this->con=new Banco();

	}

	public function cadastrar($hospede)
	{
		$sql="INSERT INTO hospede(cpf, nome, endereco, cidade, telefone) VALUES(
			".$hospede->getCpf().",
			'".$hospede->getNome()."',
			'".$hospede->getEndereco()."',
			'".$hospede->getCidade()."',
			'".$hospede->getTelefone()."'
		)";

		//var_dump($sql);
		$resposta=$this->con->executar($sql);
		$this->con->desconectar();
		return $resposta;		
	}


	public function listar($limite,$offset)
	{
		$sql="SELECT * FROM hospede ORDER BY nome LIMIT $limite OFFSET $offset";
		$consulta=$this->con->consultar($sql);
		$this->con->desconectar();
		return $consulta;
	}

	public function contar()
	{
		$sql="SELECT COUNT(cpf) AS 'quantidade' FROM hospede";
		$consulta=$this->con->consultar($sql);
		$linha=$consulta->fetch_assoc();
		return $linha['quantidade'];
	}
	 
	public function buscar($termo,$campo)
	{
		if ($campo=="nome") {
			$sql="SELECT * FROM hospede WHERE nome LIKE '%$termo%'";
		}else if($campo=="endereco"){
			$sql="SELECT * FROM hospede WHERE endereco LIKE '%$termo%'";
		}else if($campo=="telefone"){
			$sql="SELECT * FROM hospede WHERE telefone LIKE '%$termo%'";
		}else if($campo=="cidade"){
			$sql="SELECT * FROM hospede WHERE cidade LIKE '%$termo%'";
		}else if($campo=="cpf"){
			$sql="SELECT * FROM hospede WHERE cpf LIKE '%$termo%'";
		}else{
			$sql="SELECT * FROM hospede WHERE
			nome LIKE '%$termo%' OR endereco LIKE '%$termo%' OR cidade LIKE '%$termo%'
			   OR telefone LIKE '%$termo%' OR cpf LIKE '%$termo%'";
		}
			//var_dump($sql);
		$consulta=$this->con->consultar($sql);
		$this->con->desconectar();
		return $consulta;
	}

	public function alterar($hospede)
	{
		$sql="UPDATE hospede SET 
		nome='".$hospede->getNome()."',
		endereco='".$hospede->getEndereco()."',
		cidade='".$hospede->getCidade()."',
		telefone='".$hospede->getTelefone()."',
		cpf=".$hospede->getCpf()."
		WHERE cpf=".$hospede->getCpf();
		$resposta=$this->con->executar($sql);
		$this->con->desconectar();
		return $resposta;
	}

	public function excluir($cpf)
	{
		//var_dump($cpf);
		$sql="DELETE FROM hospede WHERE cpf=$cpf"; 
		$resposta=$this->con->executar($sql);
		$this->con->desconectar();
		return $resposta;
	}

	public function listarNomes()
	{
		$sql="SELECT cpf,nome FROM hospede";
		$consulta=$this->con->consultar($sql);
		$this->con->desconectar();
		return $consulta;
	}

	public function verificarCpf($cpf)
	{
		$sql="SELECT cpf FROM hospede
		WHERE cpf='$cpf'";
		$consulta=$this->con->consultar($sql);
		if(!$consulta){ //não existe cpf
			return true;
		}else{ //existe cpf
			return false;
		}
	}

}

?>

