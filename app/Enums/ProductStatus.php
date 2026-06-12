<?php

namespace App\Enums;

enum ProductStatus: string
{
    case DRAFT = 'draft';
    case PUBLISHED = 'published';
    case OUT_OF_STOCK = 'out_of_stock';
    case DISCONTINUED = 'discontinued';
    
    public function getLabel(): string
    {
        return match($this) {
            self::DRAFT => 'Draft',
            self::PUBLISHED => 'Published',
            self::OUT_OF_STOCK => 'Out of Stock',
            self::DISCONTINUED => 'Discontinued',
        };
    }
    
    public function getColor(): string
    {
        return match($this) {
            self::DRAFT => 'gray',
            self::PUBLISHED => 'success',
            self::OUT_OF_STOCK => 'danger',
            self::DISCONTINUED => 'warning',
        };
    }
}
