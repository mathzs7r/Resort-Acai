<?php
require_once 'cabecalho.php';
require_once 'menu.php';
if(isset($_COOKIE['administrador'])){

    if (isset($_GET['cpf'])) {
require_once 'model/Hospede.php';
require_once 'persistence/HospedePA.php';

$hospede = new Hospede();
$hospedepa = new HospedePA();


    $hospede->setCpf($_GET['cpf']);
    $cpf=$_GET['cpf'];
    $consulta = $hospedepa->buscar($hospede->getCpf(),'cpf');
    $linha = $consulta->fetch_assoc();
    $hospede->setNome($linha['nome']);

    ?>

    <form action="excluirhospede.php" method="POST" id="form">
        <div id="loader" style="display: none;">
        <img src="img/loader.gif">
        </div>

        <h1>Excluir</h1>

        <p>Tem certeza que deseja excluir o hóspede
            <big><?= $hospede->getNome() ?></big> ?</p>

        <p><input type="hidden" name="cpf" value="<?= $hospede->getCpf() ?>" >

        <input type="submit" name="botao" value="Sim">
        
        <button class='bnao'><a href="buscarhospede.php?termo=<?= $hospede->getCpf() ?>&campo=cpf&botao=Buscar">Não</a></button></p>



    </form>
    <script src="js/loader.js"></script>
    <?php

}else if (isset($_POST['botao'])) {
    require_once 'model/Hospede.php';
    require_once 'persistence/HospedePA.php';
    $hospede=new Hospede();
    $hospedepa=new HospedePA();

    $hospede->setCpf($_POST['cpf']);
    if($hospedepa->excluir($hospede->getCpf())){
        echo "<h2>Excluído com sucesso! 
        <a href='buscarquarto.php'>Outro?</a></h2>";
    }else{
        echo "<h2>Erro na tentativa de excluir! 
        <a href='buscarquarto.php?termo=".
        $hospede->getCpf()."&campo=cpf& 
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