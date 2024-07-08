<?php

//verificar o email
//verificar o togen
$email = $_GET['email'];
$token = $_GET['token'];

require_once 'conexao.php';
$conexao = conectar();
$sql = "SELECT * FROM recuperar_senha WHERE email = '$email' AND token='$token'";
$resultado = executarSql($conexao,$sql);
$recuperar = mysqli_fetch_assoc($resultado);
if($resultado == null){
    die("Email ou token incorreto.Tente fazer um novo pedido de recuperação de senha");
}else{
    // verificar a validade do pedido (data_criacao)
    //verificar se o link foi usado ou não
    date_default_timezone_set('America/Sao_Paulo');
    $data = new DateTime('now');
    $data_criacao =DateTime::createFromFormat('Y-m-d H:i:s',$recuperar['data_criacao']);
    $umDia = DateInterval::createFromDateString('1 day');
    $dataExpiracao = date_add($data_criacao,$umDia);
}
?>