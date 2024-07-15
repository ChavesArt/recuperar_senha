<?php

$email = $_POST['email'];
$token = $_POST['token'];
$senha = $_POST['senha'];
$repSenha = $_POST['repetirSenha'];


require_once 'conexao.php';
$conexao = conectar();
$sql = "SELECT * FROM recuperar_senha WHERE email = '$email' AND token='$token'";
$resultado = executarSql($conexao, $sql);
$recuperar = mysqli_fetch_assoc($resultado);
if ($resultado == null) {
    die("Email ou token incorreto.Tente fazer um novo pedido de recuperação de senha");
} else {
    // verificar a validade do pedido (data_criacao)
    //verificar se o link foi usado ou não
    date_default_timezone_set('America/Sao_Paulo');
    $agora = new DateTime('now');
    $data_criacao = DateTime::createFromFormat('Y-m-d H:i:s', $recuperar['data_criacao']);
    $umDia = DateInterval::createFromDateString('1 day');
    $dataExpiracao = date_add($data_criacao, $umDia);
}
if ($agora > $dataExpiracao) {
    echo "Essa solicitação de recuperação de senha expirou!
    Faça um novo pedido de recuperação de senha.";
    die();
}

if ($recuperar['usado'] == 1) {
    echo "Esse pedido de recuperação de senha já foi utilizado 
    anteriormente! para recuperar a senha façã um novo pedido 
    de recuperação de senha.";
    die();
}
if ($senha != $repSenha) {
    echo "A senha que você digitou é diferente da senha que você digitou no recuperar senha.Por favor tente novamente!";
    die();
}

$sl2 = "UPDATE  usuario SET senha = '$senha' WHERE email = '$email'";

executarSql($conexao,$sql2);
$sql3= "UPDATE  recuperar_senha SET usado = 1 WHERE email = '$email' AND token='$token'";

executarSql($conexao,$sql3);

echo"Nova senha cadastrada com sucesso! Faça login para acessar o programa";



?>