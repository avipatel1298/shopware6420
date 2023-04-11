<?php declare(strict_types=1);

namespace SwagFirstPluginExample\Core\Content\FirstPlugin;

use Shopware\Core\Framework\DataAbstractionLayer\Entity;
use Shopware\Core\Framework\DataAbstractionLayer\EntityIdTrait;
use Shopware\Core\Framework\DataAbstractionLayer\EntityCollection;
use Shopware\Core\Content\Product\ProductEntity;

class FirstPluginEntity extends Entity
{
    use EntityIdTrait;

    /**
     * @var string
     */
    protected $id;

    /**
     * @var string|null
     */
    protected $notTranslatedField;

    /**
     * @var EntityCollection
     */
    protected $name;

    /**
     * @var string|null
     */
    protected $email;

    /**
     * @var string|null
     */
    protected $password;

    /**
     * @var ProductEntity|null
     */
    protected $productId;

    /**
     * @var string|null
     */
    protected $productName;

    /**
     * @var string|null
     */
    protected $product_number;

    /**
     * @var \DateTimeInterface
     */
    protected $createdAt;

    /**
     * @var \DateTimeInterface|null
     */
    protected $updatedAt;

    /**
     * @var array|null
     */
    protected $translated;

    public function getId(): string
    {
        return $this->id;
    }

    public function setId(string $id): void
    {
        $this->id = $id;
    }

    public function getNotTranslatedField(): ?string
    {
        return $this->notTranslatedField;
    }

    public function setNotTranslatedField(?string $notTranslatedField): void
    {
        $this->notTranslatedField = $notTranslatedField;
    }

    public function getName(): EntityCollection
    {
        return $this->name;
    }

    public function setName(EntityCollection $name): void
    {
        $this->name = $name;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(?string $email): void
    {
        $this->email = $email;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(?string $password): void
    {
        $this->password = $password;
    }

    public function getProductId(): ?ProductEntity
    {
        return $this->productId;
    }

    public function setProductId(?ProductEntity $productId): void
    {
        $this->productId = $productId;
    }

    public function getProductName(): ?string
    {
        return $this->productName;
    }

    public function setProductName(?string $productName): void
    {
        $this->productName = $productName;
    }

    public function getProduct_number(): ?string
    {
        return $this->product_number;
    }

    public function setProduct_number(?string $product_number): void
    {
        $this->product_number = $product_number;
    }

    public function getCreatedAt(): \DateTimeInterface
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

    public function getTranslated(): array
    {
        return $this->translated;
    }

    public function setTranslated(?array $translated): void
    {
        $this->translated = $translated;
    }
}
