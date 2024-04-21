<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;

class ProductController extends Controller
{
    // Afficher la liste des produits
    public function index()
    {
        $products = Product::paginate(30);
        $categories = Category::all();
        return view('admin.products.index', compact('products', 'categories'));
    }

    // Afficher le formulaire pour créer un nouveau produit
    public function create()
    {
        $categories = Category::all();
        return view('admin.products.create', compact('categories'));
    }

    // Enregistrer un nouveau produit
// ProductController.php

// Enregistrer un nouveau produit
public function store(Request $request)
{

        // Valider les données du formulaire
        $validatedData = $request->validate([
            'name' => 'required|string',
            'description' => 'required|string',
            'price' => 'required|numeric',
            'categories' => 'required|array',
            'categories.*' => 'exists:categories,id',
            'is_promotion' => 'nullable|in:on,null',
            'discount_percentage' => 'nullable|numeric|min:0|max:100',
            'image' => 'nullable|image|mimes:jpeg,png,jpg',
            'discounted_price' => 'nullable|numeric',
        ]);

        // Créer le nouveau produit
        $product = new Product();
        $product->name = $validatedData['name'];
        $product->description = $validatedData['description'];
        $product->price = $validatedData['price'];


        // Vérifier si la promotion est activée
        $product->is_promotion = $request->has('is_promotion');

        if ($product->is_promotion) {
            $product->discount_percentage = $validatedData['discount_percentage'];
            $product->discounted_price = $validatedData['discounted_price'];
        }


        // Sauvegarder l'image si elle est présente
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('images/products', 'public');
            $product->image = 'storage/' . $imagePath;
        }

        $product->save();

        // Attacher les catégories au produit
        $product->categories()->attach($validatedData['categories']);

        // Rediriger vers la page de création avec un message de succès
        return redirect()->route('products.create')->with('success', 'Produit créé avec succès.');
}


    // Afficher le formulaire pour modifier un produit
    public function edit(Product $product)
    {
        return view('admin.products.edit', compact('product'));
    }

    // Mettre à jour un produit existant
    public function update(Request $request, Product $product)
    {
        $request->validate([
            'name' => 'required',
            'description' => 'required',
            'price' => 'required|numeric',
            // Ajoutez d'autres règles de validation au besoin
        ]);

        $product->update($request->all());

        return redirect()->route('products.index')->with('success', 'Produit mis à jour avec succès.');
    }

    // Supprimer un produit existant
    public function destroy(Product $product)
    {
        $product->delete();

        return redirect()->route('products.index')->with('success', 'Produit supprimé avec succès.');
    }

    public function show($id)
{
    $product = Product::findOrFail($id);
    return view('show', ['product' => $product]);
}


}

