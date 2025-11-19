<div align="center">

# Controle de Estoque  
### Painel Administrativo em PHP Puro

<p align="center">
  <img src="https://img.shields.io/badge/PHP-8.1%2B-777BB4?style=for-the-badge&logo=php&logoColor=white" alt="PHP"/>
  <img src="https://img.shields.io/badge/MySQL-4479A1?style=for-the-badge&logo=mysql&logoColor=white" alt="MySQL"/>
  <img src="https://img.shields.io/badge/Bootstrap-563D7C?style=for-the-badge&logo=bootstrap&logoColor=white" alt="Bootstrap"/>
  <img src="https://img.shields.io/badge/Composer-885630?style=for-the-badge&logo=composer&logoColor=white" alt="Composer"/>
</p>

<img src="public/assets/img/screenshot.jpg" width="100%" alt="Preview do sistema" style="border-radius: 12px; box-shadow: 0 10px 30px rgba(0,0,0,0.3);">

> Sistema completo de controle de estoque com entrada/saída, CRUD de produtos e interface admin moderna — **feito do zero, sem Laravel, sem framework**.

</div>

## Funcionalidades

- Login seguro com sessão
- Cadastro completo de **Produtos** e **Categorias**
- Controle de estoque com quantidade atual e estoque mínimo
- Entrada e Saída de estoque com formulário dedicado
- Validação de dados + mensagens de erro amigáveis
- Alertas visuais para produtos com estoque baixo
- Interface 100% responsiva (Bootstrap 5)
- Painel admin elegante e intuitivo

## Tecnologias

| Tecnologia       | Uso                          |
|------------------|------------------------------|
| PHP 8+           | Lógica e backend             |
| MySQL            | Banco de dados               |
| League\Plates    | Motor de templates           |
| Bootstrap 5      | Design responsivo            |
| Composer         | Gerenciamento de dependências|

## Como rodar (2 minutos)

```bash
git clone https://github.com/SEU_USUARIO/controle-de-estoque.git
cd controle-de-estoque

# Configuração
cp .env.example .env
# Edite o .env com seus dados do banco

# Dependências
composer install

# Servidor
php -S localhost:8000 -t public