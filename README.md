# Vida Animal — Sistema de Adoção de Animais (TDE 2)

Aplicação web para gerenciamento de adoção de animais, desenvolvida com **HTML/CSS**, **JavaScript (`fetch` / JSON)**, **PHP (sessões e `mysqli` com prepared statements)** e banco de dados relacional **MySQL / MariaDB**.

---

## 1. Requisitos de Ambiente

- **PHP 8.x** com a extensão `mysqli` habilitada
- **MySQL** ou **MariaDB** em execução em `localhost:3306`

---

## 2. Configuração do Banco de Dados

1. Importe o script SQL localizado em `database/vida_animal.sql` no MySQL/MariaDB:
   ```bash
   mysql -u root -p < database/vida_animal.sql
   ```
2. Verifique as credenciais de conexão em `backend/conexao.php`:
   ```php
   $connect = mysqli_connect("localhost:3306", "root", "amora321", "vida_animal");
   ```
   *(Caso a senha do usuário `root` no ambiente local seja diferente, ajuste o terceiro parâmetro em `backend/conexao.php`.)*

---

## 3. Como Executar Localmente

Na pasta raiz do projeto, inicie o servidor embutido do PHP (ou utilize XAMPP/Apache):

```bash
php -S localhost:8000
```

Acesse no navegador:
```text
http://localhost:8000/index.html
```

---

## 4. Roteiro de Teste e Demonstração

1. **Cadastro de Usuário (`Interessados`)**:
   - No menu superior, clique em **Interessados**.
   - Preencha Nome, E-mail, Senha, Telefone e demais campos e clique em **Cadastrar interessados**.
2. **Autenticação (`Login` / `Sair`)**:
   - Clique em **Login**, informe o e-mail e a senha recém-cadastrados e clique em **Entrar**.
   - A saudação `"Olá, <nome>"` será exibida no topo e as abas de gerenciamento (**Solicitação de Adoção**, **Acompanhamento** e **Administração**) serão liberadas.
3. **CRUD de Animais (`Cadastro de Animais`)**:
   - Cadastre um novo animal, consulte na tabela, atualize seus dados em **Editar Animal** ou remova em **Excluir Animal**.
4. **CRUD de Usuários (`Interessados`)**:
   - Consulte os interessados cadastrados, edite seus dados em **Editar Interessado** ou remova em **Excluir Interessado**.
5. **Relacionamento e CRUD de Solicitações (`Solicitação de Adoção`, `Acompanhamento`, `Administração`)**:
   - Em **Solicitação de Adoção**, vincule um interessado (`usuario`) a um animal (`animais`) informando a justificativa.
   - Em **Acompanhamento**, atualize a etapa e a observação da solicitação.
   - Em **Administração**, aprove/rejeite ou exclua uma solicitação.
