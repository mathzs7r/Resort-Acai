,adm2<?php 
require_once 'cabecalho.php';
require_once 'menu.php';
if(isset($_COOKIE['administrador']) && $_COOKIE['nivel'] <= 2){

require_once 'persistence/AdministradorPA.php';
$administradorpa = new AdministradorPA();

$total = $administradorpa->contarFuncionarios();

if ($total <= 0) {
	echo "<section><h2>Não há funcionários cadastrados!</h2></section>";
} else {

	if (isset($_GET['pagina'])) {
		$pagina = (int)$_GET['pagina'];
	} else {
		$pagina = 1;
	}

	$limite = 5;
	$offset = ($pagina - 1) * $limite;

	$consulta = $administradorpa->listarFuncionarios($limite, $offset);

	require_once 'model/Administrador.php';
	$administrador = new Administrador();

	echo "<table>";
	echo "<tr>";
	echo "<th>Código</th>";
	echo "<th>Nome</th>";
	echo "<th>Login</th>";
	echo "<th>Nível</th>";
	echo "</tr>";

	while ($linha = $consulta->fetch_assoc()) {
		$administrador->setCodAdm($linha['cod_adm']);
		$administrador->setNome($linha['nome']);
		$administrador->setLogin($linha['login']);
		$administrador->setNivel($linha['nivel']);

		echo "<tr>";
		echo "<td>".$administrador->getCodAdm()."</td>";
		echo "<td>".$administrador->getNome()."</td>";
		echo "<td>".$administrador->getLogin()."</td>";
		echo "<td>".$administrador->getNivel()."</td>";
		echo "</tr>";
	}

	echo "</table>";

	echo "<section class='paginacao'>";

	
	if ($pagina > 1) {
		$voltar = $pagina - 1;
		echo "<a href='listaradmin2.php?pagina=$voltar'>&lt;&lt;</a>";
	}

	echo " <span>$pagina</span> ";

	$total_pag = ceil($total / $limite);

	if ($pagina < $total_pag) {
		$proxima = $pagina + 1;
		echo "<a href='listaradmin2.php?pagina=$proxima'>&gt;&gt;</a>";
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
