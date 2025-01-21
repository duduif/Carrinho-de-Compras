<?php
function inicializarProdutos() {
    if (!isset($_SESSION['produtos'])) {
        $_SESSION['produtos'] = [
            'Product1' => ['imagem' => 'images/headset_ps5.png', 'Nome' => "Headset PS5", 'Preço' => 300, 'Quantidade' => 10],
            'Product2' => ['imagem' => 'images/headset_xbox.png', 'Nome' => "Headset Xbox", 'Preço' => 200, 'Quantidade' => 10],
            'Product3' => ['imagem' => 'images/headset_razer.png', 'Nome' => "Headset Razer", 'Preço' => 450, 'Quantidade' => 10],
            'Product4' => ['imagem' => 'images/PS4.png', 'Nome' => "Playstation 4", 'Preço' => 800, 'Quantidade' => 10],
            'Product5' => ['imagem' => 'images/PS5.png', 'Nome' => "Playstation 5", 'Preço' => 1200, 'Quantidade' => 10],
            'Product6' => ['imagem' => 'images/Series_X.png', 'Nome' => "Xbox Series X", 'Preço' => 1500, 'Quantidade' => 10]
        ];
    }
}

function adicionarAoCarrinho($idProduto, $quantidade) {
    if ($quantidade > 0 && $quantidade <= $_SESSION['produtos'][$idProduto]['Quantidade']) {
        if (isset($_SESSION['carrinho'][$idProduto])) {
            $_SESSION['carrinho'][$idProduto]['quantidade'] += $quantidade;
        } else {
            $_SESSION['carrinho'][$idProduto] = [
                'quantidade' => $quantidade,
                'nome' => $_SESSION['produtos'][$idProduto]['Nome'],
                'preco' => $_SESSION['produtos'][$idProduto]['Preço'],
                'imagem' => $_SESSION['produtos'][$idProduto]['imagem']
            ];
        }
        // Atualiza estoque
        $_SESSION['produtos'][$idProduto]['Quantidade'] -= $quantidade;
        $_SESSION['mensagemSucesso'] = "Produto adicionado ao carrinho com sucesso!";
        $_SESSION['produtoAdicionado'] = $idProduto;
    } else {
        $_SESSION['mensagemSucesso'] = "Quantidade inválida ou estoque insuficiente.";
        $_SESSION['produtoAdicionado'] = $idProduto;
    }
}

function obterMensagemSucesso() {
    $mensagemSucesso = isset($_SESSION['mensagemSucesso']) ? $_SESSION['mensagemSucesso'] : '';
    unset($_SESSION['mensagemSucesso']);
    return $mensagemSucesso;
}

function obterProdutoAdicionado() {
    $produtoAdicionado = isset($_SESSION['produtoAdicionado']) ? $_SESSION['produtoAdicionado'] : '';
    unset($_SESSION['produtoAdicionado']);
    return $produtoAdicionado;
}
?>
