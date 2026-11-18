<?php 
require_once 'Banco.php';

class ReservaPA{

	private $con;
	
	public function __construct(){
		$this->con=new Banco();
	}

	public function Cadastrar($reserva){
		$sql = "INSERT INTO reserva (total, data_ent, data_sai, cpf, quarto, cod_adm, status_res) VALUES(
			
			".$reserva->getTotal().",
			'".$reserva->getDataEnt()."',
			'".$reserva->getDataSai()."',
			".$reserva->getCpf().",
			".$reserva->getQuarto().",
			".$reserva->getCodAdm().",
			".$reserva->getStatusRes()."
		)";
		//var_dump($sql);
		$resposta = $this->con->executar($sql);
		$this->con->desconectar();
		return $resposta;
	}

	public function listar($limite, $offset)	
	{
		$sql = "SELECT r.cod_res, r.total, r.data_ent, r.data_sai, r.quarto, r.cod_adm, r.status_res, h.cpf, h.nome FROM reserva r JOIN hospede h USING (cpf) ORDER BY r.cod_res LIMIT $limite OFFSET $offset";
		$consulta=$this->con->consultar($sql);
		$this->con->desconectar();
		return $consulta;		
	}

	public function contar()
	{
		$sql="SELECT COUNT(cod_res) AS 'quantidade' FROM reserva";
		$consulta=$this->con->consultar($sql);
		$linha=$consulta->fetch_assoc();
		return $linha['quantidade'];
	}

	//AQUI
	public function buscar($termo,$campo)
	{
		if ($campo=="cod_res") {
			
				$sql="SELECT r.cod_res, r.total, r.data_ent, r.data_sai, r.quarto, r.cod_adm, r.status_res, h.cpf, h.nome FROM reserva r JOIN hospede h USING (cpf) WHERE cod_res='$termo'";
					//var_dump($sql);
			
		}else if($campo=="data_ent"){
			$sql="SELECT r.cod_res, r.total, r.data_ent, r.data_sai, r.quarto, r.cod_adm, r.status_res, h.cpf, h.nome FROM reserva r JOIN hospede h USING (cpf) WHERE data_ent LIKE '%$termo%'";
		}else if($campo=="data_sai"){
			$sql="SELECT r.cod_res, r.total, r.data_ent, r.data_sai, r.quarto, r.cod_adm, r.status_res, h.cpf, h.nome FROM reserva r JOIN hospede h USING (cpf) WHERE data_sai LIKE '%$termo%'";
		}else if($campo=="cpf"){
			$sql="SELECT r.cod_res, r.total, r.data_ent, r.data_sai, r.quarto, r.cod_adm, r.status_res, h.cpf, h.nome FROM reserva r JOIN hospede h USING (cpf) WHERE cpf LIKE '%$termo%'";
		}else if($campo=="quarto"){
			$sql="SELECT r.cod_res, r.total, r.data_ent, r.data_sai, r.quarto, r.cod_adm, r.status_res, h.cpf, h.nome FROM reserva r JOIN hospede h USING (cpf) WHERE quarto='$termo'";			
		}else if($campo=="cod_adm"){
			
				$sql="SELECT r.cod_res, r.total, r.data_ent, r.data_sai, r.quarto, r.cod_adm, r.status_res, h.cpf, h.nome FROM reserva r JOIN hospede h USING (cpf) WHERE cod_adm='$termo'";
			
		}else if($campo=="status_res"){
			$sql="SELECT r.cod_res, r.total, r.data_ent, r.data_sai, r.quarto, r.cod_adm, r.status_res, h.cpf, h.nome FROM reserva r JOIN hospede h USING (cpf) WHERE status_res == '$termo'";
		}else{
			$sql="SELECT r.cod_res, r.total, r.data_ent, r.data_sai, r.quarto, r.cod_adm, r.status_res, h.cpf, h.nome FROM reserva r JOIN hospede h USING (cpf) WHERE
			cod_res='$termo' OR cod_adm='$termo' OR data_ent='$termo' OR data_sai='$termo' OR
			cpf='$termo' OR quarto='$termo'";
		}
			//var_dump($sql);
		$consulta=$this->con->consultar($sql);
		$this->con->desconectar();
		return $consulta;
	}

	public function alterar($reserva)
	{
		$sql="UPDATE reserva SET 
		data_ent='".$reserva->getDataEnt()."',
		data_sai='".$reserva->getDataSai()."',
		cpf=".$reserva->getCpf().",
		total=".$reserva->getTotal().",
		quarto=".$reserva->getQuarto().",
		cod_adm=".$reserva->getCodAdm().",
		status_res=".$reserva->getStatusRes()."
		WHERE cod_res=".$reserva->getCodRes();
		//var_dump($sql);
		$resposta=$this->con->executar($sql);
		$this->con->desconectar();
		return $resposta;
	}

	public function excluir($cod_res)
	{
		$sql="DELETE FROM reserva WHERE cod_res=$cod_res"; //WHERE cod_res=$cod=_res"; para dar erro
		$resposta=$this->con->executar($sql);
		$this->con->desconectar();
		return $resposta;
	}

		public function listarAtivas($limite, $offset)	
	{
		$sql = "SELECT r.cod_res, r.total, r.data_ent, r.data_sai, r.quarto, r.cod_adm, r.status_res, h.cpf, h.nome FROM reserva r JOIN hospede h USING (cpf) WHERE r.status_res =1 ORDER BY r.cod_res LIMIT $limite OFFSET $offset";
		//var_dump($sql);
		$consulta=$this->con->consultar($sql);
		$this->con->desconectar();
		return $consulta;		
	}

	public function checkoutReserva($reserva)

	{
		$sql="UPDATE reserva SET 
		
		status_res=0
		
		WHERE cod_res=".$reserva->getCodRes()."";
		$resposta=$this->con->executar($sql);
		$this->con->desconectar();
		return $resposta;
	}


}

?>