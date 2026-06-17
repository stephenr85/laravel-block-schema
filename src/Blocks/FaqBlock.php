<?php

declare(strict_types=1);

namespace Rushing\BlockSchema\Blocks;

use Rushing\ProseMirror\Attributes\BlockProp;
use Rushing\ProseMirror\Attributes\BlockType;
use Spatie\LaravelData\DataCollection;

#[BlockType('faq', 'FAQ section. Include only for travel guides, viewing-order, or how-to articles.')]
class FaqBlock extends SpatieBlock
{
    /**
     * @param DataCollection<int, FaqItem> $items
     */
    public function __construct(
        #[BlockProp(description: '3–5 questions written as a reader would search them.')]
        public readonly DataCollection $items,
    ) {}
}
