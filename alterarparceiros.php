<?php 

require_once 'cabecalho.php';
require_once 'menu.php';
if(isset($_COOKIE['administrador']) && $_COOKIE['nivel'] <= 2){

if (isset($_GET['cnpj'])) {
    require_once 'model/parceiros.php';
    require_once 'persistence/ParceirosPA.php';
    
    $parceiros = new Parceiros();
    $parceirospa = new ParceirosPA();
    
    $consulta = $parceirospa->buscar($_GET['cnpj'], 'cnpj');
    $linha = $consulta->fetch_assoc();
    
    $parceiros->setCnpj($linha['cnpj']);
    $parceiros->setNome($linha['nome']);
    $parceiros->setLogo($linha['logo']);
    $parceiros->setTelefone($linha['telefone']);
    $parceiros->setDescricao($linha['descricao']);
    $parceiros->setCodAdm($_COOKIE['administrador']);
    
?>

<form action="alterarparceiros.php" method="POST" id="form">
    <div id="loader" style="display: none;">
        <img src="img/loader.gif">
    </div>
    <h1>Alterar Parceiro:</h1>
    <input type="hidden" name="cnpj" value="<?= $parceiros->getCnpj() ?>">
    <p>Digite o nome:</p>
    <input type="text" name="nome" size="30" maxlength="50" pattern="[0-9a-zA-Z\s-çÇãÃéÉúÚóÓêÊ]{2,30}"
    value="<?= $parceiros->getNome()?>" required></p>    
        <p>Logo atual:</p>
        <img src="data:image/jpg;base64,<?= base64_encode($parceiros->getLogo())?>">
        <p>outra  imagem?</p>
    <p><input type="file" name="logo" accept=".jpg,.jpeg,.gif,.bmp,.png"></p>
    <p>Telefone:</p>
    <p><input type="text" name="telefone" size="14" maxlength="14" pattern="\([0-9]{2}\)[0-9]{4,5}-[0-9]{4}"
        id="telefone" value="<?= $parceiros->getTelefone()?>" required></p>
    <p>Descrição:</p>
    <p><textarea cols="60" rows="4" maxlength="240" 
     name="descricao" required><?= $parceiros->getDescricao()?></textarea></p>

    <p><input type="submit" name="botao" value="Alterar"></p>
    <button class='bnao'><a href="buscarparceiro.php?termo=<?= $parceiros->getCnpj() ?>&campo=cnpj&botao=Buscar">Cancelar</a></button></p>
</form>
<script src="js/loader.js"></script>
<?php 

}else if(isset($_POST['botao'])){
    require_once 'model/Parceiros.php';
    require_once 'persistence/ParceirosPA.php';
    $parceiros=new Parceiros();
    $parceirospa=new ParceirosPA();

    if (isset($_FILES['logo'])&&$_FILES['logo']['tmp_name']!="") {
        $parceiros->setLogo($_FILES['logo']['tmp_name']);
        if ($parceiros->verificarTamanho($parceiros->getLogo())) {
            $parceiros->criarImagem();
            $flag=true;
        }else{
            echo "<h2>Imagem muito grande! Máx. 65Kb!</h2>";
            $flag=false;
        }
    }else{
        $parceiros->setLogo(addslashes(
            $parceirospa->retornarImagem($_POST['cnpj'])));
        $flag=true;
    }
    if ($flag) {
        $parceiros->setCnpj($_POST['cnpj']);
        $parceiros->setNome($_POST['nome']);
        $parceiros->setLogo($_POST['logo']);
        $parceiros->setTelefone($_POST['telefone']);
        $parceiros->setDescricao($_POST['descricao']);
        $parceiros->setCodAdm($_COOKIE['administrador']);

        if($parceirospa->alterar($parceiros)){
            echo "<h2>Parceiro alterado com sucesso!</h2>";
        }else{
            echo "<h2>Erro na tentativa de alterar! Tente 
            <a href='buscarpro.php?termo=".$parceiros->getCnpj().
            "&campo=cnpj&botao=Buscar'>novamente</a>!</h2>";
        }
    }

}

}else{
header('location: login.php');
}
require_once 'footer.php';
?>
</body>
</html>