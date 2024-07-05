# PDV

Este é um projeto de exemplo de um sistema de gerenciamento de produtos e vendas utilizando PHP puro para o backend e Vue.js para o frontend. O sistema permite cadastrar, listar, alterar e deletar produtos, bem como realizar vendas dos produtos cadastrados. O banco de dados utilizado é o PostgreSQL.

## Funcionalidades

### Backend (PHP)
- Servidor PHP executado no endereço `localhost:8080`.
- Conexão com o banco de dados PostgreSQL.
- API para manipulação de produtos e vendas.

### Frontend (Vue.js)
- Interface para cadastrar produtos.
- Lista de produtos cadastrados com opções de edição e exclusão.
- Interface para realizar vendas, calculando valores totais e impostos.
- Tabela de resumo das vendas realizadas.


## Instruções de Configuração

### Requisitos

- PHP 8.3.1+
- Node.js e npm
- PostgreSQL

### Backend

1. **Instale o PHP**: Certifique-se de ter o PHP instalado em sua máquina.
2. **Configuração do Banco de Dados**: Crie um banco de dados PostgreSQL e configure o arquivo de configuração de conexão no diretório `backend/.env`.
3. O backup do banco de dados para importação se encontra na raiz do projeto no arquivo `pdvBKP`.
4. **Inicie o Servidor Backend**: Navegue até o diretório `backend` e execute o seguinte comando:

```sh
php -S localhost:8080
```

5. **Inicie o Servidor Frontend**: Navegue até o diretório `frontend` e execute o seguinte comando:

```sh
npm install
npm run serve
```

