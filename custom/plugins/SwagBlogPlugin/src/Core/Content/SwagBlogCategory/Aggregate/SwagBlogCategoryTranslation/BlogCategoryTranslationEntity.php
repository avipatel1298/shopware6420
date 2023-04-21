<?php declare(strict_types=1);

namespace SwagBlogPlugin\Core\Content\SwagBlogCategory\Aggregate\SwagBlogCategoryTranslation;

use Shopware\Core\Framework\DataAbstractionLayer\Entity;
use Shopware\Core\Framework\DataAbstractionLayer\EntityIdTrait;
use SwagBlogPlugin\Core\Content\SwagBlogCategory\BlogCategoryEntity;
use Shopware\Core\System\Language\LanguageEntity;

class BlogCategoryTranslationEntity extends Entity
{
    use EntityIdTrait;

    /**
     * @var string
     */
    protected $categoryName;

    /**
     * @var \DateTimeInterface
     */
    protected $createdAt;

    /**
     * @var \DateTimeInterface|null
     */
    protected $updatedAt;

    /**
     * @var string
     */
    protected $blogCategoryId;

    /**
     * @var string
     */
    protected $languageId;

    /**
     * @var BlogCategoryEntity|null
     */
    protected $blogCategory;

    /**
     * @var LanguageEntity|null
     */
    protected $language;

    public function getCategoryName(): ?string
    {
        return $this->categoryName;
    }

    public function setCategoryName(string $categoryName): void
    {
        $this->categoryName = $categoryName;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeInterface $createdAt): void
    {
        $this->createdAt = $createdAt;
    }

    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(?\DateTimeInterface $updatedAt): void
    {
        $this->updatedAt = $updatedAt;
    }

    public function getBlogCategoryId(): string
    {
        return $this->blogCategoryId;
    }

    public function setBlogCategoryId(string $blogCategoryId): void
    {
        $this->blogCategoryId = $blogCategoryId;
    }

    public function getLanguageId(): string
    {
        return $this->languageId;
    }

    public function setLanguageId(string $languageId): void
    {
        $this->languageId = $languageId;
    }

    public function getBlogCategory(): ?BlogCategoryEntity
    {
        return $this->blogCategory;
    }

    public function setBlogCategory(?BlogCategoryEntity $blogCategory): void
    {
        $this->blogCategory = $blogCategory;
    }

    public function getLanguage(): ?LanguageEntity
    {
        return $this->language;
    }

    public function setLanguage(?LanguageEntity $language): void
    {
        $this->language = $language;
    }
}
