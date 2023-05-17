<?php declare(strict_types=1);

namespace ICTECHQuickViewPopupWithPastPurchasedProduct\Core\Content\Product\Cms;

use Shopware\Core\Content\Cms\Aggregate\CmsSlot\CmsSlotEntity;
use Shopware\Core\Content\Cms\DataResolver\CriteriaCollection;
use Shopware\Core\Content\Cms\DataResolver\Element\ElementDataCollection;
use Shopware\Core\Content\Cms\DataResolver\ResolverContext\ResolverContext;
use Shopware\Core\Content\Product\Cms\AbstractProductDetailCmsElementResolver;
use Shopware\Core\Framework\DataAbstractionLayer\Search\Criteria;
use Shopware\Core\Framework\DataAbstractionLayer\Search\Filter\EqualsAnyFilter;
use Shopware\Core\Framework\DataAbstractionLayer\Search\Filter\EqualsFilter;
use Shopware\Core\Framework\Log\Package;
use Shopware\Core\Framework\DataAbstractionLayer\EntityRepositoryInterface;
use Shopware\Core\System\SalesChannel\Entity\SalesChannelRepositoryInterface;

#[Package('inventory')]
class IctechUserBoughtProductsSliderCmsElementResolver extends AbstractProductDetailCmsElementResolver
{

    private EntityRepositoryInterface $orderCustomerRepository;

    private EntityRepositoryInterface $productRepository;

    private SalesChannelRepositoryInterface $salesChannelRepository;


    /**
     * @internal
     */
    public function __construct(EntityRepositoryInterface $orderCustomerRepository,EntityRepositoryInterface $productRepository,SalesChannelRepositoryInterface $salesChannelRepository)
    {

        $this->orderCustomerRepository = $orderCustomerRepository;
        $this->productRepository = $productRepository;
        $this->salesChannelRepository = $salesChannelRepository;
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
            $criteria->addAssociation('order.lineItems');

            $orders = $this->orderCustomerRepository->search($criteria, $context);
            $productIds = [];
            foreach ($orders as $order){
                $array=$order->getOrder()->getLineitems()->getElements();
                $productIds[] = array_column($array,'productId');

            }
            $productId = array_column($productIds,'0');
            $productCriteria = new Criteria();
            $productCriteria->addFilter(new EqualsAnyFilter('id',$productId));
            $products = $this->salesChannelRepository->search($productCriteria,$resolverContext->getSalesChannelContext());
            $slot->setData($products);
        }

    }
}

