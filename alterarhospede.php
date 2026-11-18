<?php 
require_once 'cabecalho.php';
require_once 'menu.php';
if (isset($_COOKIE['administrador'])) {


    if (isset($_GET['cpf'])) {
        require_once 'model/hospede.php';
        require_once 'persistence/HospedePA.php';
        
        $hospede = new Hospede();
        $hospedepa = new HospedePA();
        
        $consulta = $hospedepa->buscar($_GET['cpf'], 'cpf');
        $linha = $consulta->fetch_assoc();
        
    // Mapeamento dos campos do banco para o objeto
        $hospede->setCpf($linha['cpf']);
        $hospede->setNome($linha['nome']);
        $hospede->setEndereco($linha['endereco']);
        $hospede->setCidade($linha['cidade']);
        $hospede->setTelefone($linha['telefone']);
        ?>

        <form action="alterarhospede.php" method="POST" id="form">
            <div id="loader" style="display: none;">
                <img src="img/loader.gif">
            </div>
            <h1>Alterar Hóspede</h1>
            <input type="hidden" name="cpf" value="<?= $hospede->getCpf() ?>">
            <p>Nome Completo:</p>
            <p><input type="text" name="nome"
                size="30" maxlength="30"
                pattern="[0-9a-zA-Z\s-çÇãÃéÉúÚóÓêÊ]{2,30}"
                value="<?= $hospede->getNome() ?>" 
                required></p>
                
                <p>Endereço:</p>
                <p><input type="text" name="endereco"
                    size="70" maxlength="70"
                    pattern="[0-9a-zA-Z\s,-çÇãÃéÉúÚóÓêÊ]{3,70}"
                    value="<?= $hospede->getEndereco() ?>" 
                    required></p>

                    <p>Cidade:</p>
                    <p><input type="text" name="cidade"
                        size="30" maxlength="30"
                        pattern="[a-zA-Z\s-çÇãÃéÉúÚóÓêÊ]{3,30}"
                        value="<?= $hospede->getCidade() ?>"
                        required></p>    
                        
                        <p>Telefone:</p>
                        <p><input type="text" name="telefone"
                            size="14" maxlength="14"
                            pattern="\([0-9]{2}\)[0-9]{4,5}-[0-9]{4}"
                            value="<?= $hospede->getTelefone() ?>" 
                            id="telefone" required></p>
                            
                            <input type="hidden" name="cpf" value="<?= $hospede->getCpf() ?>">
                            
                            <p><input type="submit" name="botao" value="Salvar Alterações"></p>
                            <button class='bnao'><a href="buscarhospede.php?termo=<?= $hospede->getCpf() ?>&campo=cpf&botao=Buscar">Cancelar</a></button></p>
                        </form>

                        <script src="js/loader.js"></script>

                        <?php 
                    } else if (isset($_POST['botao'])) {
                        require_once 'model/Hospede.php';
                        require_once 'persistence/HospedePA.php';
                        
                        $hospede = new Hospede();
                        $hospedepa = new HospedePA();

                        $hospede->setCpf($_POST['cpf']);
                        $hospede->setNome($_POST['nome']);
                        $hospede->setEndereco($_POST['endereco']);
                        $hospede->setCidade($_POST['cidade']);
                        $hospede->setTelefone($_POST['telefone']);
    // $hospede->setCodAdm($_COOKIE['administrador']); // Reative se houver controle de log

                        if ($hospedepa->alterar($hospede)) {
                            echo "<h2>Hóspede alterado com sucesso! 
                            <a href='buscarhospede.php'>Voltar para a busca</a>?</h2>";
                        } else {
                            echo "<h2>Erro na tentativa de alterar! 
                            Tente <a href='buscarhospede.php?termo=".$hospede->getCpf()."&campo=cpf&botao=Buscar'>
                            novamente</a></h2>";
                        }
                    } else {
                        echo "<h2>Ops! Hóspede não encontrado! <a href='index.php'>Volte para o início</a></h2>";
                    }

                }else{
                    header('location: login.php');
                }
require_once 'footer.php';
?>
</body>
</html>