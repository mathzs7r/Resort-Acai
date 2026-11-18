<?php
require_once 'cabecalho.php';
require_once 'menu.php';

//primeiro momento
if(isset($_COOKIE['administrador']) && $_COOKIE['nivel'] <= 2){

    if (isset($_GET['cod_adm'])) {
        require_once 'model/Administrador.php';
        require_once 'persistence/AdministradorPA.php';

        $administrador = new Administrador();
        $administradorpa = new AdministradorPA();

        $administrador->setCodAdm($_GET['cod_adm']);
        $codadm=$_GET['cod_adm'];
        $consulta = $administradorpa->buscar($administrador->getCodAdm(),'cod_adm');
        $linha = $consulta->fetch_assoc();
        $administrador->setCodAdm($linha['cod_adm']);
        $administrador->setNome($linha['nome']);
        $administrador->setNivel($linha['nivel']);

        ?>
        <form action="excluiradm.php" method="POST" id="form">
            <div id="loader" style="display: none"><img src="img/loader.gif"></div>
            <h1>Excluir</h1>
            <p><input type="hidden" name="cod_adm" value="<?= $administrador->getCodAdm() ?>" >

                <?php
        if ($administrador->getNivel()==1) { //se o adm é nivel 1, não é permitido excluir
            echo "<section='paginacao'><h2>Não é possível excluir este cadastro!</h2>";
            echo "<button class='bnao'><a href='listaradmin.php'>Voltar</a></button></p>";
        }else{
            echo "<p>Tem certeza que deseja excluir o <big>" . $administrador->getNome() . "</big></p>";
            echo "<input type='hidden' name='cod_adm' value=" . $administrador->getCodAdm() . ">";
            echo "<p><input type='submit' name='botao' value='Sim'>";
            echo "<button class='bnao'><a href='listaradmin.php'>Não</a></button></p>";
        }
        ?>
    </form>
    <script src="js/loader.js"></script>

    <?php
//segundo momento
}else if (isset($_POST['botao'])){
    require_once 'model/Administrador.php';
    require_once 'persistence/AdministradorPA.php';
    $administrador=new Administrador();
    $administradorpa=new AdministradorPA();

    $administrador->setCodAdm($_POST['cod_adm']);
    if($administradorpa->excluir($administrador->getCodAdm())){
        echo"<h2> Excluido com sucesso!
        <a href='listaradmin.php'>Voltar</a></h2>";

    }else{

        echo"<h2>Erro na tentativa de excluir!
        <a href='listaradmin.php>Voltar</a></h2>";
    }
}

}else{

    header('location:index.php');

}
require_once 'footer.php';
?>

</body>
</html>