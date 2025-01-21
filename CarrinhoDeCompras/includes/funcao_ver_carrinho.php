<?php
// Função para remover um item do carrinho e atualizar o estoque
function removerItemCarrinho($id) {
    // Verifica se o item existe no carrinho
    if (isset($_SESSION['carrinho'][$id])) {
        // Se o item tem mais de uma unidade, diminui a quantidade
        if ($_SESSION['carrinho'][$id]['quantidade'] > 1) {
            $_SESSION['carrinho'][$id]['quantidade']--;
            $_SESSION['produtos'][$id]['Quantidade']++; // Aumenta o estoque
        } else {
            // Caso a quantidade seja 1, remove o item do carrinho
            unset($_SESSION['carrinho'][$id]);
            $_SESSION['produtos'][$id]['Quantidade']++; // Aumenta o estoque
        }
    }
}


// Função para limpar o carrinho e atualizar o estoque

// Função para limpar o carrinho e atualizar o estoque
function limparCarrinho() {
    if (isset($_SESSION['carrinho'])) {
        foreach ($_SESSION['carrinho'] as $id => $item) {
            // Retorna a quantidade de volta ao estoque
            if (isset($_SESSION['produtos'][$id])) {
                $_SESSION['produtos'][$id]['Quantidade'] += $item['quantidade'];
            }
        }
        unset($_SESSION['carrinho']);  
    }
}

// Função para calcular e exibir o total do carrinho
function exibirTotalCarrinho() {
    $totalCarrinho = 0;
    foreach ($_SESSION['carrinho'] as $item) {
        $totalCarrinho += $item['quantidade'] * $item['preco'];
    }
    return $totalCarrinho;
}
?>
