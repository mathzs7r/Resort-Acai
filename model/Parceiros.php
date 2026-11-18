<?php

class Parceiros{
	
	private $cnpj;
	private $logo;
	private $telefone;
	private $descricao;
	private $nome;
	private $cod_adm;

	public function setCnpj($cnpj)
	{
		$this->cnpj=str_replace([".","-","/"],"",$cnpj);
	}
	public function getCnpj()
	{
		return $this->cnpj;
	}
	public function setLogo($logo)
	{
		$this->logo=$logo;
	}
	public function getLogo()
	{
		return $this->logo;
	}
	public function setTelefone($telefone)
	{
		$this->telefone=$telefone;
	}
	public function getTelefone()
	{
		return $this->telefone;
	}
	public function setDescricao($descricao)
	{
		$this->descricao=$descricao;
	}
	public function getDescricao()
	{
		return $this->descricao;
	}
		public function setNome($nome)
	{
		$this->nome=$nome;
	}
	public function getNome()
	{
		return $this->nome;
	}
	public function setCodAdm($cod_adm)
	{
		$this->cod_adm=$cod_adm;
	}
	public function getCodAdm()
	{
		return $this->cod_adm;
	}

	public function verificarTamanho($logo)
	{
		if (filesize($logo)>65530) { //65kb
			return false;
		}else{
			return true;
		}
	}
	public function criarImagem()
	{
		$this->logo=addsLashes(file_get_contents($this->logo));
	}
}
?>
