<?php declare(strict_types=1);

namespace ICTECHQuickViewPopupWithPastPurchasedProduct\Storefront\Controller;

use Shopware\Core\Framework\Feature;
use Shopware\Core\System\SalesChannel\SalesChannelContext;
use Shopware\Storefront\Controller\StorefrontController;
use Shopware\Storefront\Page\Product\ProductPageLoadedHook;
use Shopware\Storefront\Page\Product\ProductPageLoader;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;



class QuickViewPopUpController extends StorefrontController
{
    private ProductPageLoader $productPageLoader;


    public function __construct(
        ProductPageLoader $productPageLoader,

    ){
        $this->productPageLoader = $productPageLoader;

    }

    /**
     * @Since("6.3.3.0")
     * @HttpCache()
     * @Route("/detail/{productId}", name="frontend.detail.page", methods={"GET"}, defaults={"XmlHttpRequest": true})
     */
    public function index(SalesChannelContext $context, Request $request): Response
    {
        $page = $this->productPageLoader->load($request, $context);

        $this->hook(new ProductPageLoadedHook($page, $context));

        $ratingSuccess = $request->get('success');

        /**
         * @deprecated tag:v6.5.0 - remove complete if statement, cms page id is always set
         *
         * Fallback layout for non-assigned product layout
         */
        if (!$page->getCmsPage()) {
            Feature::throwException('v6.5.0.0', 'Fallback will be removed because cms page is always set in subscriber.');

            return $this->renderStorefront('@Storefront/storefront/page/product-detail/index.html.twig', ['page' => $page, 'ratingSuccess' => $ratingSuccess]);
        }

        return $this->renderStorefront('@Storefront/storefront/page/content/product-detail.html.twig', ['page' => $page]);
    }
}
