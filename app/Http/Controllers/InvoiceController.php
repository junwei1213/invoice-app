<?php


namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Invoice;
use App\Models\InvoiceItem;
use App\Models\Customer;
use Inertia\Inertia;
use Illuminate\Support\Facades\DB;

class InvoiceController extends Controller
{
    public function index()
    {
        $invoices = Invoice::latest()->paginate(10);
        return Inertia::render('Invoices/Index', [
            'invoices' => $invoices
        ]);
    }

    public function create()
    {
        return Inertia::render('Invoices/Create', [
            'customers' => Customer::all()
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'customer_id' => 'required|exists:customers,id',
            'invoice_date' => 'required|date',
            'items' => 'required|array|min:1',
            'items.*.product_name' => 'required|string',
            'items.*.quantity' => 'required|integer|min:1',
            'items.*.price' => 'required|numeric|min:0',
        ]);

        DB::transaction(function () use ($validated) {
            $totalAmount = collect($validated['items'])->sum(function($item) {
                return $item['quantity'] * $item['price'];
            });
            $invoice = Invoice::create([
                'customer_id' => $validated['customer_id'],
                'invoice_date' => $validated['invoice_date'],
                'total_amount' => $totalAmount,
            ]);

            foreach ($validated['items'] as $item) {
                $invoice->items()->create([
                    'product_name' => $item['product_name'],
                    'quantity' => $item['quantity'],
                    'price' => $item['price'],
                    'subtotal' => $item['quantity'] * $item['price'],
                ]);
            }
        });

        return redirect()->route('invoices.index');
    }
}