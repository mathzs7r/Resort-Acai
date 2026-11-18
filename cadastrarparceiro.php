<?php require_once 'cabecalho.php';
require_once 'menu.php';
if(isset($_COOKIE['administrador']) && $_COOKIE['nivel'] <= 2){
?>
<form action="cadastrarparceiro.php"  enctype="multipart/form-data" method="POST" id="form">
	<div id="loader" style="display:none;">
		<img src="img/loader.gif">
	</div>
	<h1>Cadastro de Parceiros</h1>
	<p>Digite o nome:</p>
	<p><input type="text" name="nome" placeholder="Digite o nome da Empresa" 
		size="30" maxlength="50"
		pattern="[0-9a-zA-Z\s-çÇãÃéÉúÚóÓêÊ]{2,30}"
		required></p>
	<p>CNPJ</p>
	<p><input type="text" name="cnpj" title="Digite no formato XX.XXX.XXX/XXXX-XX" placeholder="XX.XXX.XXX/XXXX-XX" 
		size="18" maxlength="18"
		pattern="[0-9]{2}\.[0-9]{3}\.[0-9]{3}\/[0-9]{4}-[0-9]{2}"
		id="cnpj" required></p>
		<p>Logo:</p>
	<p><input type="file" name="logo"
		accept=".jpg,.jpeg,.gif,.bmp,.png" required></p>
	<p>Telefone:</p>
	<p><input type="text" name="telefone" title="Digite no formato (XX)XXXXX-XXXX" placeholder="(XX)XXXXX-XXXX" 
		size="14" maxlength="14"
		pattern="\([0-9]{2}\)[0-9]{4,5}-[0-9]{4}"
		id="telefone" required></p>
	<p>Descrição:</p>
	<p><textarea cols="60" rows="4" maxlength="240" placeholder="Descrição da Empresa" 
	 name="descricao" required></textarea></p>
	<p><input type="submit" name="botao"
		value="Cadastrar"></p>
</form>
<?php
	if (isset($_POST['botao'])) {
		require_once 'model/Parceiros.php';
		require_once 'persistence/ParceirosPA.php';
		$parceiros=new Parceiros();
		$parceirospa=new ParceirosPA();
		//var_dump($_FILES['logo'])
		$parceiros->setLogo($_FILES['logo']['tmp_name']);
		if (!$parceiros->verificarTamanho($parceiros->getLogo())) {
			echo "<h2>A logo é muito grande! Máx. 65kb </h2>";
		}else{
			$parceiros->criarImagem();
			$parceiros->setCnpj($_POST['cnpj']);
			$parceiros->setNome($_POST['nome']);
			$parceiros->setTelefone($_POST['telefone']);
			$parceiros->setDescricao($_POST['descricao']);
			$parceiros->setCodAdm($_COOKIE['administrador']);


			if($parceirospa->verificarCnpj($parceiros->getCnpj())){				
				if ($parceirospa->cadastrar($parceiros)){
					echo "<h2>Parceiro cadastrado com sucesso!</h2>";
				}else{
					echo "<h2>Erro na tentativa de cadastrar parceiro! 
					Tente novamente!</h2>";
				}
			}else{
				echo "<h2>Esse CNPJ já está cadastrado,
				        Tente novamente!</h2>";
			}

			
		}
}	
?>
<script src="js/loader.js"></script>
<?php
				}else{
					header('location: login.php');
				}
require_once 'footer.php';
				?>
</body>
</html>
