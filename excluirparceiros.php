<?php require_once 'cabecalho.php';
require_once 'menu.php';
if(isset($_COOKIE['administrador']) && $_COOKIE['nivel'] <= 2){


if (isset($_GET['cnpj'])) {
	require_once 'model/Parceiros.php';
	require_once 'persistence/ParceirosPA.php';
	$parceiros=new Parceiros();
	$parceirospa=new ParceirosPA();

	$parceiros->setCnpj($_GET['cnpj']);
	$consulta=$parceirospa->buscar($parceiros->getCnpj(),'cnpj');
	$linha=$consulta->fetch_assoc();
	$parceiros->setNome($linha['nome']);
?>

<form action="excluirparceiros.php" method="POST" id="form">
	<div id="loader" style="display: none;">
		<img src="img/loader.gif">
	</div>
	<h1>Excluir</h1>
	<p>Tem certeza que deseja excluir o 
		<big><?= $parceiros->getNome() ?></big></p>
	<input type="hidden" name="cnpj" value="<?= $parceiros->getCnpj() ?>">
	<p>
		<input type="submit" name="botao" value="Sim">
		<button class="bnao"><a href="buscarparceiro.php?termo=
			<?=	$parceiros->getCnpj() ?>
			&campo=cnpj&botao=Buscar">
		Não</a></button>
	</p>
</form>
<script src="js/loader.js"></script>
<?php

}else if (isset($_POST['botao'])) {
	require_once 'model/Parceiros.php';
	require_once 'persistence/ParceirosPA.php';
	$parceiros=new Parceiros();
	$parceirospa=new ParceirosPA();

	$parceiros->setCnpj($_POST['cnpj']);
	if($parceirospa->excluir($parceiros->getCnpj())){
		echo "<h2>Excluído com sucesso! 
		<a href='buscarparceiro.php'>Outro?</a></h2>";
	}else{
		echo "<h2>Erro na tentativa de excluir! 
		<a href='buscarparceiro.php?termo=".
		$parceiros->getCnpj()."&campo=cnpj& 
		botao=Buscar'>Tente Novamente!</a></h2>";
	}
}else{
	echo "<h2>Ops aconteceu um Erro: 404! 
	<a href='index.php'>Voltar</a></h2>";
	
}
?>
<?php
                }else{
                    header('location: login.php');
                }
require_once 'footer.php';
                ?>
</body>
</html>