### **Plano de Testes e Refatoração Avançado**

Este plano descreve a estratégia para implementar uma suíte de testes completa para o projeto Lara-Ecommerce, com foco em testes unitários, testes de funcionalidade e refatoração contínua para melhorar a qualidade do código.

**Fases do Projeto:**

*   [x] **Fase 0: Preparação e Configuração do Ambiente de Teste**
*   [x] **Fase 1: Testes de Unidade - Models (Camada de Dados)**
*   [ ] **Fase 2: Testes de Funcionalidade - Controllers e Rotas (Camada de HTTP)**
*   [ ] **Fase 3: Teste de Integração (Jornada do Usuário)**
*   [ ] **Fase 4: Execução Final e Relatório de Cobertura**

---

### **Fase 0: Preparação e Configuração do Ambiente de Teste**

**Objetivo:** Isolar completamente o ambiente de teste para garantir que os testes não afetem o banco de dados de desenvolvimento e rodem de forma rápida e consistente.

**Passos:**

1.  **[ ] Configurar `phpunit.xml`:**
    *   Analisar o arquivo `phpunit.xml` existente.
    *   Garantir que as variáveis de ambiente para teste estejam descomentadas e configuradas para usar uma conexão de banco de dados separada.

2.  **[ ] Criar o arquivo `.env.testing`:**
    *   Criar uma cópia do `.env.example` chamada `.env.testing`.
    *   Configurar este arquivo para usar um banco de dados em memória (SQLite) para máxima performance:
        ```
        DB_CONNECTION=sqlite
        DB_DATABASE=:memory:
        ```

3.  **[ ] Preparar a Classe de Teste Base:**
    *   Instruir todos os testes de funcionalidade a usar o trait `Illuminate\Foundation\Testing\RefreshDatabase`. Isso garantirá que o banco de dados seja migrado e zerado antes de cada teste, proporcionando um estado limpo e consistente.

---

### **Fase 1: Testes de Unidade - Models (Camada de Dados)**

**Objetivo:** Garantir que cada Model (`Admin`, `Cliente`, `Pedido`, `Produto`, etc.) funciona corretamente em isolamento. Testaremos seus atributos, relacionamentos e escopos.

**Passos:**

1.  [x] **Criar arquivos de teste para cada Model:**
    *   Usar o Artisan para gerar os arquivos de teste na pasta `tests/Unit/Models`.
    *   Comando: `php artisan make:test Models\UserTest --unit` (repetir para `Admin`, `Cliente`, `Pedido`, `Produto`, `PedidoStatus`).

2.  [x] **Escrever testes para o `User` Model:**
    *   Teste de criação: Verificar se uma instância de `User` pode ser criada e salva no banco de dados.
    *   Teste de atributos: Verificar se os atributos (`name`, `email`) são definidos corretamente.
    *   Teste de relacionamentos (se houver): Verificar se os relacionamentos com outros models estão funcionando.

3.  [x] **Repetir o processo para os outros Models:**
    *   Aplicar a mesma lógica de testes para `Admin`, `Cliente`, `Produto`, `Pedido` e `PedidoStatus`, focando nos relacionamentos específicos de cada um (ex: `Pedido` tem um `Cliente`, `Pedido` tem muitos `Produto`s através de `pedido_item`).

**Nota sobre Refatoração (SOLID):** Durante esta fase, se identificarmos Models com excesso de responsabilidade (ex: lógica de negócio complexa dentro do Model), vamos propor a extração dessa lógica para classes de Serviço (Service Classes), aderindo ao **Princípio da Responsabilidade Única (SRP)**.

---

### **Fase 2: Testes de Funcionalidade - Controllers e Rotas (Camada de HTTP)**

**Objetivo:** Garantir que todas as rotas e controllers respondem corretamente às requisições HTTP, validam os dados e interagem com a camada de dados como esperado.

**Passos:**

1.  [x] **Mapear as principais funcionalidades e rotas:**
    *   Analisar `routes/web.php` para identificar os principais grupos de rotas (autenticação, gerenciamento de produtos, carrinho, etc.).

2.  **[ ] Criar arquivos de teste para os Controllers:**
    *   Usar o Artisan para gerar os arquivos na pasta `tests/Feature`.
    *   Comando: `php artisan make:test Http\Controllers\ProdutoControllerTest` (repetir para os controllers principais).

3.  **[ ] Escrever testes para o `ProdutoController`:**
    *   Teste de `index`: Verificar se a rota `/produtos` retorna status 200 e exibe uma lista de produtos.
    *   Teste de `show`: Verificar se a rota `/produtos/{id}` retorna um produto específico.
    *   Teste de `store` (criação):
        *   Verificar se a validação falha com dados inválidos (retorna erro 422 ou redireciona com erros).
        *   Verificar se um produto é criado no banco de dados com dados válidos.
    *   Testar as rotas de `update` e `destroy` de forma similar.

4.  **[ ] Repetir o processo para outros Controllers:**
    *   Aplicar a mesma lógica para os controllers de autenticação, carrinho, pedidos, etc.

**Nota sobre Refatoração (Clean Code):** Se encontrarmos "Fat Controllers" (controllers com muita lógica), vamos refatorá-los. A lógica de negócio será movida para classes de Serviço ou Ação (Action classes), tornando o controller enxuto e focado apenas em receber a requisição e retornar a resposta.

---

### **Fase 3: Teste de Integração (Jornada do Usuário)**

**Objetivo:** Simular um fluxo completo de um usuário no sistema para garantir que os diferentes componentes (autenticação, listagem de produtos, carrinho, checkout) funcionam bem juntos.

**Passos:**

1.  **[ ] Criar um arquivo de teste para a jornada de compra:**
    *   Comando: `php artisan make:test E2E\UserShoppingJourneyTest`

2.  **[ ] Escrever o teste da jornada:**
    *   Simular um usuário se registrando no site.
    *   Fazer login com o novo usuário.
    *   Navegar para a página de produtos.
    *   Adicionar um item ao carrinho.
    *   Acessar o carrinho.
    *   Finalizar a compra (criar um `Pedido`).
    *   Verificar se o pedido foi salvo corretamente no banco de dados.
    *   Fazer logout.

---

### **Fase 4: Execução Final e Relatório de Cobertura**

**Objetivo:** Executar toda a suíte de testes e gerar um relatório de cobertura de código para identificar áreas não testadas.

**Passos:**

1.  **[ ] Executar todos os testes:**
    *   Comando: `./vendor/bin/phpunit`

2.  **[ ] Gerar relatório de cobertura:**
    *   Comando: `./vendor/bin/phpunit --coverage-html coverage-report`
    *   Analisar o relatório gerado em `coverage-report/index.html` para visualizar a porcentagem de código coberto por testes e planejar os próximos passos.
