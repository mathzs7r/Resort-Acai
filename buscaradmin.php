<?php
require_once'cabecalho.php';
require_once 'menu.php';
if(isset($_COOKIE['administrador']) && $_COOKIE['nivel'] <= 2){

?>

<form action="buscaradmin.php" method="GET" id="form">
	<div id="loader" style="display:none;"><img src="img/loader.gif"></div>
	<h1>Buscar Administradores</h1>
	<p>Termo:</p>
	<p><input type="search" name="termo" size="40" maxlength="70" pattern="[0-9a-zA-Z/s-çÇãÃéÉúÚóÓêÊíÍ\(\)]{1,70}" title="Busque somente por Nome, Nível, Login ou Código" placeholder="Buscar termo" required></p>
	<p><br></p>
		<p>Categoria:</p>
		<p>
			<input type="radio" name="campo" value="nome"> Nome&nbsp;
			<input type="radio" name="campo" value="nivel"> Nível&nbsp;<br/>
			<input type="radio" name="campo" value="login"> Login&nbsp;
			<input type="radio" name="campo" value="cod_adm"> Código&nbsp;
		</p>
	<p><input type="submit" name="botao" value="Buscar"></p>
</form>

<?php
if (isset($_GET['botao'])) {

	require_once 'persistence/Administradorpa.php';
	$administradorpa = new AdministradorPA();

	if (isset($_GET['campo']) && $_GET['campo'] != "") {
		$consulta = $administradorpa->buscar($_GET['termo'], $_GET['campo']);
	} else {
		$consulta = $administradorpa->buscar($_GET['termo'], "");
	}

	if (!$consulta) {
		echo "<h2>Nenhum resultado correspondente!</h2>";
	} else {

		require_once 'model/Administrador.php';
		$administrador = new Administrador();

		echo "<table>";
		echo "<tr>";
		echo "<th>Código</th>";
		echo "<th>Nome</th>";
		echo "<th>Login</th>";
		echo "<th>Nivel</th>";
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