<?php require_once 'cabecalho.php';
require_once 'menu.php';
require_once 'persistence/ReservaPA.php';

if (isset($_COOKIE['administrador'])) {

echo "<div id='conteudo'>";
$reservapa=new ReservaPA();
$total=$reservapa->contar();
if ($total <= 0){
	echo "<section><h2>Não há reservas cadastradas!</h2></section>";
}else{
	if (isset($_GET['pagina'])) {
		$pagina=$_GET['pagina'];
	}else{
		$pagina=1;
	}
	$limite=20;
	$offset=($pagina-1)*$limite;
	$consulta=$reservapa->listar($limite,$offset);
	require_once 'model/Reserva.php';
	require_once 'persistence/ReservaPA.php';
	require_once 'model/Hospede.php';
	require_once 'persistence/HospedePA.php';
	$reserva=new Reserva();
	$reservapa=new ReservaPA();		
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
		echo "<td><a href='alterarreserva.php?cod_res=".$reserva->getCodRes()."'><img src='img/edit white.png'></a> &nbsp;
		<a href='excluirreserva.php?cod_res=".$reserva->getCodRes()."'><img src='img/delete white.png'></a></td>";
		echo "</tr>";
	}
	echo "</table>";

	echo "<section class='paginacao'>";
	if($pagina>1){
		$voltar=$pagina-1;
		echo "<a href='listarreserva.php?pagina=$voltar' class='botao_pag'> 
		&lt;&lt;</a>";
	}
	echo "<span class='numero'> $pagina </span>";
	$total_pag=ceil($total/$limite);
	if($pagina<$total_pag){
		$proxima=$pagina+1;
		echo "<a href='listarreserva.php?pagina=$proxima' class='botao_pag'>
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