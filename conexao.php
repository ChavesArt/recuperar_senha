<?php

/**
 * faz uma conexão com o bando de dados MySQL, na base de dados recuperar-senha
 * 
 * @return retorna uma conexão com a base de dados, ou em caso de falha, mata a execução e exibe o erro.
 */
function conectar()
{
    $conexao =  mysqli_connect("localhost", "root", "", "esc_senha");

    if ($conexao == false) {
        echo "Erro ao conectar à base de dados. Nº do erro:"
            . mysqli_connect_errno()
            . ". "
            . mysqli_connect_error();
        die();
    }

    return $conexao;
}
