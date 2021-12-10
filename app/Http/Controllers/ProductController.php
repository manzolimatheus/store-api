<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use Exception;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    public $key;

    function __construct()
    {
        $this->key = "laravel";
    }


    public function get($key)
    {
        switch ($key) {
            case $this->key:
                $products = DB::table('products')
                ->join('tags', 'id_tag', '=', 'tags.id')
                ->select('products.*', 'tags.name as tag')
                ->paginate(9);

                return response()->json($products);
                break;

            default:
                return response()->json('Acesso negado!');
                break;
        }
    }

    public function getTag($key, $id_tag)
    {
        switch ($key) {
            case $this->key:

                $products = DB::table('products')
                ->join('tags', 'id_tag', '=', 'tags.id')
                ->select('products.*', 'tags.name as tag')
                ->where('id_tag', $id_tag)
                ->paginate(9);

                return response()->json($products);
                break;

            default:
                return response()->json('Acesso negado!');
                break;
        }
    }

    public function create(Request $request, $key)
    {
        switch ($key) {
            case $this->key:
                try {
                    $product = new Product();

                    $product->name = $request->name;
                    $product->price = $request->price;
                    $product->perishable = $request->perishable;
                    $product->id_tag = $request->id_tag;
                    $product->image = $request->image;
                    $product->save();

                    return response()->json(['message' => 'Produto salvo com sucesso!', 'status' => 201]);
                } catch (Exception $e) {
                    return response()->json('Erro ao cadastrar o produto!' . $e, 500);
                }
                break;

            default:
                return response()->json('Acesso negado!');
                break;
        }
    }

    public function update($key, $id, Request $request)
    {
        switch ($key) {
            case $this->key:
                try {

                    $product = Product::findOrFail($id);

                    $product->update($request->all());

                    return response()->json(['message' => 'Dados atualizados com sucesso!', 'status' => 201]);
                } catch (Exception $e) {
                    return response()->json(['message' => 'Erro ao atualizar produto!', 'status' => 500]);
                }
                break;

            default:
                return response()->json('Acesso negado!');
                break;
        }
    }

    public function delete($key, $id)
    {
        switch ($key) {
            case $this->key:
                try {

                    $product = Product::findOrFail($id);

                    $product->delete();

                    return response()->json(['message' => 'Produto deletado com sucesso!', 'status' => 201]);
                } catch (Exception $e) {
                    return response()->json(['message' => 'Erro ao deletar produto!','status' => 500]);
                }
                break;

            default:
                return response()->json('Acesso negado!');
                break;
        }
    }
}
