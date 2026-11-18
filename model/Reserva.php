<?php 

class Reserva{

	private $cod_res;
	private $data_sai;
	private $total;
	private $data_ent;
	private $cpf;
	private $quarto;
	private $cod_adm;
	private $status_res;

	public function setCodRes($cod_res)
	{
		$this->cod_res=$cod_res;
	}

	public function getCodRes()
	{
		return $this->cod_res;
	}


	public function setDataSai($data_sai)
	{
		$this->data_sai=$data_sai;
	}

	public function getDataSai()
	{
		return $this->data_sai;
	}

	public function setTotal($total)
	{
		$this->total=$total;
	}

	public function getTotal()
	{
		return $this->total;
	}

	public function setDataEnt($data_ent)
	{
		$this->data_ent=$data_ent;
	}

	public function getDataEnt()
	{
		return $this->data_ent;
	}

	public function setCpf($cpf)
	{
		$this->cpf=str_replace([".","-"],"",$cpf);
	}

	public function getCpf()
	{
		return $this->cpf;
	}

	public function setQuarto($quarto)
	{
		$this->quarto=$quarto;
	}

	public function getQuarto()
	{
		return $this->quarto;
	}

	public function setCodAdm($cod_adm)
	{
		$this->cod_adm=$cod_adm;
	}

	public function getCodAdm()
	{
		return $this->cod_adm;
	}

	public function setStatusRes($status_res)
	{
		$this->status_res=$status_res;
	}

	public function getStatusRes()
	{
		return $this->status_res;
	}
}
?>