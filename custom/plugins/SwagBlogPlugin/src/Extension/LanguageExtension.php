<?php declare(strict_types=1);

namespace SwagBlogPlugin\Extension;

use Shopware\Core\Framework\DataAbstractionLayer\EntityExtension;
use Shopware\Core\Framework\DataAbstractionLayer\Field\OneToManyAssociationField;
use Shopware\Core\Framework\DataAbstractionLayer\FieldCollection;
use Shopware\Core\System\Language\LanguageDefinition;
use SwagBlogPlugin\Core\Content\SwagBlog\Aggregate\SwagBlogTranslation\SwagBlogTranslationDefinition;
use SwagBlogPlugin\Core\Content\SwagBlogCategory\Aggregate\SwagBlogCategoryTranslation\SwagBlogCategoryTranslationDefinition;

class LanguageExtension extends EntityExtension
{
    public function extendFields(FieldCollection $collection): void
    {
        $collection->add(
            new OneToManyAssociationField(
                'swagBlogTranslationsId',
                SwagBlogTranslationDefinition::class,
                'blog_name',
                'id'),
        );

        $collection->add(
            new OneToManyAssociationField(
                'swagBlogTranslationsId',
                SwagBlogTranslationDefinition::class,
                'discription',
                'id'),
        );

        $collection->add(
            new OneToManyAssociationField(
                'swagBlogCategoryTranslationsId',
                SwagBlogCategoryTranslationDefinition::class,
                'category_name',
                'id'),
        );

    }

    public function getDefinitionClass(): string
    {
        return LanguageDefinition::class;
    }

}

