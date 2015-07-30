<?php

namespace ProductPromotionAlert\Action;

use ProductPromotionAlert\Model\CustomerProductQuery;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Thelia\Core\Event\ProductSaleElement\ProductSaleElementCreateEvent;
use Thelia\Core\Event\ProductSaleElement\ProductSaleElementUpdateEvent;
use Thelia\Core\Event\TheliaEvents;
use Thelia\Mailer\MailerFactory;
use Thelia\Model\Customer;
use Thelia\Model\Product;

class SendMailAction implements EventSubscriberInterface
{

    protected $mailer;

    public function __construct(MailerFactory $mailer)
    {
        $this->mailer = $mailer;
    }

    public function onUpdateProductSale(ProductSaleElementUpdateEvent $event)
    {
        if($event->getOnsale() == true) {
            $this->findProductByCustomer($event->getProduct());
        }
    }

    public function onCreateProductSale(ProductSaleElementCreateEvent $event)
    {
        $this->findProductByCustomer($event->getProduct());
    }

    public function findProductByCustomer(Product $product)
    {
        $query = new CustomerProductQuery();

        $result = $query->distinct()->findByProductId($product->getId());

        foreach($result as $customerProduct) {
        $this->sendEmail($customerProduct->getProduct(), $customerProduct->getCustomer());
        }
    }

    public function sendEmail(Product $product, Customer $customer)
    {
        $this->mailer->sendEmailToCustomer(
            'mail_product_promotion_alert',
            $customer,
            [
                'customer_id' => $customer->getId(),
                'customer_firstname' => $customer->getFirstname(),
                'product_title' => $product->getTitle(),
                'product_url' => $product->getUrl()
            ]
        );
    }

    /**
     * Returns an array of event names this subscriber wants to listen to.
     *
     * The array keys are event names and the value can be:
     *
     *  * The method name to call (priority defaults to 0)
     *  * An array composed of the method name to call and the priority
     *  * An array of arrays composed of the method names to call and respective
     *    priorities, or 0 if unset
     *
     * For instance:
     *
     *  * array('eventName' => 'methodName')
     *  * array('eventName' => array('methodName', $priority))
     *  * array('eventName' => array(array('methodName1', $priority), array('methodName2'))
     *
     * @return array The event names to listen to
     *
     * @api
     */
    public static function getSubscribedEvents()
    {
        return array(
            TheliaEvents::PRODUCT_ADD_PRODUCT_SALE_ELEMENT => "onCreateProductSale",
            TheliaEvents::PRODUCT_UPDATE_PRODUCT_SALE_ELEMENT => "onUpdateProductSale"
        );
    }
}