<?php declare(strict_types=1);

namespace SwagDemoPlugin\Core\Content\Extension;

use Shopware\Core\Framework\DataAbstractionLayer\EntityExtension;
use Shopware\Core\Framework\DataAbstractionLayer\Field\OneToManyAssociationField;
use Shopware\Core\Framework\DataAbstractionLayer\FieldCollection;
use Shopware\Core\System\Country\Aggregate\CountryState\CountryStateDefinition;

class StateExtension extends EntityExtension
{
    public function extendFields(FieldCollection $collection): void
    {
        $collection->add(
            new OneToManyAssociationField(
                'state',
                CountryStateDefinition::class,
                'state_id')
        );

    }

    public function getDefinitionClass(): string
    {
        return CountryStateDefinition::class;
    }
}
