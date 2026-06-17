<?php

declare(strict_types=1);

namespace Rushing\BlockSchema\Slots\Product;

use Rushing\ProseMirror\Attributes\BlockProp;
use Rushing\ProseMirror\Contracts\ProductSlot;

class AmazonGridSlot implements ProductSlot
{
    /**
     * @param list<string> $asins
     */
    public function __construct(
        #[BlockProp(description: 'List of ASINs from the available Amazon ASINs. 2–5 items. Compiler sets row-cols by count.')]
        public readonly array $asins,
    ) {}

    public function slotType(): string
    {
        return 'amazon_grid';
    }

    public function toArray(): array
    {
        return ['slot_type' => $this->slotType(), 'asins' => $this->asins];
    }
}
