<?php

namespace App\Helpers;

class CartHelper
{
    protected $session;
    protected $cartKey = 'shopping_cart';

    public function __construct()
    {
        $this->session = session();
    }

    public function add($product, $quantity = 1)
    {
        $cart = $this->session->get($this->cartKey, []);
        
        if (isset($cart[$product->id])) {
            $cart[$product->id]['quantity'] += $quantity;
        } else {
            $cart[$product->id] = [
                'id' => $product->id,
                'name' => $product->name,
                'price' => $product->price,
                'quantity' => $quantity,
                'image' => $product->image ?? null,
                'sku' => $product->sku ?? null,
            ];
        }
        
        $this->session->put($this->cartKey, $cart);
        return $this;
    }

    public function remove($productId)
    {
        $cart = $this->session->get($this->cartKey, []);
        unset($cart[$productId]);
        $this->session->put($this->cartKey, $cart);
        return $this;
    }

    public function update($productId, $quantity)
    {
        $cart = $this->session->get($this->cartKey, []);
        if (isset($cart[$productId])) {
            $cart[$productId]['quantity'] = $quantity;
        }
        $this->session->put($this->cartKey, $cart);
        return $this;
    }

    public function getItems()
    {
        return $this->session->get($this->cartKey, []);
    }

    public function getTotal()
    {
        $total = 0;
        foreach ($this->getItems() as $item) {
            $total += $item['price'] * $item['quantity'];
        }
        return $total;
    }

    public function getCount()
    {
        $count = 0;
        foreach ($this->getItems() as $item) {
            $count += $item['quantity'];
        }
        return $count;
    }

    public function clear()
    {
        $this->session->forget($this->cartKey);
        return $this;
    }

    public function isEmpty()
    {
        return empty($this->getItems());
    }
}