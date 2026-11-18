<?php require_once 'cabecalho.php';
require_once 'menu.php';
if(isset($_COOKIE['administrador'])&&isset($_COOKIE['nivel']) && $_COOKIE['nivel'] <= 2){
echo "<div id='conteudo'>";
require_once 'persistence/QuartoPA.php';
$quartopa=new QuartoPA();
$total=$quartopa->contar();
if ($total <= 0){
	echo "<section><h2>Não há quartos cadastrados!
	Cadastre-os primeiro!</h2></section>";
	}else{
      if (isset($_GET['pagina'])) {
		$pagina=$_GET['pagina'];
	}else{
		$pagina=1;
	}

	$limite=20;
	$offset=($pagina-1)*$limite;
	$consulta=$quartopa->listar($limite,$offset);
	require_once 'model/Quarto.php';
	$quarto=new Quarto();

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

	echo "<section class='paginacao'>";
	if($pagina>1){
		$voltar=$pagina-1;
		echo "<a href='listarquarto.php?pagina=$voltar' class='botao_pag'> 
		&lt;&lt;</a>";
	}
	echo "<span class='numero'> $pagina </span>";
	$total_pag=ceil($total/$limite);
	if($pagina<$total_pag){
		$proxima=$pagina+1;
		echo "<a href='listarquarto.php?pagina=$proxima' class='botao_pag'>
		&gt;&gt;</a>";
	}
	echo "</section>";
}
?>
<?php
                }else{
                    header('location: login.php');
                }
echo "</div>";
require_once 'footer.php';
                ?>
</body>
</html>