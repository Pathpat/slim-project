<?php

declare(strict_types=1);

namespace Tests\Unit\Services;

use App\Services\EmailService;
use App\Services\InvoiceService;
use App\Services\StripePayment;
use App\Services\SalesTaxService;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

class InvoiceServiceTest extends TestCase
{
    #[Test]
    public function it_processes_invoice(): void
    {
        $salesTaxServiceMock = $this->createMock(SalesTaxService::class);
        $gatewayServiceMock = $this->createMock(StripePayment::class);
        $emailServiceMock = $this->createMock(EmailService::class);

        //Stub the method to return true
        $gatewayServiceMock->method('charge')->willReturn(true);

        $invoiceService = new InvoiceService(
            $salesTaxServiceMock,
            $gatewayServiceMock,
            $emailServiceMock
        );

        $customer = ['name' => 'John'];
        $amount = 100;

        $result = $invoiceService->process($customer, $amount);

        $this->assertTrue($result);
    }

    #[Test]
    public function it_sends_receipt_email_when_invoice_is_processed(): void
    {
        $salesTaxServiceMock = $this->createMock(SalesTaxService::class);
        $gatewayServiceMock = $this->createMock(StripePayment::class);
        $emailServiceMock = $this->createMock(EmailService::class);

        //Stub the method to return true
        $gatewayServiceMock->method('charge')->willReturn(true);

        $emailServiceMock
            ->expects($this->once())
            ->method('send')
            ->with(['name' => 'John'], 'Receipt');

        $invoiceService = new InvoiceService(
            $salesTaxServiceMock,
            $gatewayServiceMock,
            $emailServiceMock
        );
        $customer = ['name' => 'John'];
        $amount = 100;

        $result = $invoiceService->process($customer, $amount);

        $this->assertTrue($result);
    }
}