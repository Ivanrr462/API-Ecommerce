<?php

namespace App\Http\Controllers\Api;
use Illuminate\Support\Facades\Storage; 

use App\Http\Controllers\Controller;
use App\Models\Producto;
use App\Http\Resources\ProductoResource;
use Illuminate\Http\Request;

class ProductoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $productos = Producto::with('categoria', 'productoEspecificaciones.especificacion')->get();
        return ProductoResource::collection($productos);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nombre' => 'required|string|max:255',
            'precio' => 'required|integer|min:1',
            'descripcion' => 'nullable|string|max:255', //mirar como poner que no sea required y poner valor por defecto
            'categoria_id' => 'required|integer|min:1',
            'foto' => 'required|image|max:4096', // 4MB
        ]);

        $path = $request->file('foto')->store('productos', 'r2');

        $producto = Producto::create([
            'nombre' => $validated['nombre'],
            'precio' => $validated['precio'],
            'descripcion' => $validated['descripcion'],
            'categoria_id' => $validated['categoria_id'],
            'foto' => $path, // guardamos la clave
        ]);


        return response()->json([
            'mensaje' => 'Producto creado con éxito',
            'data' => new ProductoResource($producto->load('categoria', 'productoEspecificaciones.especificacion'))
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $producto = Producto::with('categoria', 'productoEspecificaciones.especificacion')->find($id);

        if (!$producto) {
            return response()->json(['error' => 'No encontrado'], 404);
        }

        return new ProductoResource($producto);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $producto = Producto::find($id);

        if (!$producto) {
            return response()->json(['error' => 'No encontrado'], 404);
        }

        $validated = $request->validate([
            'nombre' => 'nullable|string|max:255',
            'precio' => 'nullable|integer|min:1',
            'descripcion' => 'nullable|string|max:255',
            'categoria_id' => 'nullable|integer|min:1',
            'stock' => 'nullable|integer|min:0',
            'foto' => 'nullable|image|max:4096', // ← ahora opcional
        ]);


        // Si hay nueva foto, la subimos
        if ($request->hasFile('foto')) {

            // Borrar foto antigua si existe
            if ($producto->foto) {
                Storage::disk('r2')->delete($producto->foto);
            }

            // Subir nueva
            $path = $request->file('foto')->store('productos', 'r2');
            $validated['foto'] = $path;
        }

        // Actualizar producto
        $producto->update($validated);

        return response()->json([
            'mensaje' => 'Actualizado correctamente',
            'data' => new ProductoResource(
                $producto->load('categoria', 'productoEspecificaciones.especificacion')
            )
        ], 200);
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $producto = Producto::find($id);

        if (!$producto) {
            return response()->json(['error' => 'No encontrado'], 404);
        }

        // Borrar foto del bucket
        if ($producto->foto) {
            Storage::disk('r2')->delete($producto->foto);
        }

        $producto->delete();

        return response()->json(['mensaje' => 'Eliminado correctamente'], 200);
    }
}
