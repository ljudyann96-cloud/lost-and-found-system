<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Item;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;

class ItemApiController extends Controller
{
    // READ (All): Kunin ang tanang items
    public function index()
    {
        $items = Item::with('user')->latest()->get();
        return response()->json([
            'success' => true,
            'message' => 'Nakuha ang tanang items.',
            'data' => $items
        ], 200);
    }

    // CREATE: Magdagdag og bag-ong item record
    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'item_name' => 'required|string|max:255',
                'description' => 'required|string',
                'location_lost' => 'required|string|max:255',
                'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
                'status' => 'sometimes|in:Pending,Found,Claimed'
            ]);

            $imagePath = null;
            if ($request->hasFile('image')) {
                $imagePath = $request->file('image')->store('items', 'public');
            }

            $item = Item::create([
                'user_id' => $request->user_id ?? 1, // Default user ID
                'item_name' => $validated['item_name'],
                'description' => $validated['description'],
                'location_lost' => $validated['location_lost'],
                'status' => $validated['status'] ?? 'Pending',
                'image' => $imagePath,
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Matagumpay na na-rehistro ang nawalang item.',
                'data' => $item
            ], 201);

        } catch (ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'May error sa pag-validate sa mga datos.',
                'errors' => $e->errors()
            ], 422);
        }
    }

    // READ (One): Kunin ang usa ka tiyak nga item gamit ang ID
    public function show($id)
    {
        $item = Item::with('user')->find($id);

        if (!$item) {
            return response()->json([
                'success' => false,
                'message' => 'Wala makit-i ang giingong item.'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $item
        ], 200);
    }

    // UPDATE: Usba o i-update ang umiiral nga record
    public function update(Request $request, $id)
    {
        $item = Item::find($id);

        if (!$item) {
            return response()->json([
                'success' => false,
                'message' => 'Wala makit-i ang item nga i-update.'
            ], 404);
        }

        try {
            $validated = $request->validate([
                'item_name' => 'sometimes|required|string|max:255',
                'description' => 'sometimes|required|string',
                'location_lost' => 'sometimes|required|string|max:255',
                'status' => 'sometimes|in:Pending,Found,Claimed',
                'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            ]);

            if ($request->hasFile('image')) {
                if ($item->image && Storage::disk('public')->exists($item->image)) {
                    Storage::disk('public')->delete($item->image);
                }
                $item->image = $request->file('image')->store('items', 'public');
            }

            $item->update(array_filter([
                'item_name' => $validated['item_name'] ?? $item->item_name,
                'description' => $validated['description'] ?? $item->description,
                'location_lost' => $validated['location_lost'] ?? $item->location_lost,
                'status' => $validated['status'] ?? $item->status,
                'image' => $item->image,
            ]));

            return response()->json([
                'success' => true,
                'message' => 'Matagumpay na na-update ang item.',
                'data' => $item
            ], 200);

        } catch (ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'May error sa validation.',
                'errors' => $e->errors()
            ], 422);
        }
    }

    // DELETE: Tangtanga ang item record ug ang hulagway niini
    public function destroy($id)
    {
        $item = Item::find($id);

        if (!$item) {
            return response()->json([
                'success' => false,
                'message' => 'Wala makit-i ang item nga i-delete.'
            ], 404);
        }

        if ($item->image && Storage::disk('public')->exists($item->image)) {
            Storage::disk('public')->delete($item->image);
        }

        $item->delete();

        return response()->json([
            'success' => true,
            'message' => 'Matagumpay na na-delete ang item.'
        ], 200);
    }
}