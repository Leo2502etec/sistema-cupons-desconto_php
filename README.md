# Sistema de Cupons de Desconto

Sistema web desenvolvido para criação e gerenciamento de cupons promocionais. Cada cupom possui código, porcentagem de desconto e data de validade.

Projeto desenvolvido para a disciplina de Programação Web.

## Funcionalidades

- Cadastrar cupons;
- Listar cupons cadastrados;
- Editar cupons;
- Excluir cupons;
- Identificar cupons válidos e vencidos;
- Impedir códigos duplicados;
- Validar os dados dos formulários.

## Tecnologias utilizadas

- PHP;
- MySQL;
- HTML e CSS;
- JavaScript;
- Bootstrap;
- XAMPP e phpMyAdmin.

## Como executar

1. Coloque a pasta `sistema_cupons` dentro de `C:\xampp\htdocs`;
2. Inicie o Apache e o MySQL no XAMPP;
3. Acesse `http://localhost/phpmyadmin`;
4. Crie um banco chamado `sistema_cupons`;
5. Importe o arquivo `sistema_cupons/database/sistema_cupons.sql`;
6. Acesse `http://localhost/sistema_cupons/`.

## Banco de dados

A tabela `cupons` possui os campos:

- `id`: identificação do cupom;
- `codigo`: código promocional;
- `porcentagem`: valor do desconto;
- `validade`: data de validade.

## Autor

Leonardo Gregorio de Sousa
