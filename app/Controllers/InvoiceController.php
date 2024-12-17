<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Services\InvoiceService;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Views\Twig;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

class InvoiceController
{
    public function __construct(
        private readonly Twig $twig,
        private readonly InvoiceService $invoiceService
    ) {
    }

    /**
     * @throws SyntaxError
     * @throws RuntimeError
     * @throws LoaderError
     */
    public function index(Request $request, Response $response, $args): Response
    {
        return $this->twig->render(
            $response,
            'invoices/index.twig',
            ['invoices' => $this->invoiceService->getPaidInvoices()]
        );
    }
}