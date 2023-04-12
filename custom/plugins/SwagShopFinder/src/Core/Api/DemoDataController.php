<?php declare(strict_types=1);

namespace SwagShopFinder\Core\Api;

use Faker\Factory;
use Shopware\Core\Framework\Context;
use Shopware\Core\Framework\DataAbstractionLayer\EntityRepositoryInterface;
use Shopware\Core\Framework\DataAbstractionLayer\Exception\InconsistentCriteriaIdsException;
use Shopware\Core\Framework\DataAbstractionLayer\Search\Criteria;
use Shopware\Core\Framework\DataAbstractionLayer\Search\Filter\EqualsFilter;
use Shopware\Core\Framework\Routing\Annotation\RouteScope;
use Shopware\Core\Framework\Uuid\Uuid;
use Shopware\Core\System\Country\Exception\CountryNotFoundException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

/**
 * @RouteScope(scopes={"api"})
 */
class DemoDataController extends AbstractController
{
    /**
     * @Var EntityRepositoryInterface
     */
    private $countryRepository;

    /**
     * @Var EntityRepositoryInterface
     */

    private $shopFinderRepository;

    public function __construct(EntityRepositoryInterface $countryRepository,EntityRepositoryInterface $shopFinderRepository)
    {
        $this->countryRepository = $countryRepository;
        $this->shopFinderRepository = $shopFinderRepository;

    }

    /**
     * @Route ("/api/v{version}/_action/swag-shop-finder/generate", name="api.custom.swag_shop_finder_generate"methods={"POST"}})
     * @return Response
     */

    public function generate(Context $context): Response
    {
        $faker = Factory::create();
        $country = $this->getActiveCountry($context);

        $data = [];
        for ($i = 0; $i < 50; $i++){
            $data[] = [
                'id' => Uuid::randomHex(),
                'active' => true,
                'name' => $faker->name,
                'street' => $faker->streetAddress,
                'postcode' => $faker->postcode,
                'city' => $faker->city,
                'countryId' => $country->getId(),

            ];
        }

        $this->shopFinderRepository->create($data, $context);
        return new Response('',Response::HTTP_NO_CONTENT);
    }

    /**
     * @param Context $context
     * @return ConuntryEntity
     * @throws CountryNotFoundException
     * @throws InconsistentCriteriaIdsException
     */

    private function getActiveCountry(Context $context): ConuntryEntity
    {
        $criteria = new criteria();
        $criteria->addFilter(new EqualsFilter('active', '1'));
        $criteria->setLimit(1);

        $country = $this->countryRepository->search($criteria, $context)->getEntities()->first();

        if ($country === null) {
            throw new CountryNotFoundException('');
        }
        return $country;
    }
}
