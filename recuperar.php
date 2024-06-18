<?php
require_once "conexao.php";
$email = $_POST['email'];
$conexao = conectar();
$sql = "SELECT *FROM   usuario  WHERE  email ='$email'";

$resultado = executarSql($conexao, $sql);

$usuario = mysqli_fetch_assoc($resultado);
if ($usuario == null) {
    echo "Email não cadastrado! Faça o cadastro e em seguida o login.";
    die();
}
//gerar um tokien único 
$token = bin2hex(random_bytes(50));
