<?php

declare(strict_types=1);

namespace Rushing\BlockSchema\Blocks;

use Rushing\ProseMirror\Attributes\BlockProp;
use Rushing\ProseMirror\Attributes\BlockType;
use Rushing\ProseMirror\Contracts\MediaSlot;
use Rushing\ProseMirror\Contracts\ProductSlot;

#[BlockType('conclusion', '1–2 paragraph conclusion with the strongest available affiliate CTA.')]
class ConclusionBlock extends SpatieBlock
{
    public function __construct(
        #[BlockProp(description: 'Conclusion prose as an HTML string.')]
        public readonly string $prose,

        #[BlockProp(description: 'Optional single CTA slot (Expedia teaser or Amazon grid).', required: false)]
        public readonly MediaSlot|ProductSlot|null $ctaSlot = null,
    ) {}
}
