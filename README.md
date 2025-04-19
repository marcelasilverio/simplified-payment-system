# Sistema Simplificado de Pagamentos

Bem-vindo ao repositório do Sistema Simplificado de Pagamentos, uma API desenvolvida em Laravel que permite realizar transações financeiras entre usuários. Este projeto foi criado com foco em boas práticas de desenvolvimento, seguindo os princípios REST. Além disso, um container Docker foi criado para facilitar a configuração e execução.


# Índice

- Arquitetura
- Tecnologias Utilizadas
- Pré-requisitos
- Configuração
- Roadmap
- Licença

# Arquitetura

O Sistema Simplificado de Pagamentos é uma API REST que permite criar pagamentos entre usuários.



A aplicação foi projetada para ser executada dentro de um ambiente Docker, garantindo consistência e facilidade de uso em diferentes máquinas.



# Tecnologias Utilizadas

Este projeto utiliza as seguintes tecnologias:

Laravel: Framework PHP para desenvolvimento web.
PHP 8.4 CLI (Alpine): Ambiente leve e seguro para execução da aplicação.
SQLite: Banco de dados relacional baseado em arquivos.
Docker: Para containerização da aplicação.
Docker Compose: Para orquestração dos serviços.


# Pré-requisitos

Antes de começar, certifique-se de ter instalado:

Git: Para clonar o repositório.
Docker: Versão 20.10 ou superior.
Docker Compose: Versão 2.x ou superior.
WSL 2 (se estiver usando Windows): Para executar containers Linux.

# Configuração

Siga os passos abaixo para configurar o projeto (pensado para um ambiente Linux):

1. Clone o Repositório
git clone https://github.com/seu-usuario/simplified-payment-system.git

2. Navegue até o Diretório do Projeto
cd simplified-payment-system

3. Rode os comandos abaixo para a configuração do continer

```bash
  cd ~/simplified-payment-system
  chmod +x setup.sh
  ./setup.sh
```

3. Para iniciar a aplicação: 

```bash
  docker compose up
```

É possível acessar a API pela rota http://0.0.0.0:8000.

# Estrutura do Projeto

A estrutura do projeto está organizada da seguinte forma:

simplified-payment-system/
├── Dockerfile                # Configuração do ambiente Docker
├── docker-compose.yml        # Orquestração dos serviços Docker
├── container/
│   ├── api/                  # Código-fonte da aplicação Laravel
│   │   ├── app/              # Código principal da aplicação
│   │   ├── bootstrap/        # Arquivos de inicialização
│   │   ├── config/           # Configurações da aplicação
│   │   ├── database/         # Arquivos de migração e seeders
│   │   │   ├── database.sqlite # Banco de dados SQLite
│   │   ├── public/           # Arquivos públicos (index.php)
│   │   ├── routes/           # Rotas da aplicação
│   │   ├── storage/          # Arquivos gerados pela aplicação
│   │   ├── tests/            # Testes automatizados
│   │   ├── .env              # Variáveis de ambiente
│   │   ├── artisan           # Comando Artisan
│   │   ├── composer.json     # Dependências PHP
│   │   ├── composer.lock     # Versões travadas das dependências
│   │   └── server.php        # Servidor de desenvolvimento


# Licença

Este projeto está licenciado sob a MIT License. Você pode usar, modificar e distribuir este código conforme necessário.

---

# Contato

Caso tenha dúvidas ou sugestões, entre em contato:

Nome: Marcela Prata Silvério
Email: marcelapsilverio@gmail.com
GitHub: https://github.com/marcelasilverio