<?php

namespace ProductPromotionAlert\Controller;

use ProductPromotionAlert\Model\CustomerProduct;
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
        $id = $request->get("id");
        $customer = $this->getSecurityContext()->getCustomerUser();

        $customerProduct = new CustomerProduct();
        $customerProduct->setCustomerId($customer->getId());
        $customerProduct->setProductId($id);
        $customerProduct->save();

        $product = $customerProduct->getProduct();

        $response = $this->generateRedirect($product->getUrl());

        return $response;
    }
}