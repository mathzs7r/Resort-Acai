<?php require_once 'cabecalho.php';
require_once 'menu.php';
if(isset($_COOKIE['administrador'])){
?>
<form action="cadastrarhosp.php" method="POST"
id="form">
<div id="loader" style="display:none;">
	<img src="img/loader.gif">
</div>
<h1>Cadastrar Hóspede</h1>
<p>CPF</p>
<p><input type="text" name="cpf" maxlength="14" title="Digite no formato XXX.XXX.XXX-XX" pattern="[0-9\.-]{14}" id="cpf" placeholder="XXX.XXX.XXX-XX" required></p>
<p>Digite o nome:</p>
<p><input type="text" name="nome"
	size="30" maxlength="30"
	pattern="[0-9a-zA-Z\s-çÇãÃéÉúÚóÓêÊ]{2,30}"
	required placeholder="Digite o nome do hóspede"></p>
	<p>Telefone:</p>
	<p><input type="text" name="telefone"
		size="14" maxlength="14"
		pattern="\([0-9]{2}\)[0-9]{4,5}-[0-9]{4}"
		id="telefone" title="Digite no formato (XX)XXXXX-XXXX" placeholder="(XX)XXXXX-XXXX" required></p>
		<p>Cidade:</p>
		<p><input type="text" name="cidade"
			size="30" maxlength="30"
			pattern="[a-zA-Z\s-çÇãÃéÉúÚóÓêÊ]{3,30}" placeholder="Digite a cidade" title="Somente letras acentos e espaço mín. 3 máx. 30" 
			required></p>
			<p>Endereço</p>
			<p><input type="text" name="endereco"
				size="70" maxlength="70"
				pattern="[0-9a-zA-Z\s,-çÇãÃéÉúÚóÓêÊ]{3,70}"  placeholder="Digite o endereço" title="Somente letras acentos e espaço mín. 3 máx. 70"
				required></p>
			<p><input type="submit" name="botao"
						value="Cadastrar"></p>
			</form>
					<?php
					if (isset($_POST['botao'])) {
						require_once 'model/Hospede.php';
						require_once 'persistence/HospedePA.php';
						$hospede=new Hospede();
						$hospedepa=new HospedePA();
						$hospede->setCpf($_POST['cpf']);
						$hospede->setNome($_POST['nome']);
						$hospede->setEndereco($_POST['endereco']);
						$hospede->setTelefone($_POST['telefone']);
						$hospede->setCidade($_POST['cidade']);
						if($hospedepa->cadastrar($hospede)){
							echo "<h2>Hospede cadastrado com sucesso!</h2>";
						}else{
							echo "<h2>Erro na tentativa de cadastrar! 
							Tente novamente!</h2>";
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