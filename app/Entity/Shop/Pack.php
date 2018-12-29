<?php


namespace App\Entity\Shop;


use Doctrine\ORM\Mapping as ORM;

/**
 * Shop\Pack
 *
 * @ORM\Table(name="site_shop_packs")
 * @ORM\Entity
 */
class Pack
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
     * @var Product
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\Shop\Product")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="product_id", referencedColumnName="id")
     * })
     */
    private $product;

    /**
     * @var Item
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\Shop\Item")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="item_id", referencedColumnName="id")
     * })
     */
    private $item;

    /**
     * @var int
     *
     * @ORM\Column(name="amount", type="integer")
     */
    private $amount = 1;

    /**
     * Pack constructor.
     *
     * @param Product $product
     * @param Item $item
     * @param int $amount
     */
    public function __construct(Product $product, Item $item, int $amount = 1)
    {
        $this->product = $product;
        $this->item = $item;
        $this->amount = $amount;
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return Product
     */
    public function getProduct(): Product
    {
        return $this->product;
    }

    /**
     * @return Item
     */
    public function getItem(): Item
    {
        return $this->item;
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
     * @return Pack
     */
    public function setAmount(int $amount): Pack
    {
        $this->amount = $amount;

        return $this;
    }

    public function __toItemArray(): array
    {
        $data = $this->item->__toArray();
        $data['amount'] = $this->amount;

        return $data;
    }

    public function __toArray(): array
    {
        return [
            'product' => $this->product->__toArray(),
            'item' => $this->item->__toArray()
        ];
    }
}