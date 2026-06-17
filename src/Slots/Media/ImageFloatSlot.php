<?php

declare(strict_types=1);

namespace Rushing\BlockSchema\Slots\Media;

use Rushing\ProseMirror\Attributes\BlockProp;
use Rushing\ProseMirror\Contracts\MediaSlot;

class ImageFloatSlot implements MediaSlot
{
    public function __construct(
        #[BlockProp(description: 'Image URL from the available location images list.')]
        public readonly string $url,

        #[BlockProp(description: 'Alt text describing the location.')]
        public readonly string $alt,

        #[BlockProp(description: 'Float side — compiler auto-alternates sequential instances.', example: 'right', required: false)]
        public readonly ?string $side = null,
    ) {}

    public function slotType(): string
    {
        return 'image_float';
    }

    public function toArray(): array
    {
        return ['slot_type' => $this->slotType(), 'url' => $this->url, 'alt' => $this->alt, 'side' => $this->side];
    }
}
