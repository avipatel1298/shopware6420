<?php declare(strict_types=1);

namespace SwagFirstPluginExample\Core\Content\FirstPlugin\Aggregate\FirstPluginTranslation;

use Shopware\Core\Framework\DataAbstractionLayer\Entity;
use Shopware\Core\Framework\DataAbstractionLayer\EntityIdTrait;
use SwagFirstPluginExample\Core\Content\FirstPlugin\FirstPluginEntity;
use Shopware\Core\System\Language\LanguageEntity;

class FirstPluginTranslationEntity extends Entity
{
    use EntityIdTrait;

    /**
     * @var string
     */
    protected $name;

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
    protected $firstPluginId;

    /**
     * @var string
     */
    protected $languageId;

    /**
     * @var FirstPluginEntity|null
     */
    protected $firstPlugin;

    /**
     * @var LanguageEntity|null
     */
    protected $language;

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
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

    public function getFirstPluginId(): string
    {
        return $this->firstPluginId;
    }

    public function setFirstPluginId(string $firstPluginId): void
    {
        $this->firstPluginId = $firstPluginId;
    }

    public function getLanguageId(): string
    {
        return $this->languageId;
    }

    public function setLanguageId(string $languageId): void
    {
        $this->languageId = $languageId;
    }

    public function getFirstPlugin(): ?FirstPluginEntity
    {
        return $this->firstPlugin;
    }

    public function setFirstPlugin(?FirstPluginEntity $firstPlugin): void
    {
        $this->firstPlugin = $firstPlugin;
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
