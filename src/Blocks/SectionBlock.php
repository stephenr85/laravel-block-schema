<?php

declare(strict_types=1);

namespace Rushing\BlockSchema\Blocks;

use Rushing\ProseMirror\Attributes\BlockProp;
use Rushing\ProseMirror\Attributes\BlockType;
use Rushing\ProseMirror\Contracts\MediaSlot;
use Rushing\ProseMirror\Contracts\ProductSlot;
use Spatie\LaravelData\DataCollection;

#[BlockType('section', 'A body section with a heading, prose, and optional media/product slots.')]
class SectionBlock extends SpatieBlock
{
    /**
     * @param list<MediaSlot|ProductSlot> $slots
     */
    public function __construct(
        #[BlockProp(description: 'Section heading (rendered as <h2>). Name the specific entity — location, character, etc.', example: 'Castle Doune — Winterfell in Scotland')]
        public readonly string $heading,

        #[BlockProp(description: 'Section prose as an HTML string. At least 300 words. Write from grounding context only.')]
        public readonly string $prose,

        #[BlockProp(description: 'Ordered list of media and product slots to embed in this section. Each slot is placed by the Block Compile Step.', required: false)]
        public readonly array $slots = [],
    ) {}
}
