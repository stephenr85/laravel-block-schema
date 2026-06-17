<?php

declare(strict_types=1);

namespace Rushing\BlockSchema\Contracts;

interface Node
{
    public function type(): string;

    /** @return array<string, mixed> */
    public function attrs(): array;

    /** @return array<string, mixed> ProseMirror-format node array */
    public function toArray(): array;
}
