<?php require_once 'cabecalho.php';
require_once 'menu.php';
if(isset($_COOKIE['administrador'])){
echo "<div id='conteudo'>";
	require_once 'persistence/HospedePA.php';
	$hospedepa=new HospedePA();
	$total=$hospedepa->contar();
	if ($total <= 0){
		echo "<h2>Não há hospedes cadastrados!
		Cadastre-os primeiro!</h2>";
	}else{
		if (isset($_GET['pagina'])) {
			$pagina=$_GET['pagina'];
		}else{
			$pagina=1;
		}

		$limite=20;
		$offset=($pagina-1)*$limite;
		$consulta=$hospedepa->listar($limite,$offset);
		require_once 'model/Hospede.php';
		$hospede=new Hospede();

		echo "<table>";
		echo "<tr>";
		echo "<th>CPF</th>";
		echo "<th>Nome</th>";
		echo "<th>Telefone</th>";
		echo "<th>Cidade</th>";
		echo "<th>Endereço</th>";
		echo "<th>Editar ou Excluir</th>";
		echo "</tr>";

		while($linha=$consulta->fetch_assoc()) {
			$hospede->setCpf($linha['cpf']);
			$hospede->setNome($linha['nome']);
			$hospede->setTelefone($linha['telefone']);
			$hospede->setCidade($linha['cidade']);
			$hospede->setEndereco($linha['endereco']);


			echo "<tr>";
			echo "<td>".$hospede->getCpf()."</td>";
			echo "<td>".$hospede->getNome()."</td>";
			echo "<td>".$hospede->getTelefone()."</td>";		
			echo "<td>".$hospede->getCidade()."</td>";
			echo "<td>".$hospede->getEndereco()."</td>";
			echo "<td><a href='alterarhospede.php?cpf=".$hospede->getCpf()."'><img src='img/edit white.png'></a> &nbsp;
			<a href='excluirhospede.php?cpf=".$hospede->getCpf()."'><img src='img/delete white.png'></a></td>";
			echo "</tr>";
			
		}
		echo "</table>";

		echo "<section class='paginacao'>";
		if($pagina>1){
			$voltar=$pagina-1;
			echo "<a href='listarhospede.php?pagina=$voltar' class='botao_pag'> 
			&lt;&lt;</a>";
		}
		echo "<span class='numero'> $pagina </span>";
		$total_pag=ceil($total/$limite);
		if($pagina<$total_pag){
			$proxima=$pagina+1;
			echo "<a href='listarhospede.php?pagina=$proxima' class='botao_pag'>
			&gt;&gt;</a>";
		}
		echo "</section>";
	}

}else{
	header('location: login.php');
}
echo "</div>";
require_once 'footer.php';
?>
</body>
</html>
