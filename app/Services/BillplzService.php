<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class BillplzService
{
    protected string $baseUrl;
    protected string $secretKey;
    protected string $collectionId;

    public function __construct()
    {
        $this->baseUrl = config('services.billplz.base_url');
        $this->secretKey = config('services.billplz.secret_key');
        $this->collectionId = config('services.billplz.collection_id');
    }

    /**
     * Create a bill for an order and return the Billplz response
     * (includes 'url' to redirect the customer to for payment).
     */
    public function createBill(array $data): array
    {
        $response = Http::withBasicAuth($this->secretKey, '')
            ->asForm()
            ->post("{$this->baseUrl}/v3/bills", [
                'collection_id' => $this->collectionId,
                'email' => $data['email'],
                'name' => $data['name'],
                'amount' => $data['amount'], // in cents, e.g. RM10.50 = 1050
                'callback_url' => $data['callback_url'],
                'redirect_url' => $data['redirect_url'],
                'description' => $data['description'],
                'reference_1_label' => 'Order Number',
                'reference_1' => $data['order_number'],
            ]);

        if ($response->failed()) {
            Log::error('Billplz bill creation failed', [
                'status' => $response->status(),
                'body' => $response->body(),
            ]);
            throw new \Exception('Unable to create payment bill: ' . $response->body());
        }

        return $response->json();
    }

    /**
     * Fetch a bill's current status directly from Billplz
     * (used to double-check payment status on callback/redirect).
     */
    public function getBill(string $billId): array
    {
        $response = Http::withBasicAuth($this->secretKey, '')
            ->get("{$this->baseUrl}/v3/bills/{$billId}");

        if ($response->failed()) {
            throw new \Exception('Unable to fetch bill: ' . $response->body());
        }

        return $response->json();
    }
}