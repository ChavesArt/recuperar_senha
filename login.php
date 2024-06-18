<?php

//USAR sessão
$email = $_POST['email'];
$senha = $_POST['senha'];

require_once "conexao.php";
$conexao = conectar();

$sql = "SELECT * FROM  usuario WHERE email = '$email'";

$resultado = executarSql($conexao,$sql);

$usuario = mysqli_fetch_assoc($resultado);

if ($usuario == null) {

    echo " Email não existe no sistema! Por favor,primeiro realize ";
}

if ($senha == $usuario['senha']) {
    header("Location:principal.php");
} else {

    echo "Email ou senha inválida! Tente novamente.";
}
