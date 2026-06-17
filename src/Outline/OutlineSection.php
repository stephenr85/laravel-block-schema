<?php

declare(strict_types=1);

namespace Rushing\BlockSchema\Outline;

use Rushing\ProseMirror\Attributes\BlockProp;
use Spatie\LaravelData\Data;

class OutlineSection extends Data
{
    public function __construct(
        #[BlockProp(description: 'Section heading — name the specific entity (location, character, etc.).', example: 'Castle Doune — Winterfell in Scotland')]
        public readonly string $heading,

        #[BlockProp(description: 'The post angle driving this section.', example: 'travel')]
        public readonly string $angle,

        #[BlockProp(description: 'What to emphasise from the grounding context when writing this section.')]
        public readonly string $groundingHint,

        #[BlockProp(description: 'Suggested primary slot type for this section — the lead media or product treatment.', required: false, example: 'image_float')]
        public readonly ?string $primarySlotType = null,
    ) {}
}
