<?php
#Nome do arquivo: UsuarioPapel.php
#Objetivo: classe Enum para os papeis de permissões do model de Usuario

class UsuarioTipo {

    public static string $SEPARADOR = "|";

    const ADMINISTRADOR = "ADMINSTRADOR";
    const LEITOR = "LEITOR";

    public static function getAllAsArray() {
        return [UsuarioTipo::ADMINISTRADOR, UsuarioTipo::LEITOR];
    }

}

