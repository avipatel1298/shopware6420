<?php declare(strict_types=1);

namespace ICTECHQuickViewPopupWithPastPurchasedProduct\Core\Content\Product\Cms;

use Shopware\Core\Checkout\Order\OrderDefinition;
use Shopware\Core\Content\Cms\Aggregate\CmsSlot\CmsSlotEntity;
use Shopware\Core\Content\Cms\DataResolver\CriteriaCollection;
use Shopware\Core\Content\Cms\DataResolver\Element\ElementDataCollection;
use Shopware\Core\Content\Cms\DataResolver\ResolverContext\EntityResolverContext;
use Shopware\Core\Content\Cms\DataResolver\ResolverContext\ResolverContext;
use Shopware\Core\Content\Cms\SalesChannel\Struct\CrossSellingStruct;
use Shopware\Core\Content\Product\Cms\AbstractProductDetailCmsElementResolver;
use Shopware\Core\Content\Product\SalesChannel\CrossSelling\AbstractProductCrossSellingRoute;
use Shopware\Core\Framework\DataAbstractionLayer\Search\Criteria;
use Shopware\Core\Framework\DataAbstractionLayer\Search\Filter\EqualsFilter;
use Shopware\Core\Framework\DataAbstractionLayer\Search\Sorting\FieldSorting;
use Shopware\Core\Framework\Log\Package;
use Symfony\Component\HttpFoundation\Request;
use Shopware\Core\Framework\DataAbstractionLayer\EntityRepositoryInterface;

#[Package('inventory')]
class IctechUserBoughtProductsSliderCmsElementResolver extends AbstractProductDetailCmsElementResolver
{
    private const STATIC_SEARCH_KEY = 'ictech-user-bought-products-slider';


    private EntityRepositoryInterface $orderCustomerRepository;


    /**
     * @internal
     */
    public function __construct(EntityRepositoryInterface $orderCustomerRepository)
    {
        $this->orderCustomerRepository = $orderCustomerRepository;
    }

    public function getType(): string
    {
        return 'ictech-user-bought-products-slider';
    }

    public function collect(CmsSlotEntity $slot, ResolverContext $resolverContext): ?CriteriaCollection
    {
        $config = $slot->getFieldConfig();
        $collection = new CriteriaCollection();

        $criteria = new Criteria();
        $criteria->addAssociation('orderCustomer');
        $collection->add(self::STATIC_SEARCH_KEY . '_' . $slot->getUniqueIdentifier(), OrderDefinition::class, $criteria);


//dd($collection);
        return $collection->all() ? $collection : null;
    }

    public function enrich(CmsSlotEntity $slot, ResolverContext $resolverContext, ElementDataCollection $result): void
    {
        $config = $slot->getFieldConfig();
//        dd( $resolverContext->getSalesChannelContext()->getCustomer());
        $customerId = $resolverContext->getSalesChannelContext()->getCustomer();
        $context = $resolverContext->getSalesChannelContext()->getContext();
        $criteria = new Criteria();

        if ($customerId !== null) {
            $criteria->addFilter((new EqualsFilter('customerId', $customerId->getId())));
            $criteria->addAssociation('order.lineItems.product');
            $orders = $this->orderCustomerRepository->search($criteria, $context);

//            dd($orders);
            $slot->setData($orders);
        }

    }
}

