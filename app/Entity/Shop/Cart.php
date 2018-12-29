<?php


namespace App\Entity\Shop;


use App\Entity\User;
use Doctrine\ORM\Mapping as ORM;

/**
 * Shop\Cart
 *
 * @ORM\Table(name="site_shop_cart")
 * @ORM\Entity
 * @ORM\HasLifecycleCallbacks
 */
class Cart
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
     * @var User
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\User")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="user_id", referencedColumnName="user_id")
     * })
     */
    private $user;

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
     * @var int
     *
     * @ORM\Column(name="amount", type="integer")
     */
    private $amount;

    /**
     * @var \DateTimeImmutable
     *
     * @ORM\Column(name="created_at", type="datetime_immutable")
     */
    private $createdAt;

    /**
     * @var int
     *
     * @ORM\Column(name="result_sum", type="integer", options={"comment"="Оплаченая сумма, с учетом скидок и т.п."})
     */
    private $resultSum = 0;

    /**
     * @var \DateTimeImmutable|null
     *
     * @ORM\Column(name="completed_at", type="datetime_immutable", nullable=true)
     */
    private $completedAt;

    /**
     * Cart constructor.
     *
     * @param User $user
     * @param Product $product
     * @param int $amount
     * @throws \Exception
     */
    public function __construct(User $user, Product $product, int $amount)
    {
        $this->user = $user;
        $this->product = $product;
        $this->amount = $amount;
        $this->createdAt = new \DateTimeImmutable();
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return User
     */
    public function getUser(): User
    {
        return $this->user;
    }

    /**
     * @return Product
     */
    public function getProduct(): Product
    {
        return $this->product;
    }

    /**
     * @return int
     */
    public function getAmount(): int
    {
        return $this->amount;
    }

    /**
     * @return \DateTimeImmutable
     */
    public function getCreatedAt(): \DateTimeImmutable
    {
        return $this->createdAt;
    }

    /**
     * @return int
     */
    public function getResultSum(): int
    {
        return $this->resultSum;
    }

    /**
     * @param int $resultSum
     * @return Cart
     */
    public function setResultSum(int $resultSum): Cart
    {
        $this->resultSum = $resultSum;

        return $this;
    }

    /**
     * @return \DateTimeImmutable|null
     */
    public function getCompletedAt(): ?\DateTimeImmutable
    {
        return $this->completedAt;
    }

    /**
     * @ORM\PreUpdate
     */
    public function setCompletedDate(): void
    {
        $this->completedAt = new \DateTimeImmutable();
    }
}