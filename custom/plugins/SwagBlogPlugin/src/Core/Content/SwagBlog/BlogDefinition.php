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
use Shopware\Core\Framework\DataAbstractionLayer\Field\ManyToManyIdField;
use Shopware\Core\Framework\DataAbstractionLayer\Field\ManyToOneAssociationField;
use Shopware\Core\Framework\DataAbstractionLayer\Field\StringField;
use Shopware\Core\Framework\DataAbstractionLayer\Field\TranslatedField;
use Shopware\Core\Framework\DataAbstractionLayer\Field\TranslationsAssociationField;
use Shopware\Core\Framework\DataAbstractionLayer\FieldCollection;
use SwagBlogPlugin\Core\Content\CategoryMappingDefinition;
use SwagBlogPlugin\Core\Content\SwagBlog\Aggregate\SwagBlogTranslation\BlogTranslationDefinition;
use SwagBlogPlugin\Core\Content\SwagBlogCategory\BlogCategoryDefinition;
use SwagBlogPlugin\Core\Content\ProductMappingDefinition;


class BlogDefinition extends EntityDefinition
{
    public const ENTITY_NAME = 'blog';

    public function getEntityName(): string
    {
        return self::ENTITY_NAME;
    }

//    public function getEntityClass(): string
//    {
//        return BlogEntity::class;
//    }
//
//    public function getCollectionClass(): string
//    {
//        return BlogCollection::class;
//    }

    protected function defineFields(): FieldCollection
    {
        return new FieldCollection([

            (new IdField('id', 'id'))->addFlags(new Required(), new PrimaryKey()),
            (new TranslatedField('blogName',))->addFlags(new Required()),
            (new TranslatedField('description'))->addFlags(new Required()),
            (new DateField('release_date', 'releaseDate'))->addFlags(new Required()),

            (new BoolField('active', 'active')),
            (new StringField('author', 'author')),
            (new StringField('not_translated_field', 'notTranslatedField'))->addFlags(new ApiAware()),

            new ManyToManyAssociationField('products',
                ProductDefinition::class,
                ProductMappingDefinition::class,
                'blog_id',
                'product_id',
                'id',
                'id'),

            new ManyToManyAssociationField('categories',
            CategoryDefinition::class,
            CategoryMappingDefinition::class,
            'blog_id',
                'blog_category_id','id',
                'id'),


            (new TranslationsAssociationField(
                BlogTranslationDefinition::class,
                'swag_blog_id'))->addFlags(new ApiAware()),
       ]);
    }
}
