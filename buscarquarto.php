<?php
require_once'cabecalho.php';
require_once 'menu.php';
if (isset($_COOKIE['administrador'])&&isset($_COOKIE['nivel']) && $_COOKIE['nivel'] <= 2) {
	?>

	<form action="buscarquarto.php" method="GET" id="form">
		<div id="loader" style="display:none;"><img src="img/loader.gif"></div>
		<h1>Buscar Quarto</h1>
		<p>Termo:</p>
		<p><input type="search" name="termo" size="40" maxlength="70" pattern="[0-9a-zA-Z\s\-çÇáÁãÃéÉúÚóÓêÊíÍ\)\(]{1,70}" placeholder="Buscar termo" title="Busque somente por Número do Quarto, Quantidade de Camas, Nível do quarto (1-4), Status (ocupado-disponível), Valor e Descrição" required></p>
		<p><br></p>
		<p>Categoria:</p>
		<p>
			<input type="radio" name="campo" value="numero"> Número&nbsp;
			<input type="radio" name="campo" value="cama"> Quantidade de Camas&nbsp;<br/>
			<input type="radio" name="campo" value="nivel"> Nível&nbsp;
			<input type="radio" name="campo" value="status"> Status&nbsp;<br/>
			<input type="radio" name="campo" value="valor"> Valor&nbsp;
			<input type="radio" name="campo" value="descricao"> Descrição
		</p>
		<p><input type="submit" name="botao" value="Buscar"></p>
	</form>

	<?php
	if (isset($_GET['botao'])) {

		require_once 'persistence/QuartoPA.php';
		$quartopa = new QuartoPA();

		if (isset($_GET['campo']) && $_GET['campo'] != "") {
			$consulta = $quartopa->Buscar($_GET['termo'], $_GET['campo']);
		} else {
			$consulta = $quartopa->Buscar($_GET['termo'], "");
		}

		if (!$consulta) {
			echo "<h2>Nenhum resultado correspondente!</h2>";
		} else {

			require_once 'model/Quarto.php';
			$quarto = new Quarto();

			echo "<table>";
			echo "<tr>";
			echo "<th>Número do Quarto</th>";
			echo "<th>Número de Camas</th>";
			echo "<th>Nível</th>";			
			echo "<th>Status</th>";
			echo "<th>Valor</th>";
			echo "<th>Descrição</th>";
			echo "<th>Foto</th>";
			echo "<th>Editar ou Excluir</th>";
			echo "</tr>";

			while ($linha=$consulta->fetch_assoc()) {
				
				$quarto->setNumero($linha['numero']);
				$quarto->setCama($linha['cama']);
				$quarto->setNivel($linha['nivel']);
				$quarto->setStatus($linha['status']);
				$quarto->setValor($linha['valor']);
				$quarto->setDescricao($linha['descricao']);
				$quarto->setFoto($linha['foto']);
				
				echo "<tr>";
				echo "<td>".$quarto->getNumero()."</td>";
				echo "<td>".$quarto->getCama()."</td>";
		//echo "<td>".$quarto->getNivel()."</td>"; //nivel 1=basico, 2=luxo, 3=premium, 4=master
				if ($quarto->getNivel()==1) {
					echo "<td>Básico</td>";
				}
				if ($quarto->getNivel()==2) {
					echo "<td>Luxo</td>";
				}
				if ($quarto->getNivel()==3) {
					echo "<td>Premium</td>";
				}
				if ($quarto->getNivel()==4) {
					echo "<td>Master</td>";
				}
		//echo "<td>".$quarto->getStatus()."</td>"; //status = 0=ocupado, 1=disponivel
				if ($quarto->getStatus()==1) {
					echo "<td>Disponível</td>";
				}
				if ($quarto->getStatus()==0) {
					echo "<td>Ocupado</td>";
				}
				echo "<td>R$&nbsp".$quarto->getValor()."</td>";		
				echo "<td>".$quarto->getDescricao()."</td>";
				echo "<td><img src='data:image/jpg;base64,". 
				base64_encode($quarto->getFoto())."'></td>";
				echo "<td><a href='alterarquarto.php?numero=".$quarto->getNumero()."'><img src='img/edit white.png'></a> &nbsp;
				<a href='excluirquarto.php?numero=".$quarto->getNumero()."'><img src='img/delete white.png'></a></td>";
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

<script src="js/loader.js"></script>
</body>
</html>