<?php

declare(strict_types=1);

namespace App\Entity;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name: 'invoice_items')]
class InvoiceItem
{
    #[ORM\Id]
    #[ORM\Column(type: Types::INTEGER)]
    #[ORM\GeneratedValue]
    private int $id;

    #[ORM\Column(name: 'invoice_id', type: Types::INTEGER)]
    private int $invoiceId;

    #[ORM\Column(type: Types::STRING, length: 255)]
    private string $description;

    #[ORM\Column(type: Types::INTEGER)]
    private int $quantity;

    #[ORM\Column(name: 'unit_price', type: Types::DECIMAL, precision: 10, scale: 2)]
    private float $unitPrice;

    #[ORM\ManyToOne(targetEntity: Invoice::class, inversedBy: 'items')]
    private Invoice $invoice;

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return int
     */
    public function getInvoiceId(): int
    {
        return $this->invoiceId;
    }


    /**
     * @return string
     */
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * @param  string  $description
     *
     * @return InvoiceItem
     */
    public function setDescription(string $description): InvoiceItem
    {
        $this->description = $description;

        return $this;
    }

    /**
     * @return int
     */
    public function getQuantity(): int
    {
        return $this->quantity;
    }

    /**
     * @param  int  $quantity
     *
     * @return InvoiceItem
     */
    public function setQuantity(int $quantity): InvoiceItem
    {
        $this->quantity = $quantity;

        return $this;
    }

    /**
     * @return float
     */
    public function getUnitPrice(): float
    {
        return $this->unitPrice;
    }

    /**
     * @param  float  $unitPrice
     *
     * @return InvoiceItem
     */
    public function setUnitPrice(float $unitPrice): InvoiceItem
    {
        $this->unitPrice = $unitPrice;

        return $this;
    }

    /**
     * @return Invoice
     */
    public function getInvoice(): Invoice
    {
        return $this->invoice;
    }

    /**
     * @param  Invoice  $invoice
     *
     * @return $this
     */
    public function setInvoice(Invoice $invoice): InvoiceItem
    {
        $this->invoice = $invoice;

        return $this;
    }
}