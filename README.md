# TheWisePad-App

Projeto TheWisePad do Professor Otavio Lemos desenvolvido em PHP seguindo os principios da Arquiteura Limpa.

O projeto foi desenvolvido utilizando o TDD (Test Driven Development) para realizar testes unitários da aplicação e conceitos de DDD (Domain Driven Design) para fins de estudo e praticar a construção de Api Rest.

# Tecnologia

Foram utilizados as seguintes tecnologias para desenvolvimento:
- PHP 7.2^
- Composer - Gerenciador de dependências 
- PHPUnit - Testes
- Slim Framework - Criação da Api

# Autenticação

O sistema possui autenticação JWT sendo gerado assim que um usuário é cadastrado ou logado.

# Configuração

O arquivo de configuração da aplicação está localizado em: config/config.php, sendo necessário informar o base_path do seu projeto apartir de: var/www/html/caminho-do-seu-projeto

Para a criação das tabelas o script se encontra em: pdo.php

A banco de dados utilizado para desenvolvimento e testes é o database.sqlite

## theWiseDev

Cŕeditos ao livro de Arquitetura Limpa do Professor Otavio Lemos