<?php

require_once 'Banco.php';

class AdministradorPA{

	private $con;

	public function __construct(){
		$this->con=new Banco();
	}

	public function logar($login,$senha)
	{                   
		$sql="SELECT cod_adm,login,senha,nivel FROM administrador
		WHERE login='$login'";
		$consulta=$this->con->consultar($sql);
		if(!$consulta){//não existe esse login/sem dados
			return false;
		}else{ //existe o login
			$linha=$consulta->fetch_assoc();
			if(password_verify($senha, $linha['senha'])){
				return $this->con->consultar($sql);
			}else{
				return false;
			}
		}
	}

	public function cadastrar($administrador)
	{
		$sql="INSERT INTO administrador(nome,login,senha,nivel) VALUES('".
			$administrador->getNome()."','".
			$administrador->getLogin()."','".
			$administrador->getSenha()."',".
			$administrador->getNivel().")";
		//var_dump($sql);
			$resposta=$this->con->executar($sql);
			$this->con->desconectar();
			return $resposta;			
		}

		public function listar($limite,$offset)
		{
			$sql="SELECT * FROM administrador ORDER BY cod_adm 
			LIMIT $limite OFFSET $offset";
			$consulta=$this->con->consultar($sql);
			$this->con->desconectar();
			return $consulta;
		}

		public function listarFuncionarios($limite,$offset)
		{
			// Filtra apenas por funcionários (nivel = 2)
			$sql="SELECT * FROM administrador WHERE nivel = '2' ORDER BY cod_adm 
			LIMIT $limite OFFSET $offset";
			$consulta=$this->con->consultar($sql);
			$this->con->desconectar();
			return $consulta;
		}

		public function buscar($termo,$campo)
		{
			if($campo=="cod_adm"){
				
					$sql="SELECT * FROM administrador WHERE
					cod_adm='$termo'";
				
			}else if ($campo=="nome") {
				$sql="SELECT * FROM administrador WHERE 
				nome LIKE '%$termo%'";
			}else if($campo=="login"){
				$sql="SELECT * FROM administrador WHERE 
				login LIKE '%$termo%'";
				
			}else if($campo=="nivel"){
				
					$sql="SELECT * FROM administrador WHERE
					nivel='$termo'";
				
			}else{
				$sql="SELECT * FROM administrador WHERE
				cod_adm='$termo' OR nome LIKE '%$termo%'
				OR login LIKE '%$termo%'
				OR nivel='$termo'";
			}
		//var_dump($sql);
			$consulta=$this->con->consultar($sql);
			$this->con->desconectar();
			return $consulta;
		}

	public function verificarLogin($login) 
	{
		$sql="SELECT login FROM administrador WHERE login='$login'";
		$consulta=$this->con->consultar($sql);
			if(!$consulta){ 
				return true; 
			}else{ 
				return false;
			}
		}

		public function alterarSenha($nova_senha,$cod_adm)
		{
			$sql="UPDATE administrador SET senha='$nova_senha' 
			WHERE cod_adm=$cod_adm";
		//var_dump($sql);
			$resposta=$this->con->executar($sql);
			$this->con->desconectar();
			return $resposta;
		}

		public function verificarSenha($cod_adm,$senha)
		{
			$sql="SELECT senha from administrador 
			WHERE cod_adm=$cod_adm";
			$consulta=$this->con->consultar($sql);
			if(!$consulta){
				return false;
			}else{
				$linha=$consulta->fetch_assoc();
				if (password_verify($senha,$linha['senha'])) {
					return true;
				}else{
					return false;
				}
			}
		}

		public function contar()
	{
		$sql="SELECT COUNT(cod_adm) AS 'quantidade' 
		FROM administrador";
		$consulta=$this->con->consultar($sql);
		$linha=$consulta->fetch_assoc();
		return $linha['quantidade'];
	}

	public function contarFuncionarios()
	{
		// Filtra a contagem apenas por funcionários 
		$sql="SELECT COUNT(cod_adm) AS 'quantidade' 
		FROM administrador WHERE nivel = '2'";
		$consulta=$this->con->consultar($sql);
		if(!$consulta){
			return 0;
		}
		$linha=$consulta->fetch_assoc();
		return $linha['quantidade'];
	}

	public function alterar($administrador)
{
    $sql="UPDATE administrador SET 
    nome='".$administrador->getNome()."',
    login='".$administrador->getLogin()."',
    senha='".$administrador->getSenha()."',
    nivel='".$administrador->getNivel()."'
    WHERE cod_adm='".$administrador->getCodAdm()."'";

    $resposta=$this->con->executar($sql);
    $this->con->desconectar();

    return $resposta;
}

public function excluir($cod_adm)

	{
	
		$sql="DELETE FROM administrador WHERE cod_adm=$cod_adm"; 
		$resposta=$this->con->executar($sql);
		$this->con->desconectar();
		return $resposta;
	}

}
?>
