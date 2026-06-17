<?php

declare(strict_types=1);

use Rushing\BlockSchema\Contracts\Document;
use Rushing\BlockSchema\DocumentHydrator;
use Rushing\BlockSchema\Schema\NodeSchema;

beforeEach(function () {
    $this->schema = new NodeSchema;
    $this->schema->registerClass(SectionBlockFixture::class);
    $this->hydrator = new DocumentHydrator($this->schema);
});

it('hydrates a doc array into a typed Document of Blocks', function () {
    $doc = [
        'type' => 'doc',
        'content' => [
            ['type' => 'section', 'attrs' => ['id' => 'abc', 'heading' => 'Locations']],
        ],
    ];

    $document = $this->hydrator->hydrate($doc);

    expect($document)->toBeInstanceOf(Document::class);

    $first = $document->content()[0];
    expect($first)->toBeInstanceOf(SectionBlockFixture::class)
        ->and($first->heading)->toBe('Locations')
        ->and($first->id())->toBe('abc');
});

it('hydrates child nodes recursively', function () {
    $doc = [
        'type' => 'doc',
        'content' => [
            [
                'type' => 'section',
                'attrs' => ['id' => 'parent', 'heading' => 'Parent'],
                'content' => [
                    ['type' => 'section', 'attrs' => ['id' => 'child', 'heading' => 'Child']],
                ],
            ],
        ],
    ];

    $document = $this->hydrator->hydrate($doc);

    $parent = $document->content()[0];
    expect($parent->content())->toHaveCount(1)
        ->and($parent->content()[0]->heading)->toBe('Child')
        ->and($parent->content()[0]->id())->toBe('child');
});

it('round-trips a Block through serialize and hydrate preserving id', function () {
    $block = SectionBlockFixture::from(['heading' => 'Locations']);
    $originalId = $block->id();

    $doc = [
        'type' => 'doc',
        'content' => [$block->toArray()],
    ];

    $rehydrated = $this->hydrator->hydrate($doc)->content()[0];

    expect($rehydrated->id())->toBe($originalId)
        ->and($rehydrated->heading)->toBe('Locations');
});

it('throws when resolving an unregistered node type', function () {
    $this->hydrator->hydrate([
        'type' => 'doc',
        'content' => [['type' => 'unknown', 'attrs' => []]],
    ]);
})->throws(InvalidArgumentException::class);
