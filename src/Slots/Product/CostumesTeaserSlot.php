<?php

declare(strict_types=1);

namespace Rushing\BlockSchema\Slots\Product;

use Rushing\ProseMirror\Attributes\BlockProp;
use Rushing\ProseMirror\Contracts\ProductSlot;

class CostumesTeaserSlot implements ProductSlot
{
    public function __construct(
        #[BlockProp(description: 'Product handle from the available Costumes products list.', example: 'khaleesi-dragon-queen-costume')]
        public readonly string $handle,

        #[BlockProp(description: 'Product name for context.')]
        public readonly string $name,
    ) {}

    public function slotType(): string
    {
        return 'costumes_teaser';
    }

    public function toArray(): array
    {
        return ['slot_type' => $this->slotType(), 'handle' => $this->handle, 'name' => $this->name];
    }
}
