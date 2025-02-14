<?php
#Nome do arquivo: config.php
#Objetivo: define constantes para serem utilizadas no projeto



//Banco de dados: conexão MySQL
define('DB_HOST', 'localhost');
define('DB_NAME', 'vitrine_livros');
define('DB_USER', 'root');
define('DB_PASSWORD', '');

//Caminho para adionar imagens, scripts e chamar páginas no sistema
//Deve ter o nome da pasta do projeto no servidor APACHE
define('BASEURL', '/Vitrine-de-Livros/projeto/app');

//Nome do sistema
define('APP_NAME', 'Vitrine de Livros');

//Página de logout do sistema
define('LOGIN_PAGE', BASEURL . '/controller/LoginController.php?action=login');

//Página de login do sistema
define('LOGOUT_PAGE', BASEURL . '/controller/LoginController.php?action=logout');

//Página home do sistema
define('HOME_PAGE', BASEURL . '/controller/HomeController.php?action=home');

//Sessão do usuário
define('SESSAO_USUARIO_ID', "usuarioLogadoId");
define('SESSAO_USUARIO_NOME', "usuarioLogadoNome");
define('SESSAO_USUARIO_EMAIL', "usuarioLogadoEmail");
define('SESSAO_USUARIO_TIPO', "usuarioLogadoTipo");

//Configurações de arquivos
define("PATH_ARQUIVOS", __DIR__ . "/../../arquivos");
define("URL_ARQUIVOS", BASEURL . "/../arquivos");

//C:\xampp\htdocs\Vitrine-de-Livros\projeto\app\util\config.php




