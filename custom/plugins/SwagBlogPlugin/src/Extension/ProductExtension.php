<?php declare(strict_types=1);

namespace SwagBlogPlugin\Extension;

use Shopware\Core\Content\Product\ProductDefinition;
use Shopware\Core\Framework\DataAbstractionLayer\EntityExtension;
use Shopware\Core\Framework\DataAbstractionLayer\Field\ManyToManyAssociationField;
use Shopware\Core\Framework\DataAbstractionLayer\FieldCollection;
use SwagBlogPlugin\Core\Content\SwagBlog\SwagBlogDefinition;
use SwagBlogPlugin\Core\Content\SwagBlogMappingDefinition;

class ProductExtension extends EntityExtension
{
    public function extendFields(FieldCollection $collection): void
    {
        $collection->add(
            new ManyToManyAssociationField(
                'blogs',
                SwagBlogDefinition::class,
                SwagBlogMappingDefinition::class,
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
