<?php declare(strict_types=1);

namespace ICTECHQuickViewPopupWithPastPurchasedProduct\Storefront\Controller;

use Shopware\Core\Framework\DataAbstractionLayer\EntityRepository;
use Shopware\Storefront\Controller\StorefrontController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route(defaults={"_routeScope"={"storefront"}})
 */
class QuickViewPopUpController extends StorefrontController
{
    private EntityRepository $productRepository;

    public function __construct(EntityRepository $productRepository)
    {
        $this->productRepository = $productRepository;
    }

    /**
     * @Route("/product/product-detail/{productId}", name="frontend.product.detail.page", methods={"GET"}, defaults={"productId"=null, "XmlHttpRequest"=true})
     */
    public function index(Request $request, string $productId): Response
    {
        return $page = $this->renderStorefront('@ICTECHQuickViewPopupWithPastPurchasedProduct/storefront/page/product-detail/product-detail-index.html.twig');
    }
}
