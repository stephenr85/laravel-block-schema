<?php

declare(strict_types=1);

namespace Rushing\BlockSchema\Outline;

use Rushing\ProseMirror\Attributes\BlockProp;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\DataCollection;

class PostOutline extends Data
{
    /**
     * @param DataCollection<int, OutlineSection> $sections
     */
    public function __construct(
        #[BlockProp(description: 'Working article title. Finalised after all sections are written.')]
        public readonly string $title,

        #[BlockProp(description: 'Ordered section plan, primary angle first.')]
        public readonly DataCollection $sections,
    ) {}
}
