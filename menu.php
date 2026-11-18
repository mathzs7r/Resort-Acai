<section class="topo">
    <div id="logo">
        <a href="index.php"><img src="img/logoacima.png" alt="Logo"></a>
    </div>
    <div id="menu">
        <ul class="nav">
            <?php 
            // CASO 1: Usuário NÃO está logado
            if(!isset($_COOKIE['administrador']) || $_COOKIE['administrador'] == 'deleted'){ ?>
                <li><a href="login.php">Login</a></li>
                <li><a href="sobre.php">Sobre</a></li>
            
            <?php 
            // CASO 2: Usuário ESTÁ logado (Administrador ou Funcionário)
            } else { 
                
                // Menu exclusivo do Administrador Nível 1 (h)
                if(isset($_COOKIE['nivel']) && $_COOKIE['nivel'] == 1){ ?>
                    <li>Administradores
                        <ol>
                            <li><a href="cadastraradmin.php">Cadastrar</a></li>
                            <li><a href="listaradmin.php">Listar</a></li>
                            <li><a href="buscaradmin.php">Buscar</a></li>
                        </ol>
                    </li>
                <?php }
                
                // Menu exclusivo do Administrador Nível 2 (Gerente/)
                if(isset($_COOKIE['nivel']) && $_COOKIE['nivel'] == 2){ ?>
                    <li>Funcionários
                        <ol>
                            <li><a href="cadastraradmin2.php">Cadastrar </a></li>
                            <li><a href="listaradmin.php">Listar </a></li>
                            <li><a href="buscaradmin.php">Buscar </a></li>
                        </ol>
                    </li> 
                <?php } 
                
                // Menu liberado para Nível 1 e Nível 2
                if(isset($_COOKIE['nivel']) && ($_COOKIE['nivel'] == 1 || $_COOKIE['nivel'] == 2)){ ?>
                    <li>Hóspedes
                        <ol>
                            <li><a href="cadastrarhosp.php">Cadastrar</a></li>
                            <li><a href="listarhospede.php">Listar</a></li>
                            <li><a href="buscarhospede.php">Buscar</a></li>
                        </ol>
                    </li>
                    <li>Parceiros
                        <ol>
                            <li><a href="cadastrarparceiro.php">Cadastrar</a></li>
                            <li><a href="listarparceiro.php">Listar</a></li>
                            <li><a href="buscarparceiro.php">Buscar</a></li>
                        </ol>
                    </li>
                    <li>Reservas
                        <ol>
                            <li><a href="cadastrarreserva.php">Cadastrar</a></li>
                            <li><a href="listarreserva.php">Listar</a></li>
                            <li><a href="buscarreserva.php">Buscar Histórico</a></li>
                            <li><a href="reservasativas.php">Reservas Ativas</a></li>
                        </ol>
                    </li>
                    <li>Quartos
                        <ol>
                            <li><a href="cadastrarquarto.php">Cadastrar</a></li>
                            <li><a href="listarquarto.php">Listar</a></li>
                            <li><a href="buscarquarto.php">Buscar</a></li>
                        </ol>
                    </li>
                    <li>Conta
                        <ol>
                            <li><a href="alterarsenha.php">Alterar Senha</a></li>
                            <li><a href="logoff.php">Sair</a></li>
                        </ol>
                    </li>
                <?php } 
                
                // Menu exclusivo para Funcionários Comuns (Sem nível 1 ou 2)
                if(!isset($_COOKIE['nivel']) || ($_COOKIE['nivel'] != 1 && $_COOKIE['nivel'] != 2)){ ?>
                <li>Hóspedes
                        <ol>
                            <li><a href="cadastrarhosp.php">Cadastrar</a></li>
                            <li><a href="listarhospede.php">Listar</a></li>
                            <li><a href="buscarhospede.php">Buscar</a></li>
                        </ol>
                    </li>
                <li>Reservas
                        <ol>
                            <li><a href="cadastrarreserva.php">Cadastrar</a></li>
                            <li><a href="listarreserva.php">Listar</a></li>
                            <li><a href="buscarreserva.php">Buscar Histórico</a></li>
                            <li><a href="reservasativas.php">Reservas Ativas</a></li>
                        </ol>
                    </li>
                    <li>Conta
                        <ol>
                            <li><a href="alterarsenha.php">Alterar Senha</a></li>
                            <li><a href="logoff.php">Sair</a></li>
                        </ol>
                <?php }
            } ?>
        </ul>
    </div>
</section>
