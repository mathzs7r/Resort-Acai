<?php require_once 'cabecalho.php';
require_once 'menu.php';
if(isset($_COOKIE['administrador']) && $_COOKIE['nivel'] <= 2){
?>
	<form action="cadastraradmin.php" method="POST"
	id="form">
		<div id="loader" style="display:none;">
			<img src="img/loader.gif">
		</div>
		<h1>Cadastro de Administradores</h1>
		<p>Digite o Nome:</p>
		<p><input type="text" name="nome" pattern="[a-zA-Z\s.çÇáÁãÃéÉêÊíÍõÕóÓúÚ]{1,30}"  placeholder="Digite seu nome" required></p>		
		<p>Login:</p>
		<p>*Somente letras, sem acentos ou caracteres
		especiais no mínimo 3, máx 20</p>
		<p><input type="text" name="login" size="20" maxlength="20"
			pattern="[a-zA-Z]{3,20}" placeholder="Digite seu login" title="Somente letras, sem acentos ou caracteres
		especiais no mínimo 3, máx 20" required></p>
		<p>Senha:</p>	
		<p><small>Letras e números, underline (_), e ponto(.),
		no mínimo 5, máx 10 caracteres</small></p>
		<p><input type="password" name="senha" size="10"
			maxlength="10" pattern="[0-9a-zA-Z_.]{5,10}" placeholder="Digite sua senha" title="Letras e números, underline (_), e ponto(.), no mín. 5 máx. 10 caracteres" required></p>
		<p>Redigite a senha:</p>
		<p><input type="password" name="confirmar" size="10"
			maxlength="10" pattern="[0-9a-zA-Z_.]{5,10}" placeholder="Redigite a senha" title="Letras e números, underline (_), e ponto(.), no mín. 5 máx. 10 caracteres" required></p>
		<p>Nível</p>
		<p><select name="nivel">			
			<option value="2">Gerente</option>
			<option value="3">Funcionários</option>			
		</select></p>

		<p><input type="submit" name="botao" value="Cadastrar">

	</form>
<?php

	if(isset($_POST['botao'])){
		require_once 'model/Administrador.php';
		$administrador=new Administrador();
		$administrador->setNome($_POST['nome']);
		$administrador->setLogin($_POST['login']);
		$administrador->setSenha($_POST['senha']);
		$administrador->setNivel($_POST['nivel']);

	if($administrador->getSenha()==$_POST['confirmar'])

		{require_once 'persistence/AdministradorPA.php';

			$administradorpa=new AdministradorPA();
	if($administradorpa->verificarLogin(
				$administrador->getLogin())){				
				$administrador->criptografarSenha();				
	if ($administradorpa->cadastrar($administrador)) {
					echo "<h2>Administrador cadastrado com sucesso!</h2>";
		}else{
				echo "<h2>Erro na tentativa de cadastrar!
						Por favor tente novamente</h2>";
			}

		}else{
				echo "<h2>Este login já está em uso!
						Por favor tente outra!</h2>";
			}

		}else{

			echo "<h2>A senha e a senha redigitada
						 não conferem!</h2>";
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