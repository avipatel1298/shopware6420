<?php declare(strict_types=1);

namespace SwagBlogPlugin\Extension;

use Shopware\Core\Framework\DataAbstractionLayer\EntityExtension;
use Shopware\Core\Framework\DataAbstractionLayer\Field\OneToManyAssociationField;
use Shopware\Core\Framework\DataAbstractionLayer\FieldCollection;
use Shopware\Core\System\Language\LanguageDefinition;
use SwagBlogPlugin\Core\Content\SwagBlog\Aggregate\SwagBlogTranslation\BlogTranslationDefinition;
use SwagBlogPlugin\Core\Content\SwagBlogCategory\Aggregate\SwagBlogCategoryTranslation\BlogCategoryTranslationDefinition;

class LanguageExtension extends EntityExtension
{
    public function extendFields(FieldCollection $collection): void
    {
        $collection->add(
            new OneToManyAssociationField(
                'BlogTranslationsId',
                BlogTranslationDefinition::class,
                'blog_id',
                'id'),
        );

        $collection->add(
            new OneToManyAssociationField(
                'BlogCategoryTranslationId',
                BlogCategoryTranslationDefinition::class,
                'blog_category_id',
                'id'),
        );
    }
    public function getDefinitionClass(): string
    {
        return LanguageDefinition::class;
    }

}

