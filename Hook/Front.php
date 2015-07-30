<?php

namespace ProductPromotionAlert\Hook;

use Thelia\Core\Event\Hook\HookRenderEvent;
use Thelia\Core\Hook\BaseHook;
use Thelia\Log\Tlog;

class Front extends BaseHook
{
    public function onProductDetailsBottomFromMax(HookRenderEvent $blockEvent)
    {
        $product_id = $blockEvent->getArgument("product");
        $customer = $this->getCustomer();

        if($customer) {
            $html = $this->render("subscribe-action.html",
                ["product_id" => $product_id, "customer_id" => $customer->getId()]);
            $blockEvent->add($html);
        }
    }
}