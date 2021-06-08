# api-backend
API Back-end: Manutenção de Usuário

# Sobre o Desafio
O Desafio escolhido foi o de back-end em PHP Nativo e seguindo as orientações abaixo:

1) Logar usando POST: enviar email de acesso e senha. Esté o único endpoint acessível sem estar logado;
2) Consultar perfil com GET: retorna nome, email e URL da imagem do usuário logado;
3) Editar perfil com PUT: altera nome do usuário, email de acesso e senha;
4) Alterar imagem de perfil com POST: altera a imagem do usuário; (dica: content-type não é JSON);
5) Logout com DELETE: invalida a sessão atual.
--
6) Inclusão de conta POST: Adicionar conta de usuário (nome, email, senha);

Todas as alterações devem foram persistidas no banco de dados MySQL.

# Desenvolvimento
Foi utilizado: 
- XAMPP com PHP (v. 7.3.10) em ambiente local;
- Insomnia para comunicação, disparos e testes;
- MySQL Workbench para modelagem das entidades de banco de dados;
- Sequel Pro para conexão com a base de dados para visualização e geração do mesmo e suas entidades;

# Pacote
Nas pastas:
- /db - Artefatos como DE-R e script de importação de base de dados;
- /helpers - Scripts pertinentes a funções efetivas e auxiliares para a(s) aplicação(ções);
- /src  - Está toda API e configuração da mesma;
- /src/upload/ - Somente a(s) pasta(s) e arquivos referentes a improtação de imagens;
- /src/php/ - Script de conexão e configuração para API;
- /src/doc/ - Artefato .json exportado pelo Insomnia com os disparos das verboses;
- /public - Parte do front-end com interface para utilziação (inacabado);



