<?php

declare(strict_types=1);

namespace Rushing\BlockSchema\Compiler;

use Rushing\BlockSchema\Slots\Media\ImageFloatSlot;
use Rushing\ProseMirror\Contracts\BlockDocument;
use Rushing\ProseMirror\Contracts\CompilesToDocument;
use Rushing\ProseMirror\Contracts\MediaSlot;
use Rushing\ProseMirror\Contracts\ProductSlot;
use Rushing\ProseMirror\Schema\GenerationBlock;
use Rushing\ProseMirror\Schema\GenerationDocument;
use Rushing\ProseMirror\Schema\ProseMirrorDocument;

class PostBlockCompiler implements CompilesToDocument
{
    public function compile(GenerationDocument $source): BlockDocument
    {
        $nodes = [];
        $floatSide = 'right';

        foreach ($source->blocks as $block) {
            $nodes[] = $this->compileBlock($block, $floatSide);
            $floatSide = $floatSide === 'right' ? 'left' : 'right';
        }

        return new ProseMirrorDocument($nodes);
    }

    public function toHtml(BlockDocument $document): string
    {
        $html = '';

        foreach ($document->content() as $node) {
            $html .= $this->nodeToHtml($node->toArray());
        }

        return $html;
    }

    private function compileBlock(GenerationBlock $block, string &$floatSide): \Rushing\ProseMirror\Contracts\BlockNode
    {
        $slotHtml = $this->compileSlotsToHtml($block->slots, $floatSide);

        return new class($block->type, $block->heading, $block->prose, $slotHtml) implements \Rushing\ProseMirror\Contracts\BlockNode {
            public function __construct(
                private readonly string $blockType,
                private readonly ?string $heading,
                private readonly string $prose,
                private readonly string $slotHtml,
            ) {}

            public function type(): string { return $this->blockType; }

            public function attrs(): array
            {
                return ['heading' => $this->heading, 'slotHtml' => $this->slotHtml];
            }

            public function toArray(): array
            {
                return [
                    'type' => $this->blockType,
                    'attrs' => ['heading' => $this->heading],
                    'content' => [['type' => 'html', 'attrs' => ['html' => $this->slotHtml.$this->prose]]],
                ];
            }
        };
    }

    /** @param list<MediaSlot|ProductSlot> $slots */
    private function compileSlotsToHtml(array $slots, string &$floatSide): string
    {
        $html = '';

        foreach ($slots as $slot) {
            $html .= match ($slot->slotType()) {
                'inset_poster'    => $this->renderInsetPoster($slot->toArray()),
                'image_float'     => $this->renderImageFloat($slot->toArray(), $floatSide),
                'expedia_teaser'  => $this->renderExpediaTeaser($slot->toArray()),
                'expedia_inline'  => $this->renderExpediaInline($slot->toArray()),
                'comparison_pair' => $this->renderComparisonPair($slot->toArray()),
                'pull_quote'      => $this->renderPullQuote($slot->toArray()),
                'watch_provider'  => $slot->toArray()['snippet'],
                'amazon_grid'     => $this->renderAmazonGrid($slot->toArray()),
                'amazon_item'     => $this->renderAmazonItem($slot->toArray()),
                'costumes_teaser' => $this->renderCostumesTeaser($slot->toArray()),
                default           => '',
            };
        }

        return $html;
    }

    /** @param array<string, mixed> $data */
    private function renderInsetPoster(array $data): string
    {
        $side = $data['side'] === 'left' ? 'inset-md-left' : 'inset-md-right';
        $type = str_contains((string) $data['slug'], '-') ? 'tv-poster' : 'movie-poster';

        return "<div class=\"{$side} col-5 col-md-4 col-lg-3\" data-x=\"{$type}\" slug=\"{$data['slug']}\">[poster]</div>";
    }

    /** @param array<string, mixed> $data */
    private function renderImageFloat(array $data, string &$floatSide): string
    {
        $side = $data['side'] ?? $floatSide;
        $floatSide = $side === 'right' ? 'left' : 'right';
        $class = $side === 'left' ? 'float-md-start me-md-4 mb-2' : 'float-md-end ms-md-4 mb-2';

        return "<img class=\"{$class} col-md-4\" src=\"{$data['url']}\" alt=\"{$data['alt']}\">";
    }

    /** @param array<string, mixed> $data */
    private function renderExpediaTeaser(array $data): string
    {
        $title = isset($data['title']) ? " title=\"{$data['title']}\"" : '';

        return "<div class=\"my-4\"><a class=\"ratio-21x9\" data-x=\"expedia.destination-teaser\" href=\"{$data['url']}\"{$title}>[destination-teaser]</a></div>";
    }

    /** @param array<string, mixed> $data */
    private function renderExpediaInline(array $data): string
    {
        return "<a data-x=\"expedia.inline-destination\" href=\"{$data['url']}\">{$data['label']}</a>";
    }

    /** @param array<string, mixed> $data */
    private function renderComparisonPair(array $data): string
    {
        return "<div class=\"my-4 row g-2\"><div class=\"col-5\"><img src=\"{$data['real_url']}\" alt=\"{$data['real_alt']}\"></div><div class=\"col-7\"><img src=\"{$data['screen_url']}\" alt=\"{$data['screen_alt']}\"></div></div>";
    }

    /** @param array<string, mixed> $data */
    private function renderPullQuote(array $data): string
    {
        $attr = $data['attribution'] ? "<cite>{$data['attribution']}</cite>" : '';

        return "<blockquote class=\"callout inset-right\"><p>{$data['quote']}</p>{$attr}</blockquote>";
    }

    /** @param array<string, mixed> $data */
    private function renderAmazonGrid(array $data): string
    {
        $count = count($data['asins']);
        $colClass = match (true) {
            $count <= 2 => 'row-cols-2',
            $count === 4 => 'row-cols-2 row-cols-lg-4',
            default => '',
        };
        $asins = implode(',', $data['asins']);

        return "<div class=\"my-4 {$colClass}\" data-x=\"amazon-items-grid\" asins=\"{$asins}\">[grid]</div>";
    }

    /** @param array<string, mixed> $data */
    private function renderAmazonItem(array $data): string
    {
        return "<div class=\"inset-md-right col-md-4\" data-x=\"amazon-item\" asin=\"{$data['asin']}\">[product]</div>";
    }

    /** @param array<string, mixed> $data */
    private function renderCostumesTeaser(array $data): string
    {
        return "<div data-x=\"costumes-product\" handle=\"{$data['handle']}\">[product]</div>";
    }

    /** @param array<string, mixed> $node */
    private function nodeToHtml(array $node): string
    {
        $heading = $node['attrs']['heading'] ?? null;
        $html = isset($node['content'][0]['attrs']['html']) ? $node['content'][0]['attrs']['html'] : '';
        $output = '';

        if ($heading) {
            $output .= "<h2>{$heading}</h2>";
        }

        $output .= $html;

        return $output;
    }
}
