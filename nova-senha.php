<?php

//verificar o email
//verificar o togen
$email = $_GET['email'];
$token = $_GET['token'];

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
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nova senha</title>
</head>

<body>
    <input type="hidden" name="email" value="<?= $email; ?>">
    <input type="hidden" name="token" value="<?= $token; ?>">
    <form action="salvar_nova_senha_senha.php" method="post">
        <label for="senha">Senha:</label>
        <input type="text" name="senha" id="senha"> <br>
        <label for="nova">Repita a senha:</label>
        <input type="text" name="repetirSenha" id="nova" > <br>

        <input type="submit" value="Enviar">


    </form>

</body>

</html>