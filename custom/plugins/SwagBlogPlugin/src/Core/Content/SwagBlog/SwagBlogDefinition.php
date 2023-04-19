<?php declare(strict_types=1);

namespace SwagBlogPlugin\Core\Content\SwagBlog;

use Shopware\Core\Content\Category\CategoryDefinition;
use Shopware\Core\Content\Product\ProductDefinition;
use Shopware\Core\Framework\DataAbstractionLayer\EntityDefinition;
use Shopware\Core\Framework\DataAbstractionLayer\Field\BoolField;
use Shopware\Core\Framework\DataAbstractionLayer\Field\DateField;
use Shopware\Core\Framework\DataAbstractionLayer\Field\FkField;
use Shopware\Core\Framework\DataAbstractionLayer\Field\Flag\ApiAware;
use Shopware\Core\Framework\DataAbstractionLayer\Field\Flag\Inherited;
use Shopware\Core\Framework\DataAbstractionLayer\Field\Flag\PrimaryKey;
use Shopware\Core\Framework\DataAbstractionLayer\Field\Flag\Required;
use Shopware\Core\Framework\DataAbstractionLayer\Field\IdField;
use Shopware\Core\Framework\DataAbstractionLayer\Field\ManyToManyAssociationField;
use Shopware\Core\Framework\DataAbstractionLayer\Field\ManyToOneAssociationField;
use Shopware\Core\Framework\DataAbstractionLayer\Field\ReferenceVersionField;
use Shopware\Core\Framework\DataAbstractionLayer\Field\StringField;
use Shopware\Core\Framework\DataAbstractionLayer\Field\TranslatedField;
use Shopware\Core\Framework\DataAbstractionLayer\Field\TranslationsAssociationField;
use Shopware\Core\Framework\DataAbstractionLayer\FieldCollection;
use SwagBlogPlugin\Core\Content\SwagBlog\Aggregate\SwagBlogTranslation\SwagBlogTranslationDefinition;
use SwagBlogPlugin\Core\Content\SwagBlogMappingDefinition;


class SwagBlogDefinition extends EntityDefinition
{
    public const ENTITY_NAME = 'swag_blog';

    public function getEntityName(): string
    {
        return self::ENTITY_NAME;
    }
//
//    public function getEntityClass(): string
//    {
//        return SwagBlogEntity::class;
//    }
//
//    public function getCollectionClass(): string
//    {
//        return SwagBlogCollection::class;
//    }

    protected function defineFields(): FieldCollection
    {
        return new FieldCollection([

            (new IdField('id', 'id'))->addFlags(new Required(), new PrimaryKey()),
            (new TranslatedField('blog_name',))->AddFlags(new Required()),
            (new TranslatedField('discription'))->AddFlags(new Required()),
            (new DateField('release_date', 'release_date'))->AddFlags(new Required()),
            (new BoolField('active', 'active')),
            (new StringField('author', 'author')),
            (new ReferenceVersionField(ProductDefinition::class))->addFlags(new ApiAware(), new Inherited()),
            (new StringField('not_translated_field', 'notTranslatedField'))->addFlags(new ApiAware()),

            (new FkField('category_id', 'categoryId', CategoryDefinition::class, 'id')),
            (new FkField('product_id', 'productId', ProductDefinition::class, 'id')),


            new ManyToManyAssociationField('products',
                ProductDefinition::class,
                SwagBlogMappingDefinition::class,
                'blog_id',
                'product_id',
                'id',
                'id'),

            new ManyToOneAssociationField('categoryId',
                'category_id',
                CategoryDefinition::class,
                'id',
                false),


            (new TranslationsAssociationField(
                SwagBlogTranslationDefinition::class,
                'swag_blog_id'))->addFlags(new ApiAware()),
        ]);
    }
}
