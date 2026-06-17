<?php

declare(strict_types=1);

namespace Rushing\BlockSchema\Blocks;

use Rushing\ProseMirror\Attributes\BlockProp;
use Spatie\LaravelData\Data;

class FaqItem extends Data
{
    public function __construct(
        #[BlockProp(description: 'Question written exactly as a reader would search it.', example: 'Where was Game of Thrones filmed in Scotland?')]
        public readonly string $question,

        #[BlockProp(description: 'Concise, factual answer drawn from grounding context only.')]
        public readonly string $answer,
    ) {}
}
