<?php

namespace App\Http\Controllers;

use App\Models\Magazine;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index()
    {
        //
    }

public function chart()
{
    $paid = Order::where('status', 'paid')->count();
    $pending = Order::where('status', 'pending')->count();

    return response()->json([
        'data' => [$paid, $pending]
    ]);
}





    public function create()
    {
        //
    }

    /**
     * Store order baru
     */
    public function store(Request $request)
    {
        $magazine = Magazine::findOrFail($request->magazine_id);

        // Di dalam store method OrdersController
        $order = Order::create([
            'user_id' => $request->user_id,
            'magazine_id' => $request->magazine_id,
            'total_price' => $request->total_price, // Ini sudah harga diskon
            'quantity' => $request->quantity,
            'purchase_history' => $request->purchase_history,
            'payment' => 'pending',
        ]);

        // Cek kalau request AJAX
        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Order created successfully',
                'data' => $order
            ]);
        }

        return redirect()->route('orders.paymentPage', $order->id);
    }

    /**
     * Halaman pembayaran
     */
    public function paymentPage($orderId)
    {
        // Tambahkan with() untuk eager loading
        $order = Order::with('magazine')->findOrFail($orderId);
        return view('showmagazine.payment', compact('order'));
    }

    /**
     * Halaman bukti pembayaran
     */
    public function paymentProof($id)
    {
        // Gunakan findOrFail dengan eager loading
        $order = Order::with('magazine')->findOrFail($id);

        // Update status pembayaran
        $order->update([
            'payment' => 'paid',
            'paid_at' => now(),
        ]);

        return view('showmagazine.proof-payment', compact('order'));
    }

    /**
     * Upload bukti pembayaran
     */
    public function uploadPaymentProof(Request $request, $orderId)
    {
        $order = Order::findOrFail($orderId);

        $request->validate([
            'proof' => 'required|image|max:2048',
        ]);

        $filename = time() . '.' . $request->proof->extension();
        $request->proof->move(public_path('payment_proofs'), $filename);

        $order->payment_proof = $filename;
        $order->payment = 'paid'; // Ubah ini dari 'status' ke 'payment'
        $order->save();

        return redirect()->route('orders.paymentProof', $orderId)
                         ->with('success', 'Bukti pembayaran berhasil diunggah!');
    }

    /**
     * Tandai lunas oleh admin (opsional)
     */
    public function markAsPaid($id)
    {
        $order = Order::findOrFail($id);

        $order->update([
            'payment' => 'paid',
            'paid_at' => now(),
            'purchase_history' => $order->purchase_history . ' | STATUS: Lunas',
        ]);

        return redirect()->route('orders.paymentProof', $order->id)
                         ->with('success', 'Pembayaran berhasil dikonfirmasi!');
    }

    /**
     * Show detail pembayaran
     */
    public function show($id)
    {
        $order = Order::with('magazine')->findOrFail($id);
        return view('showmagazine.payment', compact('order'));
    }

    /**
     * Bayar manual
     */
    public function pay($id)
    {
        $order = Order::with('magazine')->findOrFail($id);

        $order->payment = 'paid';
        $order->save();

        return redirect()->route('orders.paymentProof', $order->id)
                         ->with('success', 'Pembayaran berhasil!');
    }

    public function myOrders()
{
    $orders = Order::with('magazine')
                  ->where('user_id', Auth::id())
                  ->orderBy('created_at', 'desc')
                  ->get();

    return view('magazine.index', compact('orders'));
}

    public function edit(Order $order) {}
    public function update(Request $request, Order $order) {}
    public function destroy(Order $order) {}
}
