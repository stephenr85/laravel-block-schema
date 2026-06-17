<?php

declare(strict_types=1);

use Rushing\BlockSchema\Compiler\PostBlockCompiler;
use Rushing\BlockSchema\Slots\Product\AmazonGridSlot;
use Rushing\ProseMirror\Schema\GenerationBlock;
use Rushing\ProseMirror\Schema\GenerationDocument;

it('compiles a GenerationDocument to a ProseMirrorDocument', function () {
    $doc = new GenerationDocument(
        title: 'Test Article',
        excerpt: 'A test.',
        blocks: [
            new GenerationBlock(type: 'opening', prose: '<p>Opening prose.</p>'),
            new GenerationBlock(type: 'section', prose: '<p>Section prose.</p>', heading: 'A Section'),
        ],
    );

    $compiler = new PostBlockCompiler;
    $document = $compiler->compile($doc);

    expect($document->content())->toHaveCount(2)
        ->and($document->toArray()['type'])->toBe('doc');
});

it('applies correct row-cols class based on amazon grid item count', function () {
    $compiler = new PostBlockCompiler;

    $doc = new GenerationDocument(
        title: 'Test',
        excerpt: 'Test.',
        blocks: [
            new GenerationBlock(
                type: 'section',
                prose: '<p>Shop section.</p>',
                heading: 'Shop',
                slots: [new AmazonGridSlot(asins: ['B001', 'B002'])],
            ),
        ],
    );

    $html = $compiler->toHtml($compiler->compile($doc));

    expect($html)->toContain('row-cols-2')
        ->and($html)->toContain('asins="B001,B002"');
});

it('alternates image float sides for sequential ImageFloatSlots', function () {
    $compiler = new PostBlockCompiler;

    $doc = new GenerationDocument(
        title: 'Test',
        excerpt: 'Test.',
        blocks: [
            new GenerationBlock(
                type: 'section',
                prose: '<p>Prose.</p>',
                heading: 'Locations',
                slots: [
                    new \Rushing\BlockSchema\Slots\Media\ImageFloatSlot(url: 'https://example.com/a.jpg', alt: 'Location A'),
                    new \Rushing\BlockSchema\Slots\Media\ImageFloatSlot(url: 'https://example.com/b.jpg', alt: 'Location B'),
                ],
            ),
        ],
    );

    $html = $compiler->toHtml($compiler->compile($doc));

    expect($html)->toContain('float-md-end')
        ->and($html)->toContain('float-md-start');
});
