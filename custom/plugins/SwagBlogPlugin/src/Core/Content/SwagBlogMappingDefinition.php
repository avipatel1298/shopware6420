<?php declare(strict_types=1);


namespace SwagBlogPlugin\Core\Content;



use Shopware\Core\Content\Product\ProductDefinition;
use Shopware\Core\Framework\DataAbstractionLayer\Field\FkField;
use Shopware\Core\Framework\DataAbstractionLayer\Field\Flag\ApiAware;
use Shopware\Core\Framework\DataAbstractionLayer\Field\Flag\Inherited;
use Shopware\Core\Framework\DataAbstractionLayer\Field\Flag\PrimaryKey;
use Shopware\Core\Framework\DataAbstractionLayer\Field\Flag\Required;
use Shopware\Core\Framework\DataAbstractionLayer\Field\ManyToOneAssociationField;
use Shopware\Core\Framework\DataAbstractionLayer\Field\ReferenceVersionField;
use Shopware\Core\Framework\DataAbstractionLayer\FieldCollection;
use Shopware\Core\Framework\DataAbstractionLayer\MappingEntityDefinition;
use SwagBlogPlugin\Core\Content\SwagBlog\SwagBlogDefinition;

class SwagBlogMappingDefinition extends MappingEntityDefinition
{
    public const ENTITY_NAME = 'swag_blog_product';

    public function getEntityName(): string
    {
        return self::ENTITY_NAME;
    }

//    public function getEntityClass(): string
////    {
////        return SwagBlogMappingEntity::class;
////    }
////
////    public function getCollectionClass(): string
////    {
////        return SwagBlogMappingCollection::class;
////    }

    protected function defineFields(): FieldCollection
    {
        return new FieldCollection([
            (new FkField('blog_id', 'blogId', SwagBlogDefinition::class))->addFlags(new PrimaryKey(), new Required()),
            (new FkField('product_id', 'productId', ProductDefinition::class))->addFlags(new PrimaryKey(), new Required()),
            (new ReferenceVersionField(ProductDefinition::class))->addFlags(new ApiAware(), new Inherited()),


            new ManyToOneAssociationField('blogId', 'blog_id', SwagBlogDefinition::class, 'id'),
            new ManyToOneAssociationField('productId', 'product_id', ProductDefinition::class, 'id')


        ]);
    }
}
