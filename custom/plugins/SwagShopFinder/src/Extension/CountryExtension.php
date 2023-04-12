<?php declare(strict_types=1);

namespace SwagShopFinder\Extension;


use Shopware\Core\Framework\DataAbstractionLayer\EntityExtension;
use Shopware\Core\Framework\DataAbstractionLayer\Field\OneToManyAssociationField;
use Shopware\Core\Framework\DataAbstractionLayer\FieldCollection;
use Shopware\Core\System\Country\CountryDefinition;
use SwagShopFinder\Core\Content\ShopFinder\ShopFinderDefinition;

class CountryExtension extends EntityExtension
{
    public function extendFields(FieldCollection $collection): void
    {
        $collection->add(
            new OneToManyAssociationField(
                'countries',
                ShopfinderDefinition::class,
                'country_id')
        );
    }

    public function getDefinitionClass(): string
    {
        return CountryDefinition::class;
    }
}
