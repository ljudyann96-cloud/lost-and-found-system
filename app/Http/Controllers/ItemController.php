<?php

namespace App\Http\Controllers;

use App\Models\Item;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ItemController extends Controller
{
    public function index(Request $request)
    {
        $items = Item::with('user')->latest()->get();

        // Kung gikan sa Postman o API route gi-access, ihatag ang JSON
        if ($request->is('api/*') || $request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Nakuha ang tanang items.',
                'data' => $items
            ]);
        }

        // Kung gikan sa Web Browser, i-return ang Blade View
        return view('items.index', compact('items'));
    }

    public function create(Request $request)
    {
        if ($request->is('api/*') || $request->wantsJson()) {
            return response()->json(['message' => 'API create not supported directly.'], 400);
        }

        return view('items.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'item_name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'location_lost' => 'required|string|max:255',
            'image' => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('items', 'public');
            $validated['image'] = $path;
        }

        $validated['user_id'] = auth()->id() ?? 1;
        $validated['status'] = 'Pending';

        $item = Item::create($validated);

        // Kung gikan sa Postman (API)
        if ($request->is('api/*') || $request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Na-save na ang item.',
                'data' => $item
            ], 201);
        }

        // Kung gikan sa Browser form submission, i-redirect sa web page
        return redirect()->route('items.index')->with('success', 'Matagumpay na nga na-report ang item!');
    }

    // ==========================================
    // GI-APIL DINHI ANG KULANG NGA UPDATE METHOD
    // ==========================================
    public function update(Request $request, Item $item)
    {
        $validated = $request->validate([
            'item_name' => 'sometimes|required|string|max:255',
            'description' => 'nullable|string',
            'location_lost' => 'sometimes|required|string|max:255',
            'date_lost' => 'nullable|string',
            'name_reporter' => 'nullable|string|max:255',
            'contact_number' => 'nullable|string|max:255',
            'image' => 'nullable|image|max:2048',
        ]);

        // Kung naay gi-upload nga bag-ong image
        if ($request->hasFile('image')) {
            if ($item->image && Storage::disk('public')->exists($item->image)) {
                Storage::disk('public')->delete($item->image);
            }

            $path = $request->file('image')->store('items', 'public');
            $validated['image'] = $path;
        }

        $item->update($validated);

        if ($request->is('api/*') || $request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Na-update na ang item nang malampuson!',
                'data' => $item
            ], 200);
        }

        return redirect()->route('items.index')->with('success', 'Na-update na ang item!');
    }

    public function updateStatus(Request $request, Item $item)
    {
        $request->validate([
            'status' => 'required|in:Pending,Found,Claimed'
        ]);

        $item->update(['status' => $request->status]);

        if ($request->is('api/*') || $request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Na-update na ang status sa item.',
                'data' => $item
            ]);
        }

        return redirect()->route('items.index')->with('success', 'Na-update na ang status!');
    }

    public function destroy(Request $request, Item $item)
    {
        if ($item->image) {
            Storage::disk('public')->delete($item->image);
        }

        $item->delete();

        if ($request->is('api/*') || $request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Na-delete na ang item.'
            ]);
        }

        return redirect()->route('items.index')->with('success', 'Na-delete na ang item!');
    }
}