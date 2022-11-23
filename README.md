## Gerenciamento Eletrodomésticos

Esta aplicação foi desenvolvida utilizando Laravel e Bootstrap e jQuery, possui a funcionalidade de gerenciar o cadastro de eletromésticos e suas marcas.
O banco de dados suportado é o MySQL.

- Laravel: 9.40.1.
- MySQL: 8.0

## API

### Appliances
Gerencia o cadastro e listagem dos eletrodomésticos no sistema.

| Método | Path | Descrição |
|---|---|---|
| `GET` | /appliance | Retorna informações de um ou mais registros. |
| `POST` | /appliance | Utilizado para criar um novo registro. |
| `PUT` | /appliance/{id} | Atualiza dados de um registro ou altera sua situação. |
| `DELETE` | /appliance/{id} | Remove um registro do sistema. |

### Marks
Gerencia as marcas dos eletrodomésticos.

| Método | Path | Descrição |
|---|---|---|
| `GET` | /marks | Retorna informações de um ou mais registros. |
| `POST` | /marks | Utilizado para criar um novo registro. |
| `PUT` | /marks/{id} | Atualiza dados de um registro ou altera sua situação. |
| `DELETE` | /applimarksance/{id} | Remove um registro do sistema. |

## Respostas

| Código | Descrição |
|---|---|
| `200` | Requisição executada com sucesso (success).|
| `400` | Erros de validação ou os campos informados não existem no sistema.|
| `401` | Dados de acesso inválidos.|
| `404` | Registro pesquisado não encontrado (Not found).|
| `405` | Método não implementado.|
| `410` | Registro pesquisado foi apagado do sistema e não esta mais disponível.|
| `422` | Dados informados estão fora do escopo definido para o campo.|
| `429` | Número máximo de requisições atingido. (*aguarde alguns segundos e tente novamente*)|
