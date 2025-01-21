<?php
session_start();

// Incluir as funções do carrinho
include "includes/funcao_ver_carrinho.php";

// Verifica o tema preferido no cookie, se existir
if (isset($_COOKIE['tema'])) {
    $tema = $_COOKIE['tema'];
} else {
    // Se não houver o cookie, define um tema padrão (claro)
    $tema = 'claro';
}

// Aplica o estilo baseado no tema
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Carrinho de Compras</title>

    <style>
        @import url('https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,300..800;1,300..800&family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap');
    </style>

    <!-- Carrega os CSSs dependendo do tema -->
    <?php 
    if ($tema == 'claro') { ?>
        <link rel="stylesheet" type="text/css" href="css/carrinho_claro.css">
    <?php } ?>

    <?php 
    if ($tema == 'escuro') { ?>
        <link rel="stylesheet" type="text/css" href="css/carrinho_escuro.css">
    <?php } ?>

</head>
<body>

<?php
include('includes/header.php');
?>

<div class="container">
    <h1>Seu Carrinho</h1> 
    <?php
    if (empty($_SESSION['carrinho'])) {
        echo "<p>Carrinho vazio.</p>";
        ?>
        <a href="adicionar_carrinho.php">Voltar às Compras</a>
        <?php
    } else {
        // Exibe o total do carrinho
        $totalCarrinho = exibirTotalCarrinho();
        foreach ($_SESSION['carrinho'] as $id => $item) {
            // Certifique-se de que a chave existe
            if (isset($item['imagem']) && isset($item['nome']) && isset($item['preco'])) {
                $subtotal = $item['quantidade'] * $item['preco'];
                ?>
                <div class="produto">
                    <img src="<?php echo $item['imagem']; ?>" alt="<?php echo $item['nome']; ?>" />
                    <div class="produto-info">
                        <p><?php echo $item['quantidade']; ?>x <?php echo $item['nome']; ?> - R$ <?php echo $subtotal; ?></p>
                        <a href="?remover=<?php echo $id; ?>">Remover</a>
                    </div>
                </div>
                <?php
            } 
            else {
                echo "<p>Produto com dados inválidos.</p>";
            }
        }
        ?><div class="produto"><a href="?limpar=true">Limpar Carrinho</a>
        <a href="adicionar_carrinho.php">Voltar às Compras</a>
        <p><strong>Total: R$ <?php echo $totalCarrinho; ?></strong></p>
        </div>
    </div>
</div>
<?php
}
?>
</div>

<?php
// Lógica para remover um item do carrinho
if (isset($_GET['remover'])) {
    removerItemCarrinho($_GET['remover']);
    header('Location: ver_carrinho.php');
    exit;
}

// Lógica para limpar o carrinho
if (isset($_GET['limpar']) && $_GET['limpar'] == 'true') {
    limparCarrinho();
    header('Location: ver_carrinho.php');
    exit;
}

// Lógica para alterar o tema via formulário
if (isset($_POST['tema'])) {
    $tema = $_POST['tema'];
    // Atualiza o cookie com o novo valor
    setcookie('tema', $tema, time() + (30 * 24 * 60 * 60), '/');  // Expira em 30 dias
    header("Location: ver_carrinho.php");  // Redireciona para aplicar a alteração
    exit;
}
?>


</body>
</html>
