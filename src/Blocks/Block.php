<?php

declare(strict_types=1);

namespace Rushing\BlockSchema\Blocks;

use Illuminate\Support\Str;
use Rushing\BlockSchema\Attributes\NodeType;
use Rushing\BlockSchema\Contracts\Node;
use Spatie\LaravelData\Data;

/**
 * A ProseMirror Node implemented as a Spatie Data object. The Data payload holds
 * the node's attributes; `id` and child `content` are managed by this base class
 * (kept out of the payload so Spatie never tries to hydrate polymorphic children).
 */
abstract class Block extends Data implements Node
{
    protected ?string $id = null;

    /** @var list<Node> */
    protected array $children = [];

    public function type(): string
    {
        $attrs = (new \ReflectionClass(static::class))->getAttributes(NodeType::class);

        if (empty($attrs)) {
            throw new \LogicException(static::class.' must have a #[NodeType] attribute.');
        }

        return $attrs[0]->newInstance()->name;
    }

    /**
     * The UUIDv7 node id, stamped lazily on first access and stable thereafter.
     */
    public function id(): string
    {
        return $this->id ??= (string) Str::uuid7();
    }

    /**
     * Set the node id (used by the DocumentHydrator to preserve an incoming id).
     * Passing null leaves it unstamped so it will be generated on next access.
     */
    public function withId(?string $id): static
    {
        $this->id = $id;

        return $this;
    }

    /**
     * @param  list<Node>  $children
     */
    public function withContent(array $children): static
    {
        $this->children = $children;

        return $this;
    }

    /** @return array<string, mixed> */
    public function attrs(): array
    {
        return ['id' => $this->id(), ...parent::toArray()];
    }

    /** @return list<Node> */
    public function content(): array
    {
        return $this->children;
    }

    /** @return array<string, mixed> */
    public function toArray(): array
    {
        $node = [
            'type' => $this->type(),
            'attrs' => $this->attrs(),
        ];

        if ($this->children !== []) {
            $node['content'] = array_map(fn (Node $child): array => $child->toArray(), $this->children);
        }

        return $node;
    }
}
