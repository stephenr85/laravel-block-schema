<?php

declare(strict_types=1);

namespace Rushing\BlockSchema\Attributes;

use Rushing\BlockSchema\Blocks\Block;

/**
 * Declares a block's ProseMirror node type. The former `content` expression
 * (`'block*'`/`'inline*'`) was inert — nothing parsed or enforced it — so it was
 * retired; containment is now expressed by category admission on the block itself
 * ({@see Block::admitsChildCategories()}).
 */
#[\Attribute(\Attribute::TARGET_CLASS)]
final class NodeType
{
    public function __construct(
        public readonly string $name,
        public readonly ?string $description = null,
        public readonly string $group = 'block',
    ) {}
}
