Sistema de Gestão de Cargos e Funcionários
=================================================================

Este projeto é um sistema desenvolvido em PHP com CodeIgniter 3 e PostgreSQL, destinado à gestão de funcionários e seus cargos ao longo do tempo. Conta com funcionalidades completas de cadastro, histórico, edição e verificação de conflitos de datas.

Funcionalidades
---------------

- Cadastro de Funcionários e Cargos
- Edição de dados de Funcionários e cargos
- Atribuição de cargos com datas de início e fim
- Controle de histórico de cargos
- Desligamento de funcionários 
- Verificação automática de conflitos de datas
- Modal de sucesso e erro para ações importantes
- Pesquisa de funcionários e cargos (inclusive com Select2)
- Paginação de resultados

Validações e Regras de Negócio
------------------------------

- Um funcionário não pode ter dois cargos no mesmo intervalo de tempo (exceto o dia atual)
- A data mínima para novo cargo após desligamento é o dia seguinte ao desligamento
- Não é possível iniciar um cargo em uma data futura
- O sistema valida conflitos de datas e oferece link direto para histórico quando necessário
- Modal de confirmação antes da exclusão de qualquer registro

Tecnologias Utilizadas
-----------------------

- PHP 7.4
- CodeIgniter 3
- PostgreSQL
- Bootstrap 5.3
- Bootstrap Icons
- Select2 (autocomplete AJAX)
- jQuery
- HTML5 e CSS3
- Git

Organização de Código
---------------------

- Arquitetura MVC com separação clara entre Controllers, Models e Views
- CSS separado por página em: ``assets/css/pages/{controller}/{view}.css``
- Reutilização de layout com view ``layout.php``

Tecnologias para usadas para execução Local
--------------

1. Laragon
2. PGAdmin
3. URL para testes local: http://localhost/ci/index.php/