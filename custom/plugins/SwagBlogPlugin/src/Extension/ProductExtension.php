<?php declare(strict_types=1);

namespace SwagBlogPlugin\Extension;

use Shopware\Core\Content\Product\ProductDefinition;
use Shopware\Core\Framework\DataAbstractionLayer\EntityExtension;
use Shopware\Core\Framework\DataAbstractionLayer\Field\ManyToManyAssociationField;
use Shopware\Core\Framework\DataAbstractionLayer\FieldCollection;
use SwagBlogPlugin\Core\Content\SwagBlog\BlogDefinition;
use SwagBlogPlugin\Core\Content\ProductMappingDefinition;

class ProductExtension extends EntityExtension
{
    public function extendFields(FieldCollection $collection): void
    {
        $collection->add(
            new ManyToManyAssociationField(
                'blogs',
                BlogDefinition::class,
                ProductMappingDefinition::class,
                'product_id',
                'blog_id',
                'id',
                'id')
        );

    }

    public function getDefinitionClass(): string
    {
        return ProductDefinition::class;
    }
}
