<?php declare(strict_types=1);

namespace ICTECHQuickViewPopupWithPastPurchasedProduct\Core\Content\Product\Cms;

use Shopware\Core\Checkout\Order\OrderDefinition;
use Shopware\Core\Content\Cms\Aggregate\CmsSlot\CmsSlotEntity;
use Shopware\Core\Content\Cms\DataResolver\CriteriaCollection;
use Shopware\Core\Content\Cms\DataResolver\Element\ElementDataCollection;
use Shopware\Core\Content\Cms\DataResolver\ResolverContext\ResolverContext;
use Shopware\Core\Content\Product\Cms\AbstractProductDetailCmsElementResolver;
use Shopware\Core\Framework\DataAbstractionLayer\Search\Criteria;
use Shopware\Core\Framework\DataAbstractionLayer\Search\Filter\EqualsFilter;
use Shopware\Core\Framework\Log\Package;
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

        return $collection->all() ? $collection : null;
    }

    public function enrich(CmsSlotEntity $slot, ResolverContext $resolverContext, ElementDataCollection $result): void
    {
        $config = $slot->getFieldConfig();
        $slot->setFieldConfig($config);
        $customer = $resolverContext->getSalesChannelContext()->getCustomer();
        $context = $resolverContext->getSalesChannelContext()->getContext();
        $criteria = new Criteria();

        if ($customer !== null) {
            $criteria->addFilter((new EqualsFilter('customerId', $customer->getId())));
            $criteria->addAssociation('order');
            $criteria->addAssociation('order.lineItems.product.prices');
            $criteria->addAssociation('order.lineItems.product.cover');

            $orders = $this->orderCustomerRepository->search($criteria, $context);
//            dd($orders);
            $slot->setData($orders);
        }

    }
}

