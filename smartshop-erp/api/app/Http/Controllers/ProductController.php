<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    /**
     * Get all products with pagination
     */
    public function index(Request $request): JsonResponse
    {
        $query = Product::with(['category', 'brand', 'images'])
            ->where('status', 'active');

        // Search
        if ($request->has('search')) {
            $query->where('name', 'like', '%' . $request->search . '%')
                ->orWhere('description', 'like', '%' . $request->search . '%');
        }

        // Category filter
        if ($request->has('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        // Price range filter
        if ($request->has('min_price')) {
            $query->where('price', '>=', $request->min_price);
        }
        if ($request->has('max_price')) {
            $query->where('price', '<=', $request->max_price);
        }

        // Sort
        $sortBy = $request->get('sort_by', 'created_at');
        $sortOrder = $request->get('sort_order', 'desc');
        $query->orderBy($sortBy, $sortOrder);

        $products = $query->paginate($request->get('per_page', 12));

        return response()->json([
            'success' => true,
            'data' => $products
        ]);
    }

    /**
     * Get featured products
     */
    public function featured(): JsonResponse
    {
        $products = Product::with(['category', 'brand', 'images'])
            ->where('status', 'active')
            ->where('featured', true)
            ->latest()
            ->take(8)
            ->get();

        return response()->json([
            'success' => true,
            'data' => $products
        ]);
    }

    /**
     * Get single product
     */
    public function show($id): JsonResponse
    {
        $product = Product::with(['category', 'brand', 'images', 'reviews.user', 'tags'])
            ->where('status', 'active')
            ->findOrFail($id);

        // Increment view count
        $product->increment('views_count');

        return response()->json([
            'success' => true,
            'data' => $product
        ]);
    }

    /**
     * Store new product (Admin only)
     */
    public function store(Request $request): JsonResponse
    {
        $this->authorize('create', Product::class);

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'short_description' => 'nullable|string|max:500',
            'sku' => 'required|string|unique:products',
            'price' => 'required|numeric|min:0',
            'sale_price' => 'nullable|numeric|min:0|lt:price',
            'cost_price' => 'nullable|numeric|min:0',
            'stock_quantity' => 'required|integer|min:0',
            'min_stock_quantity' => 'nullable|integer|min:0',
            'weight' => 'nullable|numeric|min:0',
            'dimensions' => 'nullable|string',
            'category_id' => 'required|exists:categories,id',
            'brand_id' => 'nullable|exists:brands,id',
            'status' => 'required|in:active,inactive,draft',
            'featured' => 'boolean',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:500',
            'meta_keywords' => 'nullable|string',
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        $product = Product::create($request->except(['images']));

        // Handle images upload
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $path = $image->store('products', 'public');
                $product->images()->create([
                    'image_path' => $path,
                    'is_primary' => $product->images()->count() === 0
                ]);
            }
        }

        return response()->json([
            'success' => true,
            'message' => 'Product created successfully',
            'data' => $product->load(['category', 'brand', 'images'])
        ], 201);
    }

    /**
     * Update product (Admin only)
     */
    public function update(Request $request, $id): JsonResponse
    {
        $product = Product::findOrFail($id);
        $this->authorize('update', $product);

        $validator = Validator::make($request->all(), [
            'name' => 'sometimes|required|string|max:255',
            'description' => 'sometimes|required|string',
            'short_description' => 'nullable|string|max:500',
            'sku' => 'sometimes|required|string|unique:products,sku,' . $id,
            'price' => 'sometimes|required|numeric|min:0',
            'sale_price' => 'nullable|numeric|min:0|lt:price',
            'cost_price' => 'nullable|numeric|min:0',
            'stock_quantity' => 'sometimes|required|integer|min:0',
            'min_stock_quantity' => 'nullable|integer|min:0',
            'weight' => 'nullable|numeric|min:0',
            'dimensions' => 'nullable|string',
            'category_id' => 'sometimes|required|exists:categories,id',
            'brand_id' => 'nullable|exists:brands,id',
            'status' => 'sometimes|required|in:active,inactive,draft',
            'featured' => 'boolean',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:500',
            'meta_keywords' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        $product->update($request->except(['images']));

        return response()->json([
            'success' => true,
            'message' => 'Product updated successfully',
            'data' => $product->load(['category', 'brand', 'images'])
        ]);
    }

    /**
     * Delete product (Admin only)
     */
    public function destroy($id): JsonResponse
    {
        $product = Product::findOrFail($id);
        $this->authorize('delete', $product);

        // Delete associated images
        foreach ($product->images as $image) {
            Storage::disk('public')->delete($image->image_path);
            $image->delete();
        }

        $product->delete();

        return response()->json([
            'success' => true,
            'message' => 'Product deleted successfully'
        ]);
    }

    /**
     * Get related products
     */
    public function related($id): JsonResponse
    {
        $product = Product::findOrFail($id);

        $relatedProducts = Product::with(['category', 'brand', 'images'])
            ->where('status', 'active')
            ->where('id', '!=', $id)
            ->where('category_id', $product->category_id)
            ->orWhere('brand_id', $product->brand_id)
            ->inRandomOrder()
            ->take(4)
            ->get();

        return response()->json([
            'success' => true,
            'data' => $relatedProducts
        ]);
    }
}
