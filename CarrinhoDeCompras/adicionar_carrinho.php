<?php
session_start();
include 'includes/funcao_adicionar_carrinho.php';

$mensagemSucesso = obterMensagemSucesso();
$produtoAdicionado = obterProdutoAdicionado();
$tema = isset($_SESSION['tema']) ? $_SESSION['tema'] : 'claro';

// Inicializando os produtos
inicializarProdutos();

// Lógica para adicionar ao carrinho
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['adicionar']) && isset($_POST['quantidade'])) {
    $idProduto = $_POST['adicionar'];
    $quantidade = (int)$_POST['quantidade'];
    adicionarAoCarrinho($idProduto, $quantidade);

    // Atualiza o cookie com os dados do carrinho
    atualizarCarrinhoCookie();

    // Redireciona para evitar envio duplo
    header("Location: " . $_SERVER['PHP_SELF']);
    exit();
}

function atualizarCarrinhoCookie() {
    $carrinho = isset($_COOKIE['carrinho']) ? $_COOKIE['carrinho'] : '';

    // Adiciona o novo item no formato 'ID_PRODUTO,QUANTIDADE'
    $item = $_SESSION['carrinho'][key($_SESSION['carrinho'])]; // Pega o último item adicionado
    $novoItem = $item['idProduto'] . ',' . $item['quantidade'];

    if ($carrinho) {
        // Se já existirem produtos, adiciona o novo item ao final da string
        $carrinho .= ';' . $novoItem;
    } else {
        // Se não existir nenhum produto, cria a string com o novo item
        $carrinho = $novoItem;
    }

    // Salva o carrinho atualizado no cookie por 30 dias
    setcookie('carrinho', $carrinho, time() + 30 * 24 * 60 * 60, '/');
}

?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Site de Compras</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <?php if ($tema === 'claro'): ?>
        <link rel="stylesheet" type="text/css" href="css/catalogo_claro.css">
    <?php else: ?>
        <link rel="stylesheet" type="text/css" href="css/catalogo_escuro.css">
    <?php endif; ?>
</head>
<body>

<header>
    <a href="painel_login.php" class="login-icone" title="Login"><i class="fa-solid fa-user"></i></a>
    <a href="ver_carrinho.php" class="carrinho-icone" title="Carrinho de Compras"><i class="fa-solid fa-cart-shopping"></i></a>
</header>

<h2>Produtos Disponíveis</h2>

<div class="produtos-container">
    <?php foreach ($_SESSION['produtos'] as $key => $produto): ?>
        <div class="produto">
            <img src="<?php echo $produto['imagem']; ?>" alt="<?php echo $produto['Nome']; ?>">
            <p><?php echo $produto['Nome']; ?></p>
            <p>Preço: R$ <?php echo $produto['Preço']; ?></p>
            <p>Estoque: <?php echo $produto['Quantidade']; ?></p>

            <!-- Mensagem de sucesso ou erro para o produto específico -->
            <?php if ($key === $produtoAdicionado): ?>
                <p class="mensagem-sucesso"><?php echo $mensagemSucesso; ?></p>
            <?php endif; ?>

            <form method="post" action="">
                <input type="hidden" name="adicionar" value="<?php echo $key; ?>">
                <label for="quantidade-<?php echo $key; ?>">Quantidade:</label>
                <input id="quantidade-<?php echo $key; ?>" type="number" name="quantidade" min="1" max="<?php echo $produto['Quantidade']; ?>" required>
                <button type="submit">Adicionar ao carrinho</button>
            </form>
        </div>
    <?php endforeach; ?>
</div>

</body>
</html>
