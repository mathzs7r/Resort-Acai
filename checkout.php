<?php require_once 'cabecalho.php';
require_once 'menu.php';
if (isset($_COOKIE['administrador'])) {

if (isset($_GET['cod_res'])){
	require_once 'model/Reserva.php';
	require_once 'persistence/ReservaPA.php';
	require_once 'model/Quarto.php';
	require_once 'persistence/QuartoPA.php';
	require_once 'model/Hospede.php';
	require_once 'persistence/HospedePA.php';

	$reserva=new Reserva();
	$reservapa=new ReservaPA();
	$quarto=new Quarto();
	$quartopa=new QuartoPA();
	$hospede=new Hospede();
	$hospedepa=new HospedePA();

	$reserva->setCodRes($_GET['cod_res']);
	$consulta=$reservapa->buscar($reserva->getCodRes(),'cod_res');
	$linha=$consulta->fetch_assoc();

	$reserva->setCodRes($linha['cod_res']);
	$reserva->setTotal($linha['total']);
	$reserva->setDataEnt($linha['data_ent']);
	$reserva->setDataSai($linha['data_sai']);
	$reserva->setCpf($linha['cpf']);
	$reserva->setQuarto($linha['quarto']);
	$reserva->setCodAdm($linha['cod_adm']);
	$hospede->setNome($linha['nome']);
	$dataent=new DateTime($reserva->getDataEnt());
	$datasai=new DateTime($reserva->getDataSai());

?>

<form action="checkout.php" method="POST" id="form">
	<div id="loader" style="display: none;"><img src="img/loader.gif"> </div>
	<h1>Fazer Checkout</h1>
	<input type="hidden" name="quarto" value="<?= $reserva->getQuarto() ?>">
	<input type="hidden" name="cod_res" value="<?= $reserva->getCodRes() ?>">
	<p><br></p>
	<p>Código:&nbsp;<?= $reserva->getCodRes() ?></p>
	<p>Valor da reserva: R$&nbsp;<?= $reserva->getTotal() ?></p>
	<p>Data de Entrada:&nbsp;<?= $dataent->format('d/m/Y') ?></p>
	<p>Data de Saída:&nbsp;<?= $datasai->format('d/m/Y') ?></p>
	<p>CPF do Hóspede:&nbsp;<?= $reserva->getCpf() ?></p>
	<p>Nome do Hóspede:&nbsp;<?= $hospede->getNome() ?></p>
	<p>Quarto:&nbsp;<?= $reserva->getQuarto() ?></p>
	<p><br></p>
	
	<p><input type="submit" name="botao" value="Fazer Checkout"></p>
	<p><button type="button" class="bnao"><a href="buscarreserva.php?termo=<?=$reserva->getCodRes()?>&campo=cod_fab&botao=Buscar">Cancelar</a></button></p>
	
</form>
<script src="js/loader.js"></script>
<?php
}else if (isset($_POST['botao'])){
	
	require_once 'model/Reserva.php';
	require_once 'persistence/ReservaPA.php';
	require_once 'model/Quarto.php';
	require_once 'persistence/QuartoPA.php';
	// require_once 'model/Hospede.php';
	// require_once 'persistence/HospedePA.php';
	$reserva=new Reserva();
	$reservapa=new ReservaPA();
	$quarto=new Quarto();
	$quartopa=new QuartoPA();
	// $hospede=new Hospede();
	// $hospedepa=new HospedePA();

	$quarto->setNumero($_POST['quarto']);
	$reserva->setCodRes($_POST['cod_res']);

	if($quartopa->desocupar($quarto)&&$reservapa->checkoutReserva($reserva)){
		echo "<section class='paginacao'><h2>Checkout realizado com sucesso! <br><button><a href='reservasativas.php'>Voltar</a> </button></h2></section>";
	}else{
		echo "<section class='paginacao'><h2>ERRO NA TENTATIVA DE CHECKOUT <br><button><a href='reservasativas.php'>Voltar</a></button></h2></section>";
	}
}else{
	echo "<section class='paginacao'><h2>Erro 404</h2><br><button><a href='index.php'>Voltar</a></button></h2></section>";
}

}else{
    header('location: login.php');
    }
require_once 'footer.php';
?>

</body>
</html>