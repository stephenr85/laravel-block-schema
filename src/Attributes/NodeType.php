<?php

declare(strict_types=1);

namespace Rushing\BlockSchema\Attributes;

#[\Attribute(\Attribute::TARGET_CLASS)]
final class NodeType
{
    public function __construct(
        public readonly string $name,
        public readonly ?string $description = null,
        public readonly string $group = 'block',
        public readonly string $content = 'inline*',
    ) {}
}
