<?php

declare(strict_types=1);

namespace Rushing\BlockSchema\Slots\Media;

use Rushing\ProseMirror\Attributes\BlockProp;
use Rushing\ProseMirror\Contracts\MediaSlot;

class PullQuoteSlot implements MediaSlot
{
    public function __construct(
        #[BlockProp(description: 'The pull-quote text. A notable production quote from the grounding context.')]
        public readonly string $quote,

        #[BlockProp(description: 'Attribution — person or source.', required: false)]
        public readonly ?string $attribution = null,
    ) {}

    public function slotType(): string
    {
        return 'pull_quote';
    }

    public function toArray(): array
    {
        return ['slot_type' => $this->slotType(), 'quote' => $this->quote, 'attribution' => $this->attribution];
    }
}
