<?php

namespace Models;

class Cart extends Database {
    public function __construct() {
        if (!isset($_SESSION['cart'])) {
            $_SESSION['cart'] = [];
        }
    }

    public function addProduct($idProduct, $quantity) {
        // Vérification si le produit est déjà dans le panier
        if (isset($_SESSION['cart'][$idProduct])) {
            $_SESSION['cart'][$idProduct] += $quantity;
        } else {
            $_SESSION['cart'][$idProduct] = $quantity;
        }
    }

    public function setQuantity($idProduct, $quantity) {
        // Modifier la quantité du produit dans le panier
        if (isset($_SESSION['cart'][$idProduct])) {
            $_SESSION['cart'][$idProduct] = $quantity;
        }
    }

    public function deleteProduct($idProduct) {
        // Supprimer le produit du panier
        unset($_SESSION['cart'][$idProduct]);
    }

    public function getCart() {
        // Retourner le contenu du panier
        return $_SESSION['cart'];
    }

    public function emptyCart() {
        // Vider le panier
        $_SESSION['cart'] = [];
    }

    public function getNumberOfProducts() {
        // Calculer le nombre total de produits dans le panier
        return array_sum($_SESSION['cart']);
    }
}
?>
