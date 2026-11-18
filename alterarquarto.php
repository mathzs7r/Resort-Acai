<?php require_once 'cabecalho.php';
require_once 'menu.php';
if (isset($_COOKIE['administrador'])&&isset($_COOKIE['nivel']) && $_COOKIE['nivel'] <= 2) {

if (isset($_GET['numero'])) {
	require_once 'persistence/QuartoPA.php';
	$quartopa=new QuartoPA();
	require_once 'model/Quarto.php';
	$quarto=new Quarto();
	$consulta=$quartopa->buscar($_GET['numero'],
		'numero',$quarto);
	if (!$consulta) {
		echo "<h2>Quarto não encontrado! 
		<a href='buscarquar.php'>Volte</a></h2>";
	}else{
		require_once 'persistence/QuartoPA.php';
		$quartopa=new QuartoPA();

		$linha=$consulta->fetch_assoc();
		$quarto->setNumero($linha['numero']);
		$quarto->setStatus($linha['status']);
		$quarto->setCama($linha['cama']);		
		$quarto->setNivel($linha['nivel']);
		$quarto->setDescricao($linha['descricao']);
		$quarto->setValor($linha['valor']);
		$quarto->setFoto($linha['foto']);
?>
<form action="alterarquarto.php" method="POST"
id="form" enctype="multipart/form-data">
	<div id="loader" style="display: none;">
		<img src="img/loader.gif">
	</div>
	<h1>Alterar Quartos</h1>
	<input type="hidden" name="numero"
	value="<?= $quarto->getNumero() ?>">
	<input type="hidden" name="status" value="<?= $quarto->getStatus() ?>" 	
		required></p>
	<p>Número de camas</p>
	<p><input type="number" name="cama" value="<?= $quarto->getCama()?>"  maxlength="1" max='4' min='1' required></p>
	<p>Nível</p>
	<p><select name="nivel" value="<?= $quarto->getNivel()?>"></p>
		<option value="1">Básico</option>
		<option value="2">Luxo</option>
		<option value="3">Premium</option>
		<option value="4">Master</option>
	</select></p>	
	<p>Descrição:</p>
	<p><textarea name="descricao" cols="40" rows="6" maxlength="240" title="somente letras e números, máx. de 240 caracteres."
		required><?= $quarto->getDescricao()?></textarea></p>	
	<p>Valor:</p>
	<p><input type="text" name="valor"
		min="0.01" max="9999.99" maxlength="7" size="7" pattern="[0-9\,.]{1,7}" id="valor" placeholder="0,00"
		value="<?= $quarto->getValor() ?>"
		required></p>	
	<p>Foto atual:</p>
	<img src="data:image/jpg;base64,
	<?= base64_encode($quarto->getFoto())?>">
	<p>Escolher outra?</p>
	<p><input type="file" name="foto" 
		accept=".jpg,.jpeg,.gif,.png,.bmp"></p>
	<p>Quarto</p>

	<p><input type="submit" name="botao" value="Alterar"></p>
	<p><button type="button" class="bnao"><a href="buscarquarto.php?termo=<?=$quarto->getNumero()?>&campo=numero&botao=Buscar">Cancelar</a></button></p>
</form>
<script src="js/loader.js"></script>
<?php
	}
}else if (isset($_POST['botao'])) {
	require_once 'persistence/QuartoPA.php';
	require_once 'model/Quarto.php';
	$quartopa=new QuartoPA();
	$quarto=new Quarto();

	if (isset($_FILES['foto'])&&$_FILES['foto']['tmp_name']!="") {
		$quarto->setFoto($_FILES['foto']['tmp_name']);
		//if ($quarto->verificarTamanho($quarto->getFoto())) {
		if ($quarto) {
			$quarto->criarImagem();
			$flag=true;
		}else{
			echo "<h2>Imagem muito grande! Máx. 65Kb!</h2>";
			$flag=false;
		}
	}else{
		$quarto->setFoto(addslashes(
			$quartopa->retornarImagem($_POST['numero']))); 
		$flag=true;
	}
	if ($flag) {
		$quarto->setNumero($_POST['numero']);
		$quarto->setStatus($_POST['status']);
		$quarto->setCama($_POST['cama']);
		$quarto->setNivel($_POST['nivel']);
		$quarto->setDescricao($_POST['descricao']);
		$quarto->setValor($_POST['valor']);

		if($quartopa->alterar($quarto)){
			echo "<h2>Quarto alterado com sucesso!</h2>";
		}else{
			echo "<h2>Erro na tentativa de alterar! Tente 
			<a href='buscarquarto.php?termo=".$quarto->getNumero().
			"&campo=numero&botao=Buscar'>novamente</a>!</h2>";
		}
	}
}else{
	header('location: index.php');
}

}else{
header('location: login.php');
}
require_once 'footer.php';
?>
</body>
</html>