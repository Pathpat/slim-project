<?php

declare(strict_types=1);

namespace App\Entity;

use App\Enums\InvoiceStatus;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Persistence\Event\LifecycleEventArgs;

#[ORM\Entity]
#[ORM\Table(name: 'invoices')]
#[ORM\HasLifecycleCallbacks()]
class Invoice
{
    #[ORM\Id]
    #[ORM\Column(type: Types::INTEGER)]
    #[ORM\GeneratedValue]
    private int $id;
    #[ORM\Column(name: 'invoice_number', type: Types::STRING)]
    private string $invoiceNumber;
    #[ORM\Column(type: Types::DECIMAL, precision: 10, scale: 2)]
    private float $amount;
    #[ORM\Column(enumType: InvoiceStatus::class)]
    private InvoiceStatus $status;
    #[ORM\Column(name: 'created_at', type: Types::DATETIME_MUTABLE)]
    private \Datetime $createdAt;

    #[ORM\Column(name: 'due_date', type: Types::DATETIME_MUTABLE)]
    private \Datetime $dueDate;

    #[ORM\OneToMany(targetEntity: InvoiceItem::class, mappedBy: 'invoice', cascade: [
        'persist',
        'remove',
    ])]
    private Collection $items;

    public function __construct()
    {
        $this->items = new ArrayCollection();
    }

    /**
     * @param  LifecycleEventArgs  $args
     *
     * @return void
     */
    #[ORM\PrePersist]
    public function onPrePersist(LifecycleEventArgs $args): void
    {
        $this->createdAt = new \DateTime();
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return float
     */
    public function getAmount(): float
    {
        return $this->amount;
    }

    /**
     * @param  float  $amount
     *
     * @return Invoice
     */
    public function setAmount(float $amount): Invoice
    {
        $this->amount = $amount;

        return $this;
    }

    /**
     * @return string
     */
    public function getInvoiceNumber(): string
    {
        return $this->invoiceNumber;
    }

    /**
     * @param  string  $invoiceNumber
     *
     * @return Invoice
     */
    public function setInvoiceNumber(string $invoiceNumber): Invoice
    {
        $this->invoiceNumber = $invoiceNumber;

        return $this;
    }

    /**
     * @return InvoiceStatus
     */
    public function getStatus(): InvoiceStatus
    {
        return $this->status;
    }

    /**
     * @param  InvoiceStatus  $status
     *
     * @return Invoice
     */
    public function setStatus(InvoiceStatus $status): Invoice
    {
        $this->status = $status;

        return $this;
    }

    /**
     * @param  \Datetime  $createdAt
     *
     * @return Invoice
     */
    public function setCreatedAt(\Datetime $createdAt): Invoice
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * @return Collection<InvoiceItem>
     */
    public function getItems(): Collection
    {
        return $this->items;
    }

    /**
     * @param  InvoiceItem  $item
     *
     * @return $this
     */
    public function addItem(InvoiceItem $item): Invoice
    {
        $item->setInvoice($this);
        $this->items->add($item);

        return $this;
    }

}