<?php

//USAR sessão
$email = $_POST['email'];
$senha = $_POST['senha'];

require_once "conexao.php";
$conexao = conectar();

$sql = "SELECT * FROM  usuario WHERE email = '$email'";
$resultado = mysqli_query($conexao,$sql);

?>