<?php

namespace App\Services;

class CartService
{
    protected string $sessionKey = 'cart';

    public function add($product, int $quantity = 1): void
    {
        $cart = session()->get($this->sessionKey, []);
        $id = $product->id;

        if (isset($cart[$id])) {
            $cart[$id]['quantity'] += $quantity;
        } else {
            $cart[$id] = [
                'id'        => $product->id,
                'name'      => $product->name,
                'price'     => $product->price,
                'quantity'  => $quantity,
                'image'     => $product->image_url,
                'image_url' => $product->image_url,
                'slug'      => $product->slug,
            ];
        }

        session()->put($this->sessionKey, $cart);
    }

    public function remove($productId): void
    {
        $cart = session()->get($this->sessionKey, []);
        unset($cart[$productId]);
        session()->put($this->sessionKey, $cart);
    }

    public function update($productId, int $quantity): void
    {
        $cart = session()->get($this->sessionKey, []);
        if (isset($cart[$productId])) {
            $cart[$productId]['quantity'] = max(1, $quantity);
            session()->put($this->sessionKey, $cart);
        }
    }

    public function clear(): void
    {
        session()->forget($this->sessionKey);
    }

    public function getItems(): array
    {
        return session()->get($this->sessionKey, []);
    }

    public function getTotal(): float
    {
        return collect($this->getItems())
            ->sum(fn($item) => $item['price'] * $item['quantity']);
    }

    public function getCount(): int
    {
        return collect($this->getItems())
            ->sum(fn($item) => $item['quantity']);
    }
}