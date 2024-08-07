# Contas para login
- recepcionista@example.com -pw: password
- dr.joao@example.com -pw: password
- dra.maria@example.com -pw: password
- dr.pedro@example.com -pw: password

# Intruções de Instalação

## Features

- [x] **O utente poder agendar marcações**
  - Nome da pessoa
  - Email
  - Nome do animal
  - Tipo de animal (cão, gato, etc)
  - Idade
  - Sintomas
  - Data
  - Manhã/Tarde

- [x] **O rececionista da clínica poder**
  - Ver as marcações por datas e por tipo de animal
  - Atribuir as marcações a médicos
  - Criar, editar e apagar todas as marcações

- [x] **O médico poder**
  - Ver as marcações que lhe estão atribuídas, por dias e por tipo de animal
  - Poder editar somente as marcações que lhe estão atribuídas
  - Não pode apagar nenhuma marcação

## Pré-requisitos

- PHP (>= 8.1)
- Composer
- Node.js (>= 18.x)
- NPM or Yarn
- MySQL or MariaDB

## Instalação
 1. Clone o repositório
 2. Entre na pasta do projeto
 3. Execute o comando `composer install`
 4. Copiar o arquivo `.env.example` para `.env` e preencher com as informações
 5. Execute o comando `php artisan key:generate`
 6. Execute o comando `php artisan migrate --seed`
 7. Execute o comando `npm install`
 8. Execute o comando `npm run dev`
 9. Execute o comando `php artisan serve`
 10. Acesse a URL `http://localhost:8000`

 ## Correr os testes
 Para executar os testes, execute o comando `php artisan test`
