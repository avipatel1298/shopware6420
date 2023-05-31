<?php declare(strict_types=1);

namespace ICTECHQuickViewPopupWithPastPurchasedProduct\Subscriber;

use Shopware\Core\Content\Product\SalesChannel\Detail\AbstractProductDetailRoute;
use Shopware\Core\Framework\DataAbstractionLayer\EntityRepository;
use Shopware\Core\Framework\DataAbstractionLayer\EntityRepositoryInterface;
use Shopware\Core\Framework\DataAbstractionLayer\Exception\InconsistentCriteriaIdsException;
use Shopware\Core\Framework\DataAbstractionLayer\Search\Criteria;
use Shopware\Core\Framework\DataAbstractionLayer\Search\Filter\EqualsAnyFilter;
use Shopware\Core\Framework\DataAbstractionLayer\Search\Filter\EqualsFilter;
use Shopware\Core\Framework\Struct\ArrayStruct;
use Shopware\Core\System\SalesChannel\Entity\SalesChannelRepositoryInterface;
use Shopware\Storefront\Page\Product\QuickView\MinimalQuickViewPageCriteriaEvent;
use Shopware\Storefront\Page\Product\QuickView\MinimalQuickViewPageLoadedEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\Request;

class QuickViewPopUpSubscriber implements EventSubscriberInterface
{
    private AbstractProductDetailRoute $productDetailRoute;
    private EntityRepository $productReviewRepository;
    private EntityRepositoryInterface $productRepository;
    private EntityRepositoryInterface $orderCustomerRepository;
    private SalesChannelRepositoryInterface $salesChannelRepository;

    public function __construct(
        AbstractProductDetailRoute      $productDetailRoute,
        EntityRepository                $productReviewRepository,
        EntityRepositoryInterface       $productRepository,
        EntityRepositoryInterface       $orderCustomerRepository,
        SalesChannelRepositoryInterface $salesChannelRepository
    )

    {
        $this->productDetailRoute = $productDetailRoute;
        $this->productRepository = $productRepository;
        $this->productReviewRepository = $productReviewRepository;
        $this->orderCustomerRepository = $orderCustomerRepository;
        $this->salesChannelRepository = $salesChannelRepository;
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
        $customer = $event->getSalesChannelContext()->getCustomer();
        $reviews = $event->getSalesChannelContext()->getContext();
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

        //customer Past Bought products slider data with extension
        $customerProducts = [];
        if ($customer !== null) {
            $criteria = new Criteria();
            $criteria->addFilter((new EqualsFilter('customerId', $customer->getId())));
            $criteria->addAssociation('order');
            $criteria->addAssociation('order.lineItems');

            $orders = $this->orderCustomerRepository->search($criteria, $event->getSalesChannelContext()->getContext());
            $productIds = [];
            foreach ($orders as $order) {
                $array = $order->getOrder()->getLineitems()->getElements();
                $productIds[] = array_column($array, 'productId');

            }
            $productId = array_column($productIds, '0');
            $productCriteria = new Criteria();
            $productCriteria->addFilter(new EqualsAnyFilter('id', $productId));
            $customerProducts['customerProductsData'] = $this->salesChannelRepository->search($productCriteria, $event->getSalesChannelContext())->getElements();
        }

        $event->getPage()->addExtension('customerProducts', new ArrayStruct($customerProducts));
        $page->configuratorSettings = $result->getConfigurator();

        //Customer Review Slider data with extension
        $context = $event->getSalesChannelContext()->getContext();
        $productReviewId = $event->getRequest()->attributes->get('productId');
        $criteria = new Criteria();

        if ($productReviewId !== null) {
            $criteria->addFilter((new EqualsFilter('productId', $productReviewId)));
            $criteria->addAssociation('customer');
            $reviews = $this->productReviewRepository->search($criteria, $context);
            $customerReviews['customerReviewData'] = $this->productReviewRepository->search($criteria, $event->getContext())->getElements();

            $event->getPage()->addExtension('customerReviewData', new ArrayStruct($customerReviews));
            $page->configuratorSettings = $result->getConfigurator();

        }
    }
}
