<?php

declare(strict_types=1);

namespace Rushing\BlockSchema\Slots\Product;

use Rushing\ProseMirror\Attributes\BlockProp;
use Rushing\ProseMirror\Contracts\ProductSlot;

class AmazonItemSlot implements ProductSlot
{
    public function __construct(
        #[BlockProp(description: 'ASIN from the available Amazon ASINs list. Single product, inset beside prose.')]
        public readonly string $asin,
    ) {}

    public function slotType(): string
    {
        return 'amazon_item';
    }

    public function toArray(): array
    {
        return ['slot_type' => $this->slotType(), 'asin' => $this->asin];
    }
}
