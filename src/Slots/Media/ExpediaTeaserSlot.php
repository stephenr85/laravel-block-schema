<?php

declare(strict_types=1);

namespace Rushing\BlockSchema\Slots\Media;

use Rushing\ProseMirror\Attributes\BlockProp;
use Rushing\ProseMirror\Contracts\MediaSlot;

class ExpediaTeaserSlot implements MediaSlot
{
    public function __construct(
        #[BlockProp(description: 'Full Expedia URL from the available Expedia URLs list.', example: 'https://www.expedia.com/Edinburgh.dx6069845')]
        public readonly string $url,

        #[BlockProp(description: 'Optional title override for the teaser card.', required: false)]
        public readonly ?string $title = null,
    ) {}

    public function slotType(): string
    {
        return 'expedia_teaser';
    }

    public function toArray(): array
    {
        return ['slot_type' => $this->slotType(), 'url' => $this->url, 'title' => $this->title];
    }
}
