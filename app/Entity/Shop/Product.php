<?php


namespace App\Entity\Shop;


use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\Collection;

/**
 * Shop\Product
 *
 * @ORM\Table(name="site_shop_products")
 * @ORM\Entity
 * @ORM\HasLifecycleCallbacks
 */
class Product
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var Item|null
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\Shop\Item")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="item_id", referencedColumnName="id")
     * })
     */
    private $item;

    /**
     * @var Collection
     *
     * @ORM\OneToMany(targetEntity="App\Entity\Shop\Pack", mappedBy="product", cascade={"persist"})
     */
    private $items;

    /**
     * @var Category
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\Shop\Category")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="category_id", referencedColumnName="id")
     * })
     */
    private $category;

    /**
     * @var int
     *
     * @ORM\Column(name="amount", type="integer")
     */
    private $amount = 1;

    /**
     * @var int
     *
     * @ORM\Column(name="price", type="integer")
     */
    private $price;

    /**
     * @var int
     *
     * @ORM\Column(name="discount", type="integer")
     */
    private $discount;

    /**
     * @var \DateTimeImmutable|null
     *
     * @ORM\Column(name="discount_time", type="datetime_immutable")
     */
    private $discountTime;

    /**
     * @var string|null
     *
     * @ORM\Column(name="name", type="string", nullable=true)
     */
    private $name;

    /**
     * @var string|null
     *
     * @ORM\Column(name="pic", type="string", nullable=true)
     */
    private $picture;

    /**
     * @var string|null
     *
     * @ORM\Column(name="for_groups", type="string", nullable=true)
     */
    private $for;

    /**
     * @var array
     */
    private $forArray;

    /**
     * @var boolean
     *
     * @ORM\Column(name="enabled", type="boolean")
     */
    private $enabled = false;

    /**
     * @var \DateTimeImmutable
     *
     * @ORM\Column(name="created_at", type="datetime_immutable")
     */
    private $createdAt;

    /**
     * Product constructor.
     *
     * @param Item|null $item
     * @param Category $category
     * @param int $amount
     * @param int $price
     * @param int $discount
     * @param \DateTimeImmutable|null $discountTime
     * @param array $for
     * @param null|string $name
     * @param null|string $picture
     */
    public function __construct(
        ?Item $item,
        Category $category,
        int $amount,
        int $price,
        int $discount = 0,
        ?\DateTimeImmutable $discountTime = null,
        array $for = [],
        ?string $name = null,
        ?string $picture = null)
    {
        $this->items = new ArrayCollection();

        $this->item = $item;
        $this->category = $category;
        $this->amount = $amount;
        $this->price = $price;
        $this->discount = $discount;
        $this->discountTime = $discountTime;
        $this->for = !empty($for) ? json_encode($for) : null;
        $this->forArray = $for;
        $this->name = $name;
        $this->picture = $picture;
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return Item|null
     */
    public function getItem(): ?Item
    {
        return $this->item;
    }

    /**
     * @param Item|null $item
     * @return Product
     */
    public function setItem(?Item $item): Product
    {
        $this->item = $item;

        return $this;
    }

    /**
     * @return Collection
     */
    public function getItems(): Collection
    {
        return $this->items;
    }

    /**
     * @return Category
     */
    public function getCategory(): Category
    {
        return $this->category;
    }

    /**
     * @param Category $category
     * @return Product
     */
    public function setCategory(Category $category): Product
    {
        $this->category = $category;

        return $this;
    }

    /**
     * @return int
     */
    public function getAmount(): int
    {
        return $this->amount;
    }

    /**
     * @param int $amount
     * @return Product
     */
    public function setAmount(int $amount): Product
    {
        $this->amount = $amount;

        return $this;
    }

    /**
     * @return int
     */
    public function getPrice(): int
    {
        return $this->price;
    }

    /**
     * @param int $price
     * @return Product
     */
    public function setPrice(int $price): Product
    {
        $this->price = $price;

        return $this;
    }

    /**
     * @return int
     */
    public function getDiscount(): int
    {
        return $this->discount;
    }

    /**
     * @param int $discount
     * @return Product
     */
    public function setDiscount(int $discount): Product
    {
        $this->discount = $discount;

        return $this;
    }

    /**
     * @return \DateTimeImmutable|null
     */
    public function getDiscountTime(): ?\DateTimeImmutable
    {
        return $this->discountTime;
    }

    /**
     * @param \DateTimeImmutable|null $discountTime
     * @return Product
     */
    public function setDiscountTime(?\DateTimeImmutable $discountTime): Product
    {
        $this->discountTime = $discountTime;

        return $this;
    }

    /**
     * @return null|string
     */
    public function getFor(): ?string
    {
        return $this->for;
    }

    /**
     * @param array|null $for
     * @return Product
     */
    public function setFor(?array $for = null): Product
    {
        $this->for = !empty($for) ? json_encode($for) : null;
        $this->forArray = empty($for) ? [] : $for;

        return $this;
    }

    /**
     * @return array
     */
    public function getForArray(): array
    {
        if(is_null($this->forArray)) {
            $this->forArray = (array) json_decode($this->for, true);
        }

        return $this->forArray;
    }

    /**
     * @return null|string
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getProductName(): string
    {
        if(!is_null($this->name)) {
            return $this->name;
        }

        return $this->item->getName();
    }

    /**
     * @param null|string $name
     * @return Product
     */
    public function setName(?string $name): Product
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @param null|string $picture
     * @return Product
     */
    public function setPicture(?string $picture): Product
    {
        $this->picture = $picture;

        return $this;
    }

    /**
     * @return null|string
     */
    public function getPicture(): ?string
    {
        return $this->picture;
    }

    /**
     * @return bool
     */
    public function isEnabled(): bool
    {
        return $this->enabled;
    }

    /**
     * @param bool $enabled
     * @return Product
     */
    public function setEnabled(bool $enabled): Product
    {
        $this->enabled = $enabled;

        return $this;
    }

    /**
     * @return \DateTimeImmutable
     */
    public function getCreatedAt(): \DateTimeImmutable
    {
        return $this->createdAt;
    }

    /**
     * @ORM\PrePersist
     */
    public function generateCreatedAt(): void
    {
        $this->createdAt = new \DateTimeImmutable();
    }

    public function __toArray(): array
    {
        return [
            'id' => $this->id,
            //'name' => is_null($this->item) ? $this->name : $this->item->getName(),
            'product_name' => $this->name,
            'name' => !empty($this->name) ? $this->name : $this->item->getName(),
            'item' => is_null($this->item) ? null : $this->item->__toArray(),
            'category' => $this->category->__toArray(),
            'amount' => $this->amount,
            'price' => $this->price,
            'discount' => $this->discount,
            'discount_time' => is_null($this->discountTime) ? null : $this->discountTime->getTimestamp(),
            'for' => $this->getForArray(),
            'picture' => $this->picture,
            'enabled' => $this->enabled,
            'created_at' => $this->createdAt->getTimestamp(),
            'items' => !is_null($this->item) ? null : array_map(function (Pack $pack) {
                return $pack->__toItemArray();
            }, $this->items->toArray())
        ];
    }
}