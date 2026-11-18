<?php require_once 'cabecalho.php';
require_once 'menu.php';
if(isset($_COOKIE['administrador']) && $_COOKIE['nivel'] <= 2){

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

		echo "<table>";
		echo "<tr>";
		echo "<th>CNPJ</th>";
		echo "<th>Nome</th>";
		echo "<th>Telefone</th>";
		echo "<th>Descrição</th>";
		echo "<th>Administrador</th>";
		echo "<th>Logo</th>";
		echo "<th>Editar ou Excluir</th>";
		echo "</tr>";

		while ($linha=$consulta->fetch_assoc()) {
			$parceiro->setCnpj($linha['cnpj']);
			$parceiro->setNome($linha['nome']);			
			$parceiro->setTelefone($linha['telefone']);
			$parceiro->setDescricao($linha['descricao']);
			$parceiro->setCodAdm($linha['cod_adm']);
			$parceiro->setLogo($linha['logo']);

			echo "<tr>";
			echo "<td>".$parceiro->getCnpj()."</td>";
			echo "<td>".$parceiro->getNome()."</td>";
			echo "<td>".$parceiro->getTelefone()."</td>";
			echo "<td>".$parceiro->getDescricao()."</td>";
			echo "<td>".$parceiro->getCodAdm()."</td>";
			echo "<td><img src='data:image/jpg;base64,". 
			base64_encode($parceiro->getLogo())."'></td>";
			echo "<td><a href='alterarparceiros.php?cnpj=".$parceiro->getCnpj()."'><img src='img/edit white.png'></a> &nbsp;
			<a href='excluirparceiros.php?cnpj=".$parceiro->getCnpj()."'><img src='img/delete white.png'></a></td>";
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
}else{
	header('location: login.php');
}
require_once 'footer.php';
?>
</body>
</html>

