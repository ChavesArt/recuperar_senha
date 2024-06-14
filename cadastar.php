<?php

require_once "conexao.php";

$conexao = conectar();

$nome =  $_POST['nome'];
$email = $_POST['email'];
$senha = $_POST['senha'];

//FAZER armazenar a senha de modo seguro
$sql = "INSERT INTO usuario (nome,email,senha) values ('$nome','$email','$senha')";

$resultado = mysqli_query($conexao,$sql);
?>