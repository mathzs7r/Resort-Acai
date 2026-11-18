<?php
require_once 'cabecalho.php';
require_once 'menu.php';
if(isset($_COOKIE['administrador'])&&isset($_COOKIE['nivel']) && $_COOKIE['nivel'] <= 2){


if (isset($_GET['numero'])) {
require_once 'model/Quarto.php';
require_once 'persistence/QuartoPA.php';

$quarto = new quarto();
$quartopa = new QuartoPA();

    $quarto->setNumero($_GET['numero']);
     $consulta = $quartopa->buscar($quarto->getNumero(),'numero');
      $linha = $consulta->fetch_assoc();
    $quarto->setFoto($linha['foto']);
    $quarto->setDescricao($linha['descricao']);

     ?>

    <form action="excluirquarto.php" method="POST" id="form"><div id="loader" style="display: none;">
        <img src="img/loader.gif">
    </div>
    <h1>Excluir</h1>
    <p>Tem certeza que deseja excluir o quarto
        <big><?= $quarto->getNumero() ?></big></p>
    <input type="hidden" name="numero" value="<?= $quarto->getNumero() ?>">
    <p>
        <input type="submit" name="botao" value="Sim">
        <button class="bnao"><a href="buscarquarto.php?termo=
            <?= $quarto->getNumero() ?>
            &campo=numero&botao=Buscar">
        Não</a></button>
    </p>
</form>
<script src="js/loader.js"></script>
<?php

}else if (isset($_POST['botao'])) {
    require_once 'model/quarto.php';
    require_once 'persistence/quartoPA.php';
    $quarto=new quarto();
    $quartopa=new quartoPA();

    $quarto->setNumero($_POST['numero']);
    if($quartopa->excluir($quarto->getNumero())){
        echo "<h2>Excluído com sucesso! 
        <a href='buscarquarto.php'>Outro?</a></h2>";
    }else{
        echo "<h2>Erro na tentativa de excluir! 
        <a href='buscarquarto.php?termo=".
        $quarto->getNumero()."&campo=numero& 
        botao=Buscar'>Tente Novamente!</a></h2>";
    }
}else{
    echo "<h2>Ops aconteceu um Erro: 404! 
    <a href='index.php'>Voltar</a></h2>";
    
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