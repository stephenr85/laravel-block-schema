<?php

declare(strict_types=1);

namespace Rushing\BlockSchema\Blocks;

use Rushing\ProseMirror\Attributes\BlockProp;
use Rushing\ProseMirror\Attributes\BlockType;

#[BlockType('opening', 'The opening paragraph. No heading, no slots — the article hook.')]
class OpeningBlock extends SpatieBlock
{
    public function __construct(
        #[BlockProp(description: 'Opening prose as an HTML string. Must begin with a plain <p>.', example: '<p>Game of Thrones filmed across ten countries...</p>')]
        public readonly string $prose,
    ) {}
}
