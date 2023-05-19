<?php
//
//namespace ICTECHQuickViewPopupWithPastPurchasedProduct\Storefront\Controller;
//
//use Shopware\Core\Content\Product\ProductEntity;
//use Shopware\Core\Framework\DataAbstractionLayer\EntityRepositoryInterface;
//use Shopware\Core\Framework\DataAbstractionLayer\Search\Criteria;
//use Shopware\Core\Framework\Routing\Annotation\RouteScope;
//use Shopware\Core\System\SalesChannel\SalesChannelContext;
//use Shopware\Storefront\Framework\Cache\Annotation\HttpCache;
//use Shopware\Storefront\Page\Product\ProductPageLoader;
//use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
//use Symfony\Component\HttpFoundation\Request;
//use Symfony\Component\Routing\Annotation\Route;
//use Symfony\Component\HttpFoundation\Response;
//
//
///**
// * @RouteScope(scopes={"storefront"})
// */
//class QuickViewPopUpController extends AbstractController
//{
//    /**
//     * @var ProductPageLoader
//     */
//    private $productPageLoader;
//
//    private $productRepository;
//
//    public function __construct(
//
//        ProductPageLoader         $productPageLoader,
//        EntityRepositoryInterface $productRepository
//    )
//    {
//        $this->productPageLoader = $productPageLoader;
//        $this->productRepository = $productRepository;
//    }
//
//    /**
//     * @HttpCache()
//     * @Route("/detail/{productId}", name="frontend.product.detail.page", methods={"GET"}, defaults={"XmlHttpRequest": true})
//     */
//    public function detail(string $productId, Request $request, SalesChannelContext $context): Response
//    {
//        $product = $this->productRepository->search(new Criteria([$productId]), $context->getContext())->first();
//
//        // Render the product detail page template with the loaded page data
//        return $this->renderStorefront('@ICTECHQuickViewPopupWithPastPurchasedProduct/storefront/page/product-detail/index.html.twig', [
//            'product' => $product,
//        ]);
//    }
//}
