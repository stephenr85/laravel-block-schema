<?php

declare(strict_types=1);

namespace Rushing\BlockSchema\Attributes;

#[\Attribute(\Attribute::TARGET_PARAMETER | \Attribute::TARGET_PROPERTY)]
final class NodeAttr
{
    public function __construct(
        public readonly ?string $description = null,
        public readonly mixed $example = null,
        public readonly bool $required = true,
        public readonly mixed $default = null,
    ) {}
}
