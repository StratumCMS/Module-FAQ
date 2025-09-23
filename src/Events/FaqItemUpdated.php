<?php

namespace Modules\Faq\Events;

use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Modules\Faq\Models\FaqItem;

class FaqItemUpdated {

    use Dispatchable, SerializesModels;

    public FaqItem $item;

    public function __construct(FaqItem $item) {
        $this->item = $item;
    }

}
