<?php
/*************************************************************************************/
/*      This file is part of the Thelia package.                                     */
/*                                                                                   */
/*      Copyright (c) OpenStudio                                                     */
/*      email : dev@thelia.net                                                       */
/*      web : http://www.thelia.net                                                  */
/*                                                                                   */
/*      For the full copyright and license information, please view the LICENSE.txt  */
/*      file that was distributed with this source code.                             */
/*************************************************************************************/

namespace ProductPromotionAlert;

use Thelia\Model\LangQuery;
use Thelia\Model\Message;
use Thelia\Model\MessageQuery;
use Thelia\Module\BaseModule;
use Propel\Runtime\Connection\ConnectionInterface;
use Thelia\Install\Database;

class ProductPromotionAlert extends BaseModule
{

    public function postActivation(ConnectionInterface $con = null)
    {
        $database = new Database($con);
        $database->insertSql(null, array(__DIR__ . '/Config/thelia.sql'));

        $this->initializeMessage();
    }

    protected function initializeMessage()
    {
        // create new message
        if (null === MessageQuery::create()->findOneByName('mail_product_promotion_alert')) {
            $message = new Message();
            $message
                ->setName('mail_product_promotion_alert')
                ->setHtmlTemplateFileName('mail_product_promotion_alert.html')
                ->setHtmlLayoutFileName('')
                ->setTextTemplateFileName('mail_product_promotion_alert.txt')
                ->setTextLayoutFileName('')
                ->setSecured(0);

            $languages = LangQuery::create()->find();

            foreach ($languages as $language) {
                $locale = $language->getLocale();

                $message->setLocale($locale);
                $message->setSubject('Your product {$order_ref} is promoted.');
                $message->setTitle('Product promotion message');
            }

            $message->save();
        }
    }
}
