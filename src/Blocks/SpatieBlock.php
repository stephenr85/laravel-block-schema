<?php

declare(strict_types=1);

namespace Rushing\BlockSchema\Blocks;

use Rushing\ProseMirror\Attributes\BlockType;
use Rushing\ProseMirror\Contracts\BlockNode;
use Spatie\LaravelData\Data;

abstract class SpatieBlock extends Data implements BlockNode
{
    public function type(): string
    {
        $attrs = (new \ReflectionClass(static::class))->getAttributes(BlockType::class);

        if (empty($attrs)) {
            throw new \LogicException(static::class.' must have a #[BlockType] attribute.');
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
