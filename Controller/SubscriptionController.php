<?php

namespace ProductPromotionAlert\Controller;

use Thelia\Controller\Front\BaseFrontController;
use Thelia\Model\Product;

class SubscriptionController extends BaseFrontController
{
    /**
     *
     */
    public function createSubscription()
    {
        $request = $this->getRequest();
        print_r($request->get("id"));

        Product::
    }
}