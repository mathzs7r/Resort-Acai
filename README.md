# Resort Açaí

Sistema de gestão de hospedagens, reservas e parceiros do **Resort Açaí**, localizado em **Porto de Galinhas**.

Desenvolvido em **PHP**, na sua totalidade, com páginas de front em **HTML**, **CSS** e **JavaScript**.

> **Projeto Integrador** — Curso Programador de Sistemas — SENAC — Turma Março/2026 (Tarde)

---

## Sobre o projeto

O proprietário do empreendimento, o **Resort Açaí**, identificava dificuldades no controle administrativo das informações relacionadas às hospedagens, parceiros e reservas. Com o controle ainda em formato manual, surgiam atrasos no atendimento, falhas de comunicação, perda de informações e dificuldades de gestão.

Diante desse cenário, o time desenvolveu este sistema web para auxiliar no **gerenciamento do resort**, permitindo o cadastro de hóspedes e parceiros, o controle das reservas e a organização das informações diárias do estabelecimento.

## Funcionalidades

### Autenticação e conta
- Tela de **login** com validação de login e senha cadastrados.
- Senhas armazenadas com **hash** (`bcrypt` via `password_hash`/`password_verify`).
- **Logout** da conta.
- **Alteração de senha** autenticada.

### Gestão de administradores e funcionários
- Cadastro, listagem e busca de administradores.
- Cadastro, listagem e busca de funcionários.
- Alteração e exclusão de administradores.

### Gestão de hóspedes
- Cadastro de hóspedes com nome, telefone, CPF, cidade e endereço.
- Listagem, busca e alteração/exclusão.

### Gestão de parceiros
- Cadastro de parceiros (restaurantes, fornecedores, etc.) com CNPJ, nome, telefone, descrição e logo.
- Listagem, busca e exclusão, com exibição do logo em **base64**.

### Gestão de quartos
- Cadastro de quartos com número, nível (básico/luxo/premium/master), cama, status, foto e valor.
- Listagem e busca, com verificação de disponibilidade para novas reservas.

### Gestão de reservas e checkout
- Cadastro de reserva vinculando hóspede (CPF) e quarto.
- Cálculo do **valor total** = diária × valor do quarto.
- Marcação de quarto como **ocupado** ao registrar reserva.
- **Reservas ativas** e **histórico** com busca e paginação.
- **Checkout** para finalizar reserva e liberar o quarto.

## Perfis de acesso

| Nível | Perfil | Acesso |
|---|---|---|
| 1 | Administrador | Gestão completa de administradores, além de hóspedes, parceiros, reservas, quartos e conta. |
| 2 | Gerente | Cadastro/listagem/busca de funcionários e gestão completa de hóspedes, parceiros, reservas, quartos e conta. |
| 3 | Funcionário | Gestão limitada a hóspedes, reservas (cadastro, listagem, histórico, ativas, checkout) e conta. |

O menu de navegação (`menu.php`) é gerado dinamicamente conforme o valor do cookie de sessão (`administrador` / `nivel`).

## Tecnologias utilizadas

- **PHP** — backend (sem framework, orientação a objetos nos models/persistence).
- **MySQL / MariaDB** — banco de dados.
- **HTML5**, **CSS3**, **JavaScript** — interface.

## Estrutura do projeto

```
Resort-Acai/
├── README.md
├── .gitignore
├── index.php                     # Página inicial (home)
├── cabecalho.php                 # Cabeçalho HTML/HTML + CSS + meta tags
├── menu.php                      # Menu de navegação dinâmico
├── footer.php                    # Rodapé
├── sobre.php                     # Página institucional (Sobre o Resort)
├── login.php                     # Tela de login
├── logoff.php                    # Encerra sessão
├── checkout.php                  # Finaliza reserva / liberar quarto
├── reservasativas.php            # Reservas com status ativo
├── listaradmin.php               # Listagem de administradores
├── listaradmin2.php              # Listagem de funcionários
├── listarhospede.php             # Listagem de hóspedes
├── listarparceiro(s).php        # Listagem de parceiros
├── listarquarto.php              # Listagem de quartos
├── listarreserva.php             # Histórico de reservas
├── cadastrar*.php                # Cadastros (administradores, funcionários, hóspedes, parceiros, quartos, reservas)
├── alterar*.php                  # Alterações (administradores, hóspedes, parceiros, quartos, reservas, senha)
├── excluir*.php                  # Exclusões (administradores, hóspedes, parceiros, quartos, reservas)
├── buscar*.php                   # Buscas (administradores, hóspedes, parceiros, quartos, reservas)
├── css/
│   └── style.css                 # Estilos (tema, layout, botões, loader, paginacao)
├── js/
│   └── loader.js                 # Controle do loader/gif durante requisições
├── img/                          # Imagens (logos, acai, quartos, lazer, restaurante, loader, ícones)
├── icone/                        # Ícone do site
├── model/                        # Classes de entidade (Administrador, Parceiros, Quarto, Reserva, Hospede)
├── persistence/                  # Camada de acesso a dados (Banco, ...,PA)
├── resort_acai.sql               # Script SQL do banco de dados
├── documentacao.docx             # Documento técnico do projeto
├── caso de uso.png               # Diagrama de caso de uso
├── modelagem.brM                 # Modelo Entidade-Relacionamento
└── historia.txt                  # História do projeto
```

## Banco de dados

O banco é o **`resort_acai`**, criado a partir do script `resort_acai.sql` (phpMyAdmin/MySQL).

Principais tabelas:

| Tabela | Campos principais |
|---|---|
| `administrador` | `cod_adm` (PK), `nome`, `login`, `senha`, `nivel` |
| `hospede` | `cpf` (PK), `nome`, `telefone`, `cidade`, `endereco` |
| `parceiros` | `cnpj` (PK), `nome`, `logo`, `telefone`, `descricao`, `cod_adm` |
| `quarto` | `numero` (PK), `cama`, `nivel`, `status`, `foto`, `valor` |
| `reserva` | `cod_res` (PK), `total`, `data_ent`, `data_sai`, `cpf`, `quarto`, `cod_adm`, `status_res` |

## Como executar

### Requisitos

- PHP com extensão **mysqli**
- MySQL/MariaDB
- Servidor web com Apache (recomendado: **XAMPP**)

### Passo a passo

1. Copie/clona a pasta do projeto para o diretório do Apache, ex.: `C:\xampp\htdocs\Resort-Acai`.
2. Inicie o **Apache** e o **MySQL** no painel do XAMPP.
3. Acesse o phpMyAdmin (http://localhost/phpmyadmin) e importe o arquivo `resort_acai.sql`.
4. Ajuste as credenciais de conexão em `persistence/Banco.php` (host, usuário, senha e nome do banco).
5. Acesse no navegador: `http://localhost/Resort-Acai/index.php`
6. Faça o login com as credenciais cadastradas.

## Acesso inicial

O script SQL já inclui um administrador de teste:

- **Login:** `admin`
- **Nome:** Genésio da Silva
- **Nível:** 1

A senha do administrador é armazenada como hash no banco (bcrypt). Para redefinir a senha, gere um novo hash e atualize a tabela:

```php
<?php
echo password_hash('nova_senha', PASSWORD_DEFAULT);
?>
```

```sql
UPDATE administrador
SET senha = '<hash_gerado>'
WHERE cod_adm = 1;
```

## Limitações conhecidas

- O script `resort_acai.sql` **não inclui** a coluna `status_res` da tabela `reserva`, que é utilizada pelo código (reservas ativas, checkout, alteração). Necessário adicionar:

```sql
ALTER TABLE `reserva`
  ADD COLUMN `status_res` TINYINT(1) NOT NULL DEFAULT 1;
```

- As consultas são montadas por **concatenação de strings** (sem prepared statements), o que pode causar vulnerabilidade a SQL injection.
- Autenticação por cookies sem proteção adicional (`HttpOnly`, `Secure`, CSRF).
- Não há uso da sessão nativa do PHP (autenticação via cookies customizados).
- Uploads de imagens (logos e fotos de quartos) armazenados em **BLOB**.

## Melhorias futuras

- Migração das consultas para **prepared statements**.
- Uso da **sessão nativa do PHP**.
- Padronização de controllers e camadas.
- Upload de arquivos reais em vez de BLOB.

## Documentação

- `documentacao.docx` — documento técnico do projeto.
- `caso de uso.png` — diagrama de caso de uso.
- `modelagem.brM` — modelo Entidade-Relacionamento.

## Equipe

Desenvolvido pela equipe do **Projeto Integrador** — Turma Março/2026, Tarde:

Arthur Faria Farias, Arthur Gabriel Pacheco, Camile de Lima Danilenko, Carlos Gabriel de Assumpção, Denise Veronez de Castro, Filomena Keller, Helan Ricardo Ramos da Silva, Luiza Gabriely Mayer, Matheus Almeida, Maysa Vaz Sukoski, Mickael Alvaranga Gomes, Rafael Henrique Mehret, Sabrina Prado Daniel, Weinnie de Souza Carlos.

**Orientação:** Prof. Gabriel França  
**Coordenação:** Prof. José Amande

## Licença

Projeto de caráter acadêmico. Todos os direitos reservados à equipe de desenvolvimento.
