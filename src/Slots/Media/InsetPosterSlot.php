<?php

declare(strict_types=1);

namespace Rushing\BlockSchema\Slots\Media;

use Rushing\ProseMirror\Attributes\BlockProp;
use Rushing\ProseMirror\Contracts\MediaSlot;

class InsetPosterSlot implements MediaSlot
{
    public function __construct(
        #[BlockProp(description: 'Movie or TV slug for the poster.', example: 'game-of-thrones')]
        public readonly string $slug,

        #[BlockProp(description: 'Whether to float left or right.', example: 'right')]
        public readonly string $side = 'right',
    ) {}

    public function slotType(): string
    {
        return 'inset_poster';
    }

    public function toArray(): array
    {
        return ['slot_type' => $this->slotType(), 'slug' => $this->slug, 'side' => $this->side];
    }
}
