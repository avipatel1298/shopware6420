<?php declare(strict_types=1);

namespace ICTECHQuickViewPopupWithPastPurchasedProduct\Core\Content\Product\Cms;

use Shopware\Core\Content\Cms\Aggregate\CmsSlot\CmsSlotEntity;
use Shopware\Core\Content\Cms\DataResolver\CriteriaCollection;
use Shopware\Core\Content\Cms\DataResolver\Element\AbstractCmsElementResolver;
use Shopware\Core\Content\Cms\DataResolver\Element\ElementDataCollection;
use Shopware\Core\Content\Cms\DataResolver\ResolverContext\ResolverContext;
use Shopware\Core\Framework\Log\Package;
use Shopware\Core\System\SystemConfig\SystemConfigService;

#[Package('inventory')]
class IctechProductsReviewSliderCmsElementResolver extends AbstractCmsElementResolver
{

    private SystemConfigService $systemConfigService;

    /**
     * @internal
     */
    public function __construct( SystemConfigService $systemConfigService)
    {

        $this->systemConfigService = $systemConfigService;
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

    public function enrich(CmsSlotEntity $slot, ResolverContext $resolverContext, ElementDataCollection $result): void
    {
        $config = $slot->getFieldConfig();

//        $slot->setData($slider);


    }


}
