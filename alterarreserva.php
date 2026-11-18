<!-- Alterar Reserva -->

<?php require_once 'cabecalho.php';
require_once 'menu.php';
if (isset($_COOKIE['administrador'])) {

if (isset($_GET['cod_res'])) {
	require_once 'model/Reserva.php';
	require_once 'persistence/ReservaPA.php';
	require_once 'model/Hospede.php';
	require_once 'persistence/HospedePA.php';
	require_once 'model/Quarto.php';
	require_once 'persistence/QuartoPA.php';
	
	$reserva=new Reserva();
	$reservapa=new ReservaPA();
	$quarto=new Quarto();	
	$quartopa=new QuartoPA();	
	$hospede=new Hospede();
	$hospedepa=new HospedePA();

	$lista=$quartopa->listarQuartos();

	$consulta=$reservapa->buscar($_GET['cod_res'],'cod_res',$reserva);
	if (!$consulta) {
		echo "<h2>Reserva não encontrado! 
		<a href='buscarreserva.php'>Volte</a></h2>";
	}else{
		require_once 'persistence/ReservaPA.php';
		$reservapa=new ReservaPA();

		$linha=$consulta->fetch_assoc();
		$reserva->setCodRes($linha['cod_res']);
		$reserva->setCpf($linha['cpf']);
		$reserva->setDataEnt($linha['data_ent']);
		$reserva->setDataSai($linha['data_sai']);
		$reserva->setTotal($linha['total']);		
		$reserva->setQuarto($linha['quarto']);
		$reserva->setStatusRes($linha['status_res']);
		$reserva->setCodAdm($linha['cod_adm']);
		$hospede->setNome($linha['nome']);

		?>
		<form action="alterarreserva.php" method="POST" id="form" enctype="multipart/form-data">
			<div id="loader" style="display: none;"><img src="img/loader.gif"></div>
			<h1>Alterar Reservas</h1>
			<input type="hidden" name="cod_res"	value="<?= $reserva->getCodRes() ?>">
			<input type="hidden" name="cpf"	value="<?= $reserva->getCpf() ?>">
			<input type="hidden" name="status_res" value="<?= $reserva->getStatusRes() ?>" required></p>
			<input type="hidden" name="quartoanterior" value="<?= $reserva->getQuarto()?>" required></p>
			<p>Código:&nbsp;<?= $reserva->getCodRes() ?></p>
			<p>CPF do Hóspede:&nbsp;<?= $reserva->getCpf() ?></p>
			<p>Nome do Hóspede:&nbsp;<?= $hospede->getNome() ?></p>
			<p><br></p>
			<p>Data de Entrada</p>
			<p><input type="date" name="data_ent" value="<?= $reserva->getDataEnt()?>" required></p>
			<p>Data de Saída</p>
			<p><input type="date" name="data_sai" value="<?= $reserva->getDataSai()?>" required></p>
			<p>Quarto Atual:&nbsp;<?= $reserva->getQuarto() ?></p>
			<?php
			echo "<select name='quarto' required>";
			while ($linha=$lista->fetch_assoc()) {
				if($quartopa->verificarDisponibilidade($linha['numero'])){
					echo "<option value='".$linha['numero']."'>".$linha['numero']."</option>";
				}
			}
			echo "<option value='".$reserva->getQuarto()."' selected>Não Alterar</option>";
			echo "</select>";
			?>
			<p><br></p>
			<p>Total em R$:</p>
			<p><input type="number" name="total" min="0.01" max="9999.99" step="0.01" value="<?= $reserva->getTotal()?>" pattern="[0-9\,\.]" required></p>
			<p><input type="submit" name="botao" value="Alterar"></p>
			<p><button type="button" class="bnao"><a href="buscarreserva.php?termo=<?=$reserva->getCodRes()?>&campo=cod_res&botao=Buscar">Cancelar</a></button></p>
		</form>
		<script src="js/loader.js"></script>
		<?php
	}
}else if (isset($_POST['botao'])) {
	require_once 'persistence/ReservaPA.php';
	require_once 'model/Reserva.php';
	$reservapa=new ReservaPA();
	$reserva=new Reserva();

	$reserva->setCodRes($_POST['cod_res']);
	if ($reserva->getQuarto()!=$_POST['quartoanterior']&&$reserva->getStatusRes()!=0) {
		//se reserva ativa e quarto diferente, desocupar quarto anterior e ocupar quarto novo
		require_once 'model/Quarto.php';
		require_once 'persistence/QuartoPA.php';
		$quarto=new Quarto();
		$quartopa=new QuartoPA();
		$quarto->setNumero($_POST['quartoanterior']);
		$quartopa->desocupar($quarto);
		$quarto->setNumero($_POST['quarto']);
		$quartopa->ocupar($quarto);
	}

	$reserva->setCodRes($_POST['cod_res']);
	$reserva->setCpf($_POST['cpf']);
	$reserva->setDataEnt($_POST['data_ent']);
	$reserva->setDataSai($_POST['data_sai']);
	$reserva->setTotal($_POST['total']);		
	$reserva->setQuarto($_POST['quarto']);
	$reserva->setStatusRes($_POST['status_res']);
	$reserva->setCodAdm($_COOKIE['administrador']);

	if($reservapa->alterar($reserva)){
		echo "<h2>Reserva alterada com sucesso!</h2>";
	}else{
		echo "<h2>Erro na tentativa de alterar! 
		<a href='buscarreserva.php?termo=".$reserva->getCodRes()."&campo=cod_res&botao=Buscar'> Tente novamente!</a></h2>";
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
