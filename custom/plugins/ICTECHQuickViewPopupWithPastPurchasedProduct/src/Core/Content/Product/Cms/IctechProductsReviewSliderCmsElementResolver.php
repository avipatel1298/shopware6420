<?php declare(strict_types=1);

namespace ICTECHQuickViewPopupWithPastPurchasedProduct\Core\Content\Product\Cms;

use Shopware\Core\Content\Cms\Aggregate\CmsSlot\CmsSlotEntity;
use Shopware\Core\Content\Cms\DataResolver\CriteriaCollection;
use Shopware\Core\Content\Cms\DataResolver\Element\AbstractCmsElementResolver;
use Shopware\Core\Content\Cms\DataResolver\Element\ElementDataCollection;
use Shopware\Core\Content\Cms\DataResolver\ResolverContext\ResolverContext;
use Shopware\Core\Framework\DataAbstractionLayer\EntityRepositoryInterface;
use Shopware\Core\Framework\DataAbstractionLayer\Search\Filter\EqualsFilter;
use Shopware\Core\Framework\Log\Package;
use Shopware\Core\Framework\DataAbstractionLayer\Search\Criteria;
use Shopware\Core\System\SystemConfig\SystemConfigService;

#[Package('inventory')]
class IctechProductsReviewSliderCmsElementResolver extends AbstractCmsElementResolver
{
    private SystemConfigService $systemConfigService;

    private EntityRepositoryInterface $productReviewRepository;

    /**
     * @internal
     */
    public function __construct(SystemConfigService $systemConfigService, EntityRepositoryInterface $productReviewRepository)
    {
        $this->systemConfigService = $systemConfigService;
        $this->productReviewRepository = $productReviewRepository;
    }

    public function getType(): string
    {
        return 'ictech-products-review-slider';
    }

    public function collect(CmsSlotEntity $slot, ResolverContext $resolverContext): ?CriteriaCollection
    {
        $config = $slot->getFieldConfig();
        $collection = new CriteriaCollection();

        return $collection->all() ? $collection : null;
    }
   //Function for getting data of customer reviews of products
    public function enrich(CmsSlotEntity $slot, ResolverContext $resolverContext, ElementDataCollection $result): void
    {
        $config = $slot->getFieldConfig();
        $slot->setFieldConfig($config);
        $context = $resolverContext->getSalesChannelContext()->getContext();
        $productId = $resolverContext->getRequest()->attributes->get('productId');
        $criteria = new Criteria();

        if ($productId !== null) {
            $criteria->addFilter((new EqualsFilter('productId', $productId)));
            $criteria->addAssociation('customer');
            $reviews = $this->productReviewRepository->search($criteria, $context);
            $slot->setData($reviews);
        }
    }
}
