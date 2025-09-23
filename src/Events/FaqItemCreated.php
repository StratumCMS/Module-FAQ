<?php

namespace Modules\Faq\Events;

use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Modules\Faq\Models\FaqItem;

class FaqItemCreated {

    use Dispatchable, SerializesModels;

    public FaqItem $faqItem;

    public function __construct(FaqItem $faqItem) {
        $this->faqItem = $faqItem;
    }

}
