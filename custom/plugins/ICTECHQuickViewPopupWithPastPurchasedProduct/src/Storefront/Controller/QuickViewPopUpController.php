<?php declare(strict_types=1);

namespace ICTECHQuickViewPopupWithPastPurchasedProduct\Storefront\Controller;

use Shopware\Core\Content\Product\ProductCollection;
use Shopware\Core\Framework\DataAbstractionLayer\Search\Criteria;
use Shopware\Core\Framework\DataAbstractionLayer\Search\Sorting\FieldSorting;
use Shopware\Core\System\SalesChannel\SalesChannelContext;
use Shopware\Storefront\Controller\StorefrontController;
use Shopware\Storefront\Framework\Routing\Annotation\RouteScope;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @RouteScope(scopes={"storefront"})
 */
class QuickViewPopUpController extends StorefrontController
{
    /**
     * @Route("/custom-modal", name="frontend.custom.modal.show", options={"seo"="false"}, methods={"GET", "POST"})
     */
    public function show(SalesChannelContext $salesChannelContext): Response
    {
        $products = $this->fetchProducts($salesChannelContext);

        return $this->render('@Storefront/storefront/modal/custom_modal.html.twig', [
            'title' => 'Custom Modal',
            'productCollection' => $products,
        ]);
    }

    /**
     * Fetches the product collection from the database.
     *
     * @return ProductCollection|null
     */
    private function fetchProducts(SalesChannelContext $salesChannelContext): ?ProductCollection
    {
        $criteria = new Criteria();
        $criteria->addSorting(new FieldSorting('createdAt', FieldSorting::DESCENDING));
        $criteria->setLimit(5);

        $productRepository = $this->container->get('product.repository');
        $products = $productRepository->search($criteria, $salesChannelContext->getContext())->getEntities();

        return $products;
    }

}
