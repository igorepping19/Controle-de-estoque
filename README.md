Controle de Estoque – Painel Administrativo (PHP Puro)
Projeto completo e 100% funcional desenvolvido do zero com PHP 8+, arquitetura MVC manual, League\Plates (templates), Composer e MySQL.
Funcionalidades implementadas

Login seguro com sessão e proteção de rotas admin
CRUD completo de Produtos e Categorias
Sistema de controle de estoque com quantidade atual e estoque mínimo
Movimentação de estoque (Entrada e Saída) com formulário dedicado
Validação de dados e feedback visual de erros
Interface responsiva e moderna (Bootstrap 5 + layout admin personalizado)
Alertas visuais para produtos com estoque baixo
Detalhes completos de cada produto (imagem, preço, categoria, estoque, data de criação/atualização)

Tecnologias utilizadas

PHP 8+ (sem framework)
MySQL
Composer
League\Plates (motor de templates leve)
Bootstrap 5 + Font Awesome
Estrutura MVC manual (Controllers, Services, Repositories, Models)
Rotas manuais (sem framework de roteamento)
Sessões nativas do PHP
Validação manual de formulários

Como rodar o projeto
Bashgit clone https://github.com/seu-usuario/controle-de-estoque.git
cd controle-de-estoque

# Copia o arquivo de configuração
cp .env.example .env

# Edita o .env com os dados do seu banco MySQL
# Cria o banco de dados (ex: controle_estoque)

# Instala as dependências
composer install

# Importa a estrutura do banco de dados
# (execute o SQL que está na pasta database/ ou use as migrations se houver)

# Inicia o servidor embutido do PHP
php -S localhost:8000 -t public
