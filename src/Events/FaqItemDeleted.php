<?php

namespace Modules\Faq\Events;

use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class FaqItemDeleted {

    use Dispatchable, SerializesModels;

    public int $itemId;

    public function __construct(int $itemId) {
        $this->itemId = $itemId;
    }

}
