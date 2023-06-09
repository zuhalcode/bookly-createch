<?php

namespace App\Http\Controllers\Admin;

use App\Models\AddOn;
use App\Models\Branch;
use App\Models\Company;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index($slug)
    {
        $company = Company::where('slug', $slug)->first();
        return view('dashboard.products.index', [
            'products' => $company->products,
            'slug' => $slug,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($slug)
    {
        return view('dashboard.products.create', ['slug' => $slug]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $req, $slug)
    {
        $company = Company::where('slug', $slug)->first();

        $validatedData = $req->validate([
            'name' => 'required|max:255',
            'price' => 'required',
            'addon.*' => 'required',
            'addon-price.*' => 'required|min:0',
            'description' => 'required',
            'image' => 'required|mimes:jpg,png,jpeg|image',
        ]);

        $product = new Product;

        // Save the Product image
        if ($req->hasFile('image')) {
            $image = $req->file('image');
            $filename = 'product-' . $company->id . '-' . time() . '.' . $image->getClientOriginalExtension();
            $image->storeAs('products', $filename);
            $product->image = "/storage/products/$filename";
        }

        $product->company_id = $company->id;
        $product->name = $validatedData['name'];
        $product->price = $validatedData['price'];
        $product->description = $validatedData['description'];
        $product->save();

        foreach ($validatedData['addon'] as $index => $addon) {
            $addonData = [
                'product_id' => $product->id,
                'name' => $addon,
                'price' => $validatedData['addon-price'][$index]
            ];
            AddOn::create($addonData);
        }

        return back()->with('success', 'Product added successfully.');
    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($slug, $id)
    {
        $product = Product::find($id);
        $addons = AddOn::where('product_id', $product->id)->get();

        return view('dashboard.products.edit', [
            'product' => $product,
            'addons' => $addons,
            'slug' => $slug,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $req, $slug, $id)
    {
        $company = Company::where('slug', $slug)->first();

        $validatedData = $req->validate([
            'name' => 'required|max:255',
            'price' => 'required',
            'addons_id.*' => 'required',
            'addons_name.*' => 'required',
            'addon-price.*' => 'required|min:0',
            'description' => 'required',
            'image' => 'nullable|mimes:jpg,png,jpeg|image',
        ]);

        $product = Product::find($id);

        // Update the Product image
        if ($req->hasFile('image')) {

            // Remove the previous image if it exists
            if ($product->image) {
                Storage::delete($product->image);
            }

            $image = $req->file('image');
            $filename = 'product-' . $company->id . '-' . time() . '.' . $image->getClientOriginalExtension();
            $image->storeAs('products', $filename);
            $product->image = "/storage/products/$filename";
        }

        $product->company_id = $company->id;
        $product->name = $validatedData['name'];
        $product->price = $validatedData['price'];
        $product->description = $validatedData['description'];
        $product->update();

        foreach ($validatedData['addons_id'] as $index => $addonId) {
            $addonData = [
                'name' => $validatedData['addons_name'][$index], // Updated array key to 'addons_name'
                'price' => $validatedData['addon-price'][$index]
            ];

            // Find the existing addon by ID
            $existingAddon = AddOn::find($addonId);

            if ($existingAddon) {
                // Update the existing addon
                $existingAddon->update($addonData);
            }
        }

        return redirect("/$slug/dashboard/products")->with('success', 'Product updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $product = Product::findOrFail($id);
        $product->delete();
        return back()->with('success', 'Product deleted successfully.');
    }

    public function storeBranchProducts(Request $req, $slug, $branchId)
    {
        $productIds = $req->input('products');

        // Retrieve the products by their IDs
        $products = Product::whereIn('id', $productIds)->get();
        $branch = Branch::findOrFail($branchId);

        // Attach the retrieved products to the branch if they are not already attached
        $branch->products()->syncWithoutDetaching($products);

        return back()->with('success', 'Products added successfully');
    }

    public function destroyBranchProduct(Request $req, $slug, $branchId)
    {
        $validatedData = $req->validate(['product_id' => 'required']);

        $branch = Branch::findOrFail($branchId);
        $branch->products()->detach($validatedData['product_id']);

        return back()->with('success', 'Product removed successfully');
    }
}
