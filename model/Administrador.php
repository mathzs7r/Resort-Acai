<?php

class Administrador{

	private $cod_adm;
	private $nome;
	private $login;
	private $senha;
	private $nivel;

	public function setCodAdm($cod_adm)
	{
		$this->cod_adm=$cod_adm;
	}
	public function getCodAdm()
	{
		return $this->cod_adm;
	}
	public function setNome($nome)
	{
		$this->nome=$nome;
	}
	public function getNome()
	{
		return $this->nome;
	}
	public function setLogin($login)
	{
		$this->login=$login;
	}
	public function getLogin()
	{
		return $this->login;
	}
	public function setSenha($senha)
	{
		$this->senha=$senha;
	}
	public function getSenha()
	{
		return $this->senha;
	}
	public function setNivel($nivel)
	{
		$this->nivel=$nivel;
	}
	public function getNivel()
	{
		return $this->nivel;
	}
	public function logar()
	{
		setcookie("administrador",$this->cod_adm,0);
		setcookie("nivel",$this->nivel,0);
	}
	public function deslogar()
	{
		setcookie("administrador","");
		setcookie("nivel","");
	}

	public function criptografarSenha()
	{
		$this->senha= password_hash($this->senha, PASSWORD_DEFAULT);
	}



}
?>
