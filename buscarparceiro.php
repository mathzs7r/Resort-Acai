<?php
require_once 'cabecalho.php';
require_once 'menu.php';
if(isset($_COOKIE['administrador']) && $_COOKIE['nivel'] <= 2){
echo "<div id='conteudo'>";
	?>
	
	<form action="buscarparceiro.php" method="GET" id="form">
		<div id="loader" style="display:none;" ><img src="img/loader.gif"></div>
		<h1>Buscar Parceiros</h1>
		<p>Termo</p>
		<p><input type="search" name="termo" size="40" maxlength="70" pattern="[0-9a-zA-Z\s,-çÇáÁãÃéÉúÚóÓõÕêÊíÍ\)\(]{1,70}" title="Busque somente por Nome, CNPJ, Telefone ou Descrição" placeholder="Buscar termo" required></p>
		<p>Categoria</p>	
		<p><input type="radio" name="campo" value="cnpj">CNPJ&nbsp;
			<input type="radio" name="campo" value="nome">Nome&nbsp;<br/>	
			<input type="radio" name="campo" value="telefone">Telefone&nbsp;
			<input type="radio" name="campo" value="descricao">Descrição
		</p>
		<p><input type="submit" name="botao" value="Buscar"></p>	
	</form>	
	<?php
	
	if (isset($_GET['botao'])){
		
			require_once 'persistence/ParceirosPA.php';
			$parceirospa=new ParceirosPA();
			if(isset($_GET['campo'])&&$_GET['campo']!=""){
				$consulta=$parceirospa->buscar($_GET['termo'],$_GET['campo']);
			}else{
				$consulta=$parceirospa->buscar($_GET['termo'],'');
			}
			if(!$consulta){
				echo "<h2>Nenhum resultado correspondente!</h2>";
			}else{
				require_once'model/Parceiros.php';
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
			}
	}

}else{
	header('location: login.php');
}
echo "</div>";
require_once 'footer.php';
?>
<script src="js/loader.js"></script>
</body>
</html>
