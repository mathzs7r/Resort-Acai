<?php 
require_once 'cabecalho.php';
require_once 'menu.php';
if(isset($_COOKIE['administrador']) && $_COOKIE['nivel'] <= 2){

    if (isset($_GET['cod_adm'])) {
        require_once 'model/Administrador.php';
        require_once 'persistence/AdministradorPA.php';

        $administrador = new Administrador();
        $administradorpa = new AdministradorPA();

        $consulta = $administradorpa->buscar($_GET['cod_adm'], 'cod_adm');
        $linha = $consulta->fetch_assoc();

    // Mapeamento dos campos do banco para o objeto
        $administrador->setCodAdm($linha['cod_adm']);
        $administrador->setNome($linha['nome']);
        $administrador->setLogin($linha['login']);
        $administrador->setSenha($linha['senha']);
        $administrador->setNivel($linha['nivel']);
        ?>

        <form action="alteraradm.php" method="POST" id="form">
            <div id="loader" style="display: none;"><img src="img/loader.gif"></div>
            <h1>Alterar Administrador</h1>
            <input type="hidden" name="cod_adm" value="<?=$administrador->getCodAdm()?>">
            <p>Digite o nome:</p>
            <p><input type="text" name="nome" size="10" maxlength="30" pattern="[a-zA-Z\s.çÇáÁãÃéÉêÊíÍõÕóÓúÚ]{1,30}" title="letras e numeros,_,@ e hífen. min.5 max.10" value="<?= $administrador->getNome()?>" required></p>
            <p>Digite o Login:</p>
            <p><input type="text" name="login" size="10" maxlength="10" pattern="[a-zA-Z]{3,20}" title="letras e numeros,_,@ e hífen. min.5 max.10" value="<?= $administrador->getLogin()?>" required></p>
            <input type="hidden" name="velho_login" value="<?= $administrador->getLogin()?>">
            <?php

            if($administrador->getCodAdm()!=1){ //não é possivel alterar o nivel do adm mestre

                echo "<p>Nível</p>";
                echo "<p><select name='nivel'>";        
                 echo "<option value='2'>Gerente</option>";
                 echo "<option value='3'>Funcionários</option>";       
                 echo "</select></p>";
            }
            ?>

            <p>Digite a nova senha:</p>
            <p><input type="password" name="senha" size="10" maxlength="10" pattern="[0-9a-zA-Z_.]{5,10}" placeholder="Digite sua senha" title="letras e numeros,_,@ e hífen. min.5 max.10" required></p>
            <p>Confirme a senha:</p>
            <p><input type="password" name="confirmar" size="10" maxlength="10" pattern="[0-9a-zA-Z_.]{5,10}" placeholder="Digite sua senha" title="letras e numeros,_,@ e hífen. min.5 max.10" required></p>
            <!-- Botões Alterar e Cancelar atualizados -->
            <p><input type="submit" name="botao" value="alterar">
                <button type="button" class="bnao" onclick="window.location.href='listaradmin.php';">Cancelar</button>
            </p>
        </form>
        <?php
    }else if (isset($_POST['botao'])) {
        require_once 'model/Administrador.php';
        require_once 'persistence/AdministradorPA.php';

        $administrador = new administrador();
        $administradorpa = new administradorPA();

        $administrador->setCodAdm($_POST['cod_adm']);
        $administrador->setNome($_POST['nome']);
        $administrador->setLogin($_POST['login']);
        $administrador->setSenha($_POST['senha']);
        $administrador->setNivel($_POST['nivel']);

        if($administrador->getLogin()!=$_POST['velho_login']) {
            if($administradorpa->verificarLogin($administrador->getLogin())) {
                $continua=true;
            }else{
                echo "<h2>Esse login já existe!</h2>";
                $continua=false;
            }
        }else{
            $continua=true;
        }
        
        if($continua){
            $administrador->criptografarSenha();
            if ($administradorpa->alterar($administrador)) {
                echo "<h2>Administrador alterado com sucesso! 
                <a href='buscaradmin.php'>Voltar para a busca</a>?</h2>";
            }else{
                echo "<h2>Erro na tentativa de alterar administrador! 
                Tente <a href='buscaradmin.php?termo=".$administrador->getCodAdm()."&campo=cpf&botao=Buscar'> novamente</a></h2>";
            }
        }
    }else{
        echo "<h2>Ops! Administrador não encontrado! <a href='index.php'>Volte para o início</a></h2>";
    }
    
}else{
    header('location: login.php');
}

require_once 'footer.php';
?>
</body>
</html>