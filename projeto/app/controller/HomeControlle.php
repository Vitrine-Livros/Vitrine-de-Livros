<?php

require_once(__DIR__ . "/Controller.php");

class HomeController extends Controller {

          public function __construct() {
                    //Testa se o usuário está ligado
                    if(! $this->usuarioLogado()) {
                              exit;
                    }

                    echo "HomeController acessado!";
          }

          protected function home() {
                    echo "Executou a action home!";

          }
}

//Criar o objetivo da classe HomeController
new HomeController();