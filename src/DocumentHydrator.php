<?php

declare(strict_types=1);

namespace Rushing\BlockSchema;

use Rushing\BlockSchema\Blocks\Block;
use Rushing\BlockSchema\Contracts\Document;
use Rushing\BlockSchema\Contracts\Node;
use Rushing\BlockSchema\Contracts\Schema;
use Rushing\BlockSchema\Schema\ProseMirrorDocument;

/**
 * The reverse of Document::toArray(): a recursive tree-walker that turns a
 * ProseMirror doc array back into typed Block Nodes. Spatie Data carries the
 * per-node typed hydration; this class only resolves types and recurses.
 */
final class DocumentHydrator
{
    public function __construct(private readonly Schema $schema) {}

    /**
     * @param  array{type?: string, content?: list<array<string, mixed>>}  $doc
     */
    public function hydrate(array $doc): Document
    {
        $nodes = array_map(
            fn (array $node): Node => $this->hydrateNode($node),
            $doc['content'] ?? [],
        );

        return new ProseMirrorDocument($nodes);
    }

    /**
     * @param  array{type: string, attrs?: array<string, mixed>, content?: list<array<string, mixed>>}  $node
     */
    private function hydrateNode(array $node): Node
    {
        /** @var class-string<Block> $class */
        $class = $this->schema->resolve($node['type']);
        $attrs = $node['attrs'] ?? [];

        /** @var Block $block */
        $block = $class::from($attrs);
        $block->withId($attrs['id'] ?? null);

        $children = array_map(
            fn (array $child): Node => $this->hydrateNode($child),
            $node['content'] ?? [],
        );

        if ($children !== []) {
            $block->withContent($children);
        }

        return $block;
    }
}
