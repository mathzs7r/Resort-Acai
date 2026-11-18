<?php require_once 'cabecalho.php';
require_once 'menu.php';
if(isset($_COOKIE['administrador'])&&isset($_COOKIE['nivel']) && $_COOKIE['nivel'] <= 2){

?>
<form action="cadastrarquarto.php" enctype="multipart/form-data" method="POST" id="form">
	<div id="loader" style="display:none;"><img src="img/loader.gif"></div>
	<h1>Cadastrar Quarto</h1>
	<p>Número do Quarto</p>
	<p><input type="number" name="numero" maxlength="4" placeholder="Digite um número" title="Somente números" required></p>
	<p>Número de camas</p>
	<p><input type="number" name="cama" max="4" maxlength="1" placeholder="Digite o número de camas" title="Somente números" required></p>
	<p>Nível</p>
	<p><select name="nivel"> </p>
		<option value="1">Básico</option>
		<option value="2">Luxo</option>
		<option value="3">Premium</option>
		<option value="4">Master</option>
	</select></p>
	<p>Descrição:</p>
	<p><textarea cols="60" rows="4" maxlength="240" name="descricao" placeholder="Descrição do quarto" required></textarea></p>
	<p>Valor da Diária:</p>
	<p>R$ <input type="text" name="valor" min="0.01" max="9999.99" pattern="[0-9]{1,4}\.[0-9]{2}" title="1 a 4 casas antes do ponto e duas casas decimais" id="valor" placeholder="0.00" required></p>
	<p>Imagem:</p>
	<p><input type="file" name="foto" accept=".jpg,.jpeg,.gif,.bmp,.png,.webp" required></p>
	<!--status é hidden pois por padrao está disponivel, e no cadastro de reserva poderá ser definido como disponivel/ocupado -->
	<input type="hidden" name="status" value="1">
	<p><input type="submit" name="botao" value="Cadastrar"></p>
</form>

<?php
if (isset($_POST['botao'])) {
	require_once 'model/Quarto.php';
	require_once 'persistence/QuartoPA.php';
	$quarto=new Quarto();
	$quartopa=new QuartoPA();
	$quarto->setFoto($_FILES['foto']['tmp_name']);

	$quarto->criarImagem();
	$quarto->setNumero($_POST['numero']);
	$quarto->setCama($_POST['cama']);
	$quarto->setNivel($_POST['nivel']);
	$quarto->setDescricao($_POST['descricao']);
	$quarto->setStatus($_POST['status']);
	$quarto->setValor($_POST['valor']);

	if($quartopa->cadastrar($quarto)){
		echo "<h2>Quarto cadastrado com sucesso!</h2>";
	}else{
		echo "<h2>Erro na tentativa de cadastrar! 
		Tente novamente!</h2>";
	}
}

?>
<script src="js/loader.js"></script>
<?php
		}else{
		header('location: login.php');
		}
require_once 'footer.php';
?>
</body>
</html>
