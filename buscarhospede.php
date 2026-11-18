<?php 
require_once 'cabecalho.php';
require_once 'menu.php';
if (isset($_COOKIE['administrador'])) {
echo "<div id='conteudo'>";
    ?>
    <form action="buscarhospede.php" method="GET" id="form">
        <div id="loader" style="display: none;"><img src="img/loader.gif"></div>
        <h1>Busca de Hóspedes</h1>
        <p>Termo</p>
        <p><input type="search" name="termo" size="40" required pattern="[0-9a-zA-Z/s-çÇãÃéÉúÚóÓêÊíÍ\(\)]{1,70}" title="Busque somente por CPF, Nome ou Cidade" placeholder="Buscar Termo"></p>
        <p>Categoria:</p>
        <p>
            <input type="radio" name="campo" value="cpf">CPF
            <input type="radio" name="campo" value="nome">Nome
            <input type="radio" name="campo" value="cidade">Cidade
        </p>
        <p><input type="submit" name="botao" value="Buscar"></p>
    </form>
    <?php

    if (isset($_GET['botao'])) {
        require_once 'persistence/HospedePA.php';
        $hospedepa=new HospedePA();

        if(isset($_GET['campo'])&&$_GET['campo']!=""){
            $consulta=$hospedepa->buscar($_GET['termo'],($_GET['campo']));
        }else{
            $consulta=$hospedepa->buscar($_GET['termo'],'');
        }
        if(!$consulta){
            echo "<h2>Nenhum resultado encontrado.</h2>";
        }else{
            require_once 'model/Hospede.php';
            $hospede=new Hospede();

            echo "<table>";
            echo "<tr>";
            echo "<th>CPF</th>";
            echo "<th>Nome</th>";
            echo "<th>Telefone</th>";          
            echo "<th>Cidade</th>";
            echo "<th>Endereço</th>";
            echo "<th>Editar ou Excluir</th>";
            echo "</tr>";

            while ($linha = $consulta->fetch_assoc()) {
                $hospede->setCpf($linha['cpf']);
                $hospede->setNome($linha['nome']);
                $hospede->setTelefone($linha['telefone']);
                $hospede->setCidade($linha['cidade']);
                $hospede->setEndereco($linha['endereco']);

                echo "<tr>";
                echo "<td>".$hospede->getCpf()."</td>";
                echo "<td>".$hospede->getNome()."</td>";
                echo "<td>".$hospede->getTelefone()."</td>";
                echo "<td>".$hospede->getCidade()."</td>";
                echo "<td>".$hospede->getEndereco()."</td>";
                echo "<td><a href='alterarhospede.php?cpf=".$hospede->getCpf()."'><img src='img/edit white.png'></a> &nbsp;
                <a href='excluirhospede.php?cpf=".$hospede->getCpf()."'><img src='img/delete white.png'></a></td>";
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