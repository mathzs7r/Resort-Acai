<?php require_once 'cabecalho.php';
require_once 'menu.php';

if (isset($_COOKIE['administrador'])) {

require_once 'persistence/QuartoPA.php';
require_once 'persistence/HospedePA.php';
$quartopa=new QuartoPA();
$hospedepa=new HospedePA();
$lista=$quartopa->listarQuartos();
$lista2=$hospedepa->listarNomes();
if(!$lista||!$lista2){ //é necessário primeiro verificar se há quarto e hosp, pois é chave estrangeira em res
	echo "<h2>Não há quartos e/ou hóspedes cadastrados!</h2>";
	echo "<h2>Verifique se ambos estão cadastrados corretamente!</h2>";
}else{
	?>

	<form action="cadastrarreserva.php" method="POST" id="form">
		<div id="loader" style="display:none;"><img src="img/loader.gif"></div>
		<h1>Cadastrar Reserva</h1>
		<input type="hidden" name="status_res"	value=1>
		<p>CPF do Hóspede</p>
		<p><input type="text" name="cpf" maxlength="14" pattern="[0-9\.-]{14}" id="cpf" title="digite no formato XXX.XXX.XXX-XX" placeholder="XXX.XXX.XXX-XX" required></p>
		<p>Número do Quarto</p>
		<?php
		echo "<select name='quarto' required>";
		while ($linha=$lista->fetch_assoc()) {
			if($quartopa->verificarDisponibilidade($linha['numero'])){

				echo "<option value='".$linha['numero']."'>".$linha['numero']."</option>";
			}
		}
		echo "</select>";
		?>
		<p>Data de Entrada</p>
		<p><input type="date" name="data_ent" required></p>
		<p>Data de Saída</p>
		<p><input type="date" name="data_sai" required></p>
		<p><input type="submit" name="botao" value="Cadastrar"></p>
	</form>

	<?php
}
if (isset($_POST['botao'])) {
	require_once 'model/Quarto.php';
	require_once 'persistence/QuartoPA.php';
	require_once 'model/Reserva.php';
	require_once 'persistence/ReservaPA.php';
	require_once 'model/Hospede.php';
	require_once 'persistence/HospedePA.php';

	$quarto=new Quarto();
	$quartopa=new QuartoPA();
	$reserva=new Reserva();
	$reservapa=new ReservaPA();
	$hospede=new Hospede();
	$hospedepa=new HospedePA();
	$hospede->setCpf($_POST['cpf']);	

	$quarto->setNumero($_POST['quarto']);
	$dados_quarto=$quartopa->buscar($quarto->getNumero(),"numero");
	$linha=$dados_quarto->fetch_assoc();
	$valor=$linha['valor'];

	$data_ent=new DateTime($_POST['data_ent']);
	$data_sai=new DateTime($_POST['data_sai']);
	// $estadia=$data_sai-$data_ent;
	$estadia=$data_sai->diff($data_ent)->d;

	if ($data_sai<$data_ent) {
		echo "<p>A data de saída não pode ser anterior à data de entrada!Tente novamente.</p>";
	}else{

		if (!$hospedepa->verificarCpf($hospede->getCpf())) {
			//se o cpf do hospede é valido, prosseguir
			//calcular valor
			$total=$estadia*$valor;
			$reserva->setTotal($total);
			$reserva->setDataEnt($_POST['data_ent']);
			$reserva->setDataSai($_POST['data_sai']);
			$reserva->setCpf($_POST['cpf']);
			$reserva->setQuarto($_POST['quarto']);
			$reserva->setStatusRes($_POST['status_res']);
			$reserva->setCodAdm($_COOKIE['administrador']);

			if($reservapa->cadastrar($reserva)){
				$quartopa=new QuartoPA();
				$quartopa->ocupar($quarto);
				echo "<h2>Reserva registrada com sucesso!</h2>";
			}else{
				echo "<h2>Erro na tentativa de cadastrar! 
				Tente novamente!</h2>";
			}
		}else{
			echo "<h2>Hóspede não encontrado. Verifique o CPF.</h2>";
		}

	}
}


                }else{
                    header('location: login.php');
                    //recuperando funcional
                }
require_once 'footer.php';
                ?>
<script src="js/loader.js"></script>
</body>
</html>
