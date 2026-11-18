<?php require_once 'cabecalho.php';
require_once 'menu.php';

echo "<div id='conteudo'>";
	require_once 'persistence/ParceirosPA.php';
	$parceirospa=new ParceirosPA();
	$total=$parceirospa->contar();
	if ($total<=0) {
		echo "<h2>Não há parceiros cadastrados!
		Cadastre-os primeiro!</h2>";
	}else{
		if (isset($_GET['pagina'])) {
			$pagina=$_GET['pagina'];
		}else{
			$pagina=1;
		}

		$limite=20;
		$offset=($pagina-1)*$limite;
		$consulta=$parceirospa->listar($limite,$offset);
		require_once 'model/Parceiros.php';
		$parceiro=new Parceiros();


		echo "<section class='home'><h1>Conheça nossos parceiros!</h2>";
		echo "<table>";
		echo "<tr>";
		echo "<th>Nome</th>";
		echo "<th>Telefone</th>";
		echo "<th>Descrição</th>";
		echo "<th>Logo</th>";
		echo "</tr>";

		while ($linha=$consulta->fetch_assoc()) {
			$parceiro->setNome($linha['nome']);			
			$parceiro->setTelefone($linha['telefone']);
			$parceiro->setDescricao($linha['descricao']);
			$parceiro->setLogo($linha['logo']);

			echo "<tr>";
			echo "<td>".$parceiro->getNome()."</td>";
			echo "<td>".$parceiro->getTelefone()."</td>";
			echo "<td>".$parceiro->getDescricao()."</td>";
			echo "<td><img src='data:image/jpg;base64,". 
			base64_encode($parceiro->getLogo())."'></td>";
			echo "</tr>";
		}	
		echo "</table>";

		echo "<section class='paginacao'>";
		if($pagina>1){
			$voltar=$pagina-1;
			echo "<a href='listarparceiro.php?pagina=$voltar' class='botao_pag'> 
			&lt;&lt;</a>";
		}
		echo "<span class='numero'> $pagina </span>";
		$total_pag=ceil($total/$limite);
		if($pagina<$total_pag){
			$proxima=$pagina+1;
			echo "<a href='listarparceiro.php?pagina=$proxima' class='botao_pag'>
			&gt;&gt;</a>";
		}
		echo "</section>";
	}
	?>
	<?php

echo "</div>";
require_once 'footer.php';
?>
</body>
</html>

