<?php declare(strict_types=1);

namespace SwagDemoPlugin\Core\Content\Extension;

use Shopware\Core\Content\Product\ProductDefinition;
use Shopware\Core\Framework\DataAbstractionLayer\EntityExtension;
use Shopware\Core\Framework\DataAbstractionLayer\Field\OneToManyAssociationField;
use Shopware\Core\Framework\DataAbstractionLayer\FieldCollection;
use SwagDemoPlugin\Core\Content\SwagDemo\SwagDemoDefinition;

class ProductExtension extends EntityExtension
{
    public function extendFields(FieldCollection $collection): void
    {
        $collection->add(
            new OneToManyAssociationField(
                'product',
                SwagDemoDefinition::class,
                'product_id','id')
        );

    }

    public function getDefinitionClass(): string
    {
        return ProductDefinition::class;
    }
}