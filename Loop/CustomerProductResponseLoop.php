<?php

namespace ProductPromotionAlert\Loop;

use ProductPromotionAlert\Model\CustomerProductQuery;
use Propel\Runtime\ActiveQuery\Criteria;
use Thelia\Core\Template\Element\BaseLoop;
use Thelia\Core\Template\Element\LoopResult;
use Thelia\Core\Template\Element\LoopResultRow;
use Thelia\Core\Template\Element\PropelSearchLoopInterface;
use Thelia\Core\Template\Loop\Argument\Argument;
use Thelia\Core\Template\Loop\Argument\ArgumentCollection;

class CustomerProductResponseLoop extends BaseLoop implements PropelSearchLoopInterface
{

    /**
     * @param LoopResult $loopResult
     *
     * @return LoopResult
     */
    public function parseResults(LoopResult $loopResult)
    {
        foreach($loopResult->getResultDataCollection() as $productSubscriber) {
            $loopResultRow = new LoopResultRow($productSubscriber);

            $loopResultRow
                ->set("PRODUCT_ID", $productSubscriber->getProductId())
                ->set("CUSTOMER_ID", $productSubscriber->getCustomerId())
                ->set("CUSTOMER", $productSubscriber->getCustomer())
                ->set("PRODUCT", $productSubscriber->getProduct())
            ;

            $loopResult->addRow($loopResultRow);
        }

        return $loopResult;
    }

    /**
     * Definition of loop arguments
     *
     * example :
     *
     * public function getArgDefinitions()
     * {
     *  return new ArgumentCollection(
     *
     *       Argument::createIntListTypeArgument('id'),
     *           new Argument(
     *           'ref',
     *           new TypeCollection(
     *
     *               new Type\AlphaNumStringListType()
     *           )
     *       ),
     *       Argument::createIntListTypeArgument('category'),
     *       Argument::createBooleanTypeArgument('new'),
     *       ...
     *   );
     * }
     *
     * @return \Thelia\Core\Template\Loop\Argument\ArgumentCollection
     */
    protected function getArgDefinitions()
    {
        return new ArgumentCollection(
            Argument::createIntListTypeArgument('product_id'),
            Argument::createIntListTypeArgument('customer_id')
        );
    }

    /**
     * this method returns a Propel ModelCriteria
     *
     * @return \Propel\Runtime\ActiveQuery\ModelCriteria
     */
    public function buildModelCriteria()
    {
        $search = CustomerProductQuery::create();

        if (null !== $id = $this->getProductId()) {
            $search->filterByProductId($id, Criteria::IN);
        }

        if (null !== $id = $this->getCustomerId()) {
            $search->filterByCustomerId($id, Criteria::IN);
        }

        return $search;
    }
}