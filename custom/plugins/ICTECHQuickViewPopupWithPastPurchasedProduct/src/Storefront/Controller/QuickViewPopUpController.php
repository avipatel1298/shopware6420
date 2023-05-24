<?php

namespace ICTECHQuickViewPopupWithPastPurchasedProduct\Storefront\Controller;
use Shopware\Core\Content\Category\SalesChannel\AbstractCategoryRoute;
use Shopware\Core\Content\Cms\SalesChannel\AbstractCmsRoute;
use Shopware\Core\Content\Product\Exception\ProductNotFoundException;
use Shopware\Core\Content\Product\SalesChannel\Detail\AbstractProductDetailRoute;
use Shopware\Core\Content\Product\SalesChannel\Listing\AbstractProductListingRoute;
use Shopware\Core\Framework\DataAbstractionLayer\Search\Criteria;
use Shopware\Core\Framework\Routing\Annotation\RouteScope;
use Shopware\Core\Framework\Routing\Exception\MissingRequestParameterException;
use Shopware\Core\System\SalesChannel\SalesChannelContext;
use Shopware\Storefront\Controller\StorefrontController;
use Shopware\Storefront\Page\Product\Configurator\ProductCombinationFinder;
use Shopware\Storefront\Page\Product\QuickView\MinimalQuickViewPageLoader;
use Shopware\Storefront\Page\Product\Review\ProductReviewLoader;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;

/**
 * @RouteScope(scopes={"storefront"})
 */
class QuickViewPopUpController extends StorefrontController
{

    /**
     * @var ProductCombinationFinder
     */
    private $combinationFinder;

    /**
     * @var MinimalQuickViewPageLoader
     */
    private $minimalQuickViewPageLoader;

    public function __construct(
        ProductCombinationFinder $combinationFinder,
        MinimalQuickViewPageLoader $minimalQuickViewPageLoader
    ) {
        $this->combinationFinder = $combinationFinder;
        $this->minimalQuickViewPageLoader = $minimalQuickViewPageLoader;
    }

    /**
     * Route to load the cms element buy box product config which assigned to the provided product id.
     * Product id is required to load the slot config for the buy box
     *
     * @RouteScope(scopes={"storefront"})
     * @Route("/ictech/quickview/{productId}/switch", name="ictech.quickview.switch", methods={"GET"}, defaults={"productId"=null, "XmlHttpRequest"=true})
     *
     * @throws MissingRequestParameterException
     * @throws ProductNotFoundException
     */
    public function switchBuyBoxVariant(string $productId, Request $request, SalesChannelContext $context): Response
    {
        if (!$productId) {
            throw new MissingRequestParameterException('Parameter productId missing');
        }

        /** @var string $switchedOption */
        $switchedOption = $request->query->get('switched');

        /** @var string $elementId */
        $elementId = $request->query->get('elementId');

        /** @var array $newOptions */
        $newOptions = json_decode($request->query->get('options'), true);

        $redirect = $this->combinationFinder->find($productId, $switchedOption, $newOptions, $context);

        $newProductId = $redirect->getVariantId();
        $request->attributes->set('productId', $newProductId);
        $page = $this->minimalQuickViewPageLoader->load($request, $context);

        return $this->renderStorefront('@Storefront/storefront/component/product/quickview/minimal.html.twig', [
            'page' => $page,
            'elementId' => $elementId,
        ]);
    }
}
