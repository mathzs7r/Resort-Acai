<!-- Excluir Reserva -->
<?php require_once 'cabecalho.php';
require_once 'menu.php';

if (isset($_COOKIE['administrador'])) {

if (isset($_GET['cod_res'])){
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
$consulta=$reservapa->buscar($_GET['cod_res'],'cod_res',$reserva);

if (!$consulta) {
	echo "<h2>Reserva não encontrada! 
	<a href='buscarreserva.php'>Voltar</a></h2>";
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
	$dataent=new DateTime($reserva->getDataEnt());
	$datasai=new DateTime($reserva->getDataSai());
	$status=$reserva->getStatusRes();
?>
	<form action="excluirreserva.php" method="POST" id="form">
	<div id="loader" style="display: none;"><img src="img/loader.gif"> </div>
	<h1>Excluir Reserva</h1>
	<input type="hidden" name="cod_res"	value="<?= $reserva->getCodRes()?>">
	<input type="hidden" name="quarto" value="<?= $reserva->getQuarto()?>"></p>
	<input type="hidden" name="status" value="<?= $reserva->getStatusRes()?>"></p>
	<p><br></p>
	<p>Código:&nbsp;<?= $reserva->getCodRes() ?></p>
	<p>CPF do Hóspede:&nbsp;<?= $reserva->getCpf() ?></p>
	<p>Nome do Hóspede:&nbsp;<?= $hospede->getNome() ?></p>
	<p>Quarto:&nbsp;<?= $reserva->getQuarto() ?></p>
	<p>Data de Entrada:&nbsp;<?= $dataent->format('d/m/Y') ?></p>
	<p>Data de Saída:&nbsp;<?= $datasai->format('d/m/Y') ?></p>
	<p><br></p>
	<h2>Deseja EXCLUIR PERMANENTEMENTE ou apenas tornar inativa?</h2>
	<p>*a operação de exclusão não pode ser desfeita*</p>
<?php
	echo "<select name='desativar' required>";
	if($status==1){ //se reserva ativa no momento, dar opção de desativar
	echo "<option value='1' selected>Tornar Inativa</option>";
	}
	echo "<option value='0'>Excluir *permanentemente*</option>";
	echo "</select>";
?>
	<p><br></p>
	<p><input type="submit" name="botao" value="Remover Reserva"></p>
	<p><button><a href="buscarreserva.php?termo=<?=$reserva->getCodRes()?>&campo=cod_res&botao=Buscar">Cancelar</button></p>
	</form>
	<script src="js/loader.js"></script>
<?php
}
	}else if (isset($_POST['botao'])){
	require_once 'model/Reserva.php';
	require_once 'persistence/ReservaPA.php';			
	require_once 'model/Quarto.php';
	require_once 'persistence/QuartoPA.php';
	$reserva=new Reserva();
	$reservapa=new ReservaPA();
	$quarto=new Quarto();
	$quartopa=new QuartoPA();
	$quarto->setNumero($_POST['quarto']);
	$reserva->setCodRes($_POST['cod_res']);
	$desativar=$_POST['desativar'];
	$status=$_POST['status'];

	if ($desativar==0) { //se o usuario selecionou excluir permanentemente
		if ($status==1) { //se a reserva está ativa no momento e vai ser excluida, liberar quarto
		$quartopa->desocupar($quarto);
		}
		if($reservapa->excluir($reserva->getCodRes())){
		echo "<section class='paginacao'><h2>Reserva excluída com sucesso! <br><button><a href='buscarreserva.php'>Voltar</a></button></h2></section>";
		}else{
		echo "<section class='paginacao'><h2>ERRO NA TENTATIVA DE EXCLUIR <br><button>
		<a href='buscarreserva.php?termo=<?='.$reserva->getCodRes().'?>&campo=cod_res&botao=Buscar'>Voltar</a></button></h2></section>";
		}
	}else if ($desativar==1) { //se o usuario selecionou tornar inativa, sempre desocupar quarto pois essa opcao so aparece se a reserva estiver ativa
		if($quartopa->desocupar($quarto)&&$reservapa->checkoutReserva($reserva)){
		echo "<section class='paginacao'><h2>Desativação realizada com sucesso! <br><button><a href='reservasativas.php'>Voltar</a> </button></h2></section>";
		}else{
		echo "<section class='paginacao'><h2>ERRO NA TENTATIVA DE DESATIVAR <br><button><a href='reservasativas.php'>Voltar</a></button></h2></section>";
		}
	}

}else{
header('location: index.php');
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