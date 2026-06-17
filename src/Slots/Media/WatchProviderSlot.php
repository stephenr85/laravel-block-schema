<?php

declare(strict_types=1);

namespace Rushing\BlockSchema\Slots\Media;

use Rushing\ProseMirror\Attributes\BlockProp;
use Rushing\ProseMirror\Contracts\MediaSlot;

class WatchProviderSlot implements MediaSlot
{
    public function __construct(
        #[BlockProp(description: 'The verbatim where-to-watch HTML snippet from the available watch-provider box.')]
        public readonly string $snippet,
    ) {}

    public function slotType(): string
    {
        return 'watch_provider';
    }

    public function toArray(): array
    {
        return ['slot_type' => $this->slotType(), 'snippet' => $this->snippet];
    }
}
