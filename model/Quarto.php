<?php

class Quarto{
	private $numero;
	private $cama;
	private $nivel;
	private $descricao;
	private $status;
	private $foto;
	private $valor;

	public function setNumero($numero)
	{
		$this->numero=$numero;
	}
	public function getNumero()
	{
		 return $this->numero;
	}

	public function setCama($cama)
	{
		$this->cama=$cama;
	}
	public function getCama()
	{
		 return $this->cama;
	}

	public function setNivel($nivel)
	{
		$this->nivel=$nivel;
	}
	public function getNivel()
	{
		 return $this->nivel;
	}

	public function setDescricao($descricao)
	{
		$this->descricao=$descricao;
	}
	public function getDescricao()
	{
		 return $this->descricao;
	}

	public function setStatus($status)
	{
		$this->status=$status;
	}
	public function getStatus()
	{
		 return $this->status;
	}

	public function setFoto($foto)
	{
		$this->foto=$foto;
	}
	public function getFoto()
	{
		 return $this->foto;
	}

	public function setValor($valor)
	{
		$this->valor=$valor;
	}
	public function getValor()
	{
		 return $this->valor;
	}

	public function criarImagem()
	{
		$this->foto=addslashes(file_get_contents($this->foto));
	}


}
?>