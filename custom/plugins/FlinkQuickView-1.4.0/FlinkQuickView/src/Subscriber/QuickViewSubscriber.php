<?php declare(strict_types=1);

namespace Flink\QuickView\Subscriber;

use Shopware\Core\Content\Product\SalesChannel\Detail\AbstractProductDetailRoute;
use Shopware\Core\Framework\DataAbstractionLayer\EntityRepositoryInterface;
use Shopware\Core\Framework\DataAbstractionLayer\Exception\InconsistentCriteriaIdsException;
use Shopware\Core\Framework\DataAbstractionLayer\Search\Criteria;
use Shopware\Core\Framework\Routing\Exception\MissingRequestParameterException;
use Shopware\Storefront\Page\Product\ProductPageCriteriaEvent;
use Shopware\Storefront\Page\Product\QuickView\MinimalQuickViewPageCriteriaEvent;
use Shopware\Storefront\Page\Product\QuickView\MinimalQuickViewPageLoadedEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\Request;

class QuickViewSubscriber implements EventSubscriberInterface
{

    protected $productRepository;

    protected $productDetailRoute;

    public function __construct(AbstractProductDetailRoute $productDetailRoute)
    {
        $this->productDetailRoute = $productDetailRoute;
    }

    /**
    * @return string[]
    */
    public static function getSubscribedEvents(): array
    {
        return [
            MinimalQuickViewPageCriteriaEvent::class => 'onMinimalQuickViewPageCriteria',
            MinimalQuickViewPageLoadedEvent::class => 'onMinimalQuickViewPageLoaded',
        ];
    }

    public function onMinimalQuickViewPageCriteria(MinimalQuickViewPageCriteriaEvent $event)
    {
        try {
            $criteria = $event->getCriteria();
            $criteria->addAssociation('children');
            $criteria->addAssociation('productConfiguratorSetting');
        } catch (InconsistentCriteriaIdsException $e) {
            print_r($e);
        }
    }

    public function onMinimalQuickViewPageLoaded(MinimalQuickViewPageLoadedEvent $event)
    {
        $page = $event->getPage();
        $product = $page->getProduct();

        $productId = $product->getId();
        $criteria = (new Criteria())
            ->addAssociation('manufacturer.media')
            ->addAssociation('options.group')
            ->addAssociation('properties.group')
            ->addAssociation('mainCategories.category')
            ->addAssociation('media');

        $result = $this->productDetailRoute->load($productId, new Request, $event->getSalesChannelContext(), $criteria);
        $page->configuratorSettings = $result->getConfigurator();
    }
}
