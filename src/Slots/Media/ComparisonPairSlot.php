<?php

declare(strict_types=1);

namespace Rushing\BlockSchema\Slots\Media;

use Rushing\ProseMirror\Attributes\BlockProp;
use Rushing\ProseMirror\Contracts\MediaSlot;

class ComparisonPairSlot implements MediaSlot
{
    public function __construct(
        #[BlockProp(description: 'URL of the real-world location image.')]
        public readonly string $realUrl,

        #[BlockProp(description: 'Alt text for the real-world image.')]
        public readonly string $realAlt,

        #[BlockProp(description: 'URL of the on-screen / film still image.')]
        public readonly string $screenUrl,

        #[BlockProp(description: 'Alt text for the on-screen image.')]
        public readonly string $screenAlt,
    ) {}

    public function slotType(): string
    {
        return 'comparison_pair';
    }

    public function toArray(): array
    {
        return [
            'slot_type' => $this->slotType(),
            'real_url' => $this->realUrl,
            'real_alt' => $this->realAlt,
            'screen_url' => $this->screenUrl,
            'screen_alt' => $this->screenAlt,
        ];
    }
}
