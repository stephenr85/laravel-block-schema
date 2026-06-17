<?php

declare(strict_types=1);

namespace Rushing\BlockSchema\Slots\Media;

use Rushing\ProseMirror\Attributes\BlockProp;
use Rushing\ProseMirror\Contracts\MediaSlot;

class ExpediaInlineSlot implements MediaSlot
{
    public function __construct(
        #[BlockProp(description: 'Full Expedia URL. Renders as a styled inline button with offcanvas panel.')]
        public readonly string $url,

        #[BlockProp(description: 'Link label shown to the reader.', example: 'Edinburgh')]
        public readonly string $label,
    ) {}

    public function slotType(): string
    {
        return 'expedia_inline';
    }

    public function toArray(): array
    {
        return ['slot_type' => $this->slotType(), 'url' => $this->url, 'label' => $this->label];
    }
}
