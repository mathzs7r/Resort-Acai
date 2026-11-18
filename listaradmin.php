<?php 
require_once 'cabecalho.php';
require_once 'menu.php';
if(isset($_COOKIE['administrador']) && $_COOKIE['nivel'] <= 2){

echo "<div id='conteudo'>";
require_once 'persistence/AdministradorPA.php';
$administradorpa = new AdministradorPA();

$total = $administradorpa->contar();

if ($total <= 0) {

	echo "<section><h2>Não há administradores cadastrados!</h2></section>";

}else{

	if (isset($_GET['pagina'])) {
		$pagina = $_GET['pagina'];
	}else{
		$pagina = 1;
	}

	$limite = 10;
	$offset = ($pagina - 1) * $limite;

	$consulta = $administradorpa->listar($limite, $offset);

	require_once 'model/Administrador.php';
	$administrador = new Administrador();

	echo "<table>";
		echo "<tr>";
		echo "<th>Código</th>";
		echo "<th>Nome</th>";
		echo "<th>Login</th>";
		echo "<th>Nível</th>";
		echo "<th>Alterar ou Excluir</th>";
		echo "</tr>";

		while ($linha = $consulta->fetch_assoc()) {

			$administrador->setCodAdm($linha['cod_adm']);
			$administrador->setNome($linha['nome']);
			$administrador->setLogin($linha['login']);
			$administrador->setNivel($linha['nivel']);
			
			echo "<tr>";
			echo "<td>" .$administrador->getCodAdm(). "</td>";
			echo "<td>" .$administrador->getNome(). "</td>";
			echo "<td>" .$administrador->getLogin(). "</td>";

			//echo "<td>" . $administrador->getNivel() . "</td>";
			if ($administrador->getNivel()==1) {
			echo "<td>Administrador Mestre</td>";
			}
			if ($administrador->getNivel()==2) {
			echo "<td>Gerente</td>";
			}
			if ($administrador->getNivel()==3) {
			echo "<td>Funcionário</td>";
			}
			if(isset($_COOKIE['nivel'])&&$_COOKIE['nivel']==1){
			echo "<td><a href='alteraradm.php?cod_adm=".$administrador->getCodAdm()."'><img src='img/edit white.png'></a> &nbsp;
		<a href='excluiradm.php?cod_adm=".$administrador->getCodAdm()."'><img src='img/delete white.png'></a></td>";
			}else if(isset($_COOKIE['nivel'])&&$_COOKIE['nivel']==2&&$administrador->getNivel()==3){
			echo "<td><a href='alteraradm.php?cod_adm=".$administrador->getCodAdm()."'><img src='img/edit white.png'></a> &nbsp;
		<a href='excluiradm.php?cod_adm=".$administrador->getCodAdm()."'><img src='img/delete white.png'></a></td>";
			}else{
				echo "<td>--Não Autorizado--</td>";
			}
			

			echo "</tr>";
		}
		echo "</table>";

	
	echo "<section class='paginacao'>";

	if ($pagina > 1) {
		$voltar = $pagina - 1;
		echo "<a href='listaradmin.php?pagina=$voltar'>&lt;&lt;</a>";
	}

	echo " <span>$pagina</span> ";

	$total_pag = ceil($total / $limite);

	if ($pagina < $total_pag) {
		$proxima = $pagina + 1;
		echo "<a href='listaradmin.php?pagina=$proxima'>&gt;&gt;</a>";
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