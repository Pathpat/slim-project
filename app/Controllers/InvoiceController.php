<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Services\InvoiceService;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Views\Twig;

class InvoiceController
{
    public function __construct(private InvoiceService $invoiceService)
    {
    }

    public function index(Request $request, Response $response, $args): Response
    {
//        $invoices = Invoice::query()
//            ->where('status', InvoiceStatus::Paid)
//            ->get()
//            ->map(fn(Invoice $invoice) => [
//                'invoiceNumber' => $invoice->invoice_number,
//                'amount'        => $invoice->amount,
//                'status'        => $invoice->status->toString(),
//                'statusColor'   => $invoice->status->color()->getClass(),
//                'dueDate'       => $invoice->due_date->toDateTimeString(),
//            ]);
//
//        return $this->twig->render('invoices/index.twig', ['invoices' => $invoices]);


        return Twig::fromRequest($request)
            ->render(
                $response,
                'invoices/index.twig',
            ['invoices' => $this->invoiceService->getPaidInvoices()]);
    }
}