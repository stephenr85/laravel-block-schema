<?php

declare(strict_types=1);

namespace Rushing\BlockSchema\Blocks;

use Rushing\BlockSchema\Attributes\NodeType;
use Rushing\BlockSchema\Contracts\Node;
use Spatie\LaravelData\Data;

abstract class Block extends Data implements Node
{
    public function type(): string
    {
        $attrs = (new \ReflectionClass(static::class))->getAttributes(NodeType::class);

        if (empty($attrs)) {
            throw new \LogicException(static::class.' must have a #[NodeType] attribute.');
        }

        return $attrs[0]->newInstance()->name;
    }

    public function attrs(): array
    {
        return $this->toArray();
    }

    public function toArray(): array
    {
        return parent::toArray();
    }

    /** @return array<string, mixed> */
    public function toProseMirrorArray(): array
    {
        return [
            'type' => $this->type(),
            'attrs' => $this->attrs(),
        ];
    }
}
