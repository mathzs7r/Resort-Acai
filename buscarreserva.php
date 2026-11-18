<?php require_once 'cabecalho.php';
require_once 'menu.php';
if (isset($_COOKIE['administrador'])) {
?>

<form action='buscarreserva.php' method="GET" id="form">
<div id="loader" style="display: none;"><img src="img/loader.gif"></div>
		<h1>Buscar Histórico de Reservas</h1>
		<p><br></p>
		<p>Termo:</p>
		<p><input type="search" name="termo" size="40" maxlength="70" pattern="[0-9a-zA-Z/s-çÇãÃéÉúÚóÓêÊíÍ\(\)]{1,70}" placeholder="Buscar termo" title="Busque somente por Código, Data de Entrada, Data de Saída, CPF do Hóspede, Quarto e Administrador" required></p>
		<p><br></p>
		<p>Categoria:</p>
		<p>
			<input type="radio" name="campo" value="cod_res"> Código&nbsp;
			<input type="radio" name="campo" value="data_ent"> Data de Entrada&nbsp;<br/>
			<input type="radio" name="campo" value="data_sai"> Data de Saída&nbsp;
			<input type="radio" name="campo" value="cpf"> CPF do Hóspede&nbsp;<br/>
			<input type="radio" name="campo" value="quarto"> Quarto&nbsp;
			<input type="radio" name="campo" value="cod_adm"> Administrador
		</p>
		<p><input type="submit" name="botao" value="Buscar"></p>
	</form>
	<script src="js/loader.js"></script>
	<?php
	if (isset($_GET['botao'])) {
		require_once 'persistence/ReservaPA.php';
		require_once 'persistence/HospedePA.php';
		require_once 'model/Hospede.php';
			$reservapa=new ReservaPA();
			if(isset($_GET['campo'])&&$_GET['campo']!=""){
				$consulta=$reservapa->buscar($_GET['termo'],($_GET['campo']));
			}else{
				$consulta=$reservapa->buscar($_GET['termo'],'');
			}
			if(!$consulta){
				echo "<h2>Nenhum resultado encontrado.</h2>";
			}else{
				require_once 'model/Reserva.php';
				$reserva=new Reserva();
				$hospede=new Hospede();
				$hospedepa=new HospedePA();
				
				echo "<table>";
				echo "<tr>";
				echo "<th>Código</th>";
				echo "<th>Data de Entrada</th>";
				echo "<th>Data de Saída</th>";			
				echo "<th>CPF do Hóspede</th>";
				echo "<th>Nome do Hóspede</th>";
				echo "<th>Quarto</th>";
				echo "<th>Total</th>";
				echo "<th>Administrador</th>";
				//echo "<th>CHECKOUT</th>";
				echo "<th>Editar ou Excluir</th>";
				echo "</tr>";

				while($linha=$consulta->fetch_assoc()){
					$reserva->setCodRes($linha['cod_res']);
					$reserva->setDataEnt($linha['data_ent']);
					$reserva->setDataSai($linha['data_sai']);
					$reserva->setCpf($linha['cpf']);
					$hospede->setNome($linha['nome']);
					$reserva->setQuarto($linha['quarto']);
					$reserva->setTotal($linha['total']);
					$reserva->setCodAdm($linha['cod_adm']);
					$dataent=new DateTime($reserva->getDataEnt());
					$datasai=new DateTime($reserva->getDataSai());

					echo "<tr>";
					echo "<td>".$reserva->getCodRes()."</td>";
					echo "<td>".$dataent->format('d/m/Y')."</td>";
					echo "<td>".$datasai->format('d/m/Y')."</td>";
					echo "<td>".$reserva->getCpf()."</td>";
					echo "<td>".$hospede->getNome()."</td>";
					echo "<td>".$reserva->getQuarto()."</td>";				
					echo "<td>R$ ".$reserva->getTotal()."</td>";				
					echo "<td>".$reserva->getCodAdm()."</td>";
					//echo "<td><a href='checkout.php?cod_res=".$reserva->getCodRes()."'><img src='img/shoptag white.png'></a></td>";
					echo "<td><a href='alterarreserva.php?cod_res=".$reserva->getCodRes()."'><img src='img/edit white.png'></a> &nbsp;
					<a href='excluirreserva.php?cod_res=".$reserva->getCodRes()."'><img src='img/delete white.png'></a></td>";
					echo "</tr>";
				}
				echo "</table>";
			}
	}

}else{
header('location: login.php');
}
require_once 'footer.php';
?>	
</body>
</html>