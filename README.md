fiz uma copia do projeto do professor israel e coloquei no meu repositorio para fazer as devidas alteracoes para entregar no dia 19.

aproveitando a ideia do professor irei criar um controle de estoque que depois de pronto ira se comunicar com o e-commerce que estou criando.

seguir os passos do readme do professor para dar certo.
criar a tabela estoque.
avaliar a funcinalidade e o layout da pagiina.

// instruções professor //

Executar o comando composer install para instalar as dependências do projeto.

Copiar .env.example para .env

Configurar conexão com banco de dados com variáveis DB_

Alterar chave CSRF_KEY no arquivo .env | IT-Tools

Testar conexão e migração de dados

| Linux: vendor/bin/phinx migrate --dry-run

| Windows: php vendor/bin/phinx migrate --dry-run

Rodar servidor embutido do php (utilizar url APP_URL do .env)
| php -S localhost:8001 -t public

Executar migração de dados
| Linux: vendor/bin/phinx migrate

| Windows: php vendor/bin/phinx migrate

Criar primeiro usuário
Acesse: localhost:8001/auth/create

E-mail: teste@teste.com
Senha: teste123
Routes (routes.php)
Controller (ProductController > CategoryController)
Migrations (db/migrations)
Repository (ProductRepository > CategoryRepository) ----
Model (Product > Category)
Service (ProductService > CategoryService)
Views (duplicar - views/admin/products > categories)
Controller (views)
Views (alterar)