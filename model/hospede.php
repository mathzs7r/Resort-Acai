<?php

class Hospede{

	private $cpf;
	private $nome;
	private $endereco;
	private $telefone;
	private $cidade;

	public function setCpf($cpf)
	{
		$this->cpf=str_replace([".","-"],"",$cpf);
	}

	public function getCpf()
	{
		return $this->cpf;
	}

	public function setNome($nome)
	{
		$this->nome=$nome;
	}

	public function getNome()
	{
		return $this->nome;
	}

	public function setEndereco($endereco)
	{
		$this->endereco=$endereco;
	}

	public function getEndereco()
	{
		return $this->endereco;
	}


	public function setTelefone($telefone)
	{
		$this->telefone=$telefone;
	}

	public function getTelefone()
	{
		return $this->telefone;
	}


	public function setCidade($cidade)
	{
		$this->cidade=$cidade;
	}

	public function getCidade()
	{
		return $this->cidade;
	}


}

?>