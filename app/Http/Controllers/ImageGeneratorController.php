<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Image;
use App\Services\ImageGeneratorService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ImageGeneratorController extends Controller
{
    private $imageService;

    public function __construct(ImageGeneratorService $imageService)
    {
        $this->imageService = $imageService;
    }

    public function index($id)
    {
        $client = Client::where('highlevel_id', $id)->first();
        if (!$client || !$id) {
            return view('clients.client_404');
        }
            $images = $client->images;
        // $images = $this->imageService->getImages();
        return view('single.index_guest', compact('images', 'id'));
    }

    public function rename(Request $request, $id)
    {
        $image = Image::find($id);

        if (!$image) {
            return response()->json(['success' => false, 'message' => 'Image not found'], 404);
        }

        $image->nombre = $request->input('name');
        $image->save();

        return response()->json(['success' => true, 'message' => 'Image renamed successfully', 'image' => $image]);
    }



    public function generate(Request $request, $id)
    {
        // Buscar el cliente por su highlevel_id
        $client = Client::where('highlevel_id', $id)->first();
    
        // Si el cliente no existe, devolver una vista de error 404
        if (!$client || !$id) {
            return view('clients.client_404');
        }
    
        // Validar los datos de entrada
        $validator = Validator::make($request->all(), [
            'prompt' => 'required|string',
            'output_format' => 'required|in:jpeg,png,webp',
            'aspect_ratio' => 'nullable|in:16:9,1:1,21:9,2:3,3:2,4:5,5:4,9:16,9:21', // Validar aspect_ratio
        ]);
    
        // Si la validación falla, devolver errores
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors(),
            ], 422);
        }
    
        // Obtener el tipo de selección
        $selectionType = $request->selectionType ?? 'single';
    
        // Lógica para generar una sola imagen
        if ($selectionType === 'single') {
            return $this->generateSingleImage($request, $client);
        }
    
        // Lógica para generar múltiples imágenes con diferentes tipos de IA
        if ($selectionType === 'multiple') {
            return $this->generateMultipleImages($request, $client);
        }
    
        // Si el tipo de selección no es válido
        return response()->json([
            'success' => false,
            'message' => 'Invalid selection type.',
        ], 400);
    }
    
    /**
     * Genera una sola imagen.
     *
     * @param Request $request
     * @param Client $client
     * @return \Illuminate\Http\JsonResponse
     */
    private function generateSingleImage(Request $request, Client $client)
    {
        // Generar la imagen
        $result = $this->imageService->generateImage(
            $request->prompt,
            $request->ai_type ?? 'sd3', // Tipo de IA (por defecto SD3)
            $request->output_format,
            $request->aspect_ratio ?? '1:1' // Aspect ratio (por defecto 1:1)
        );
    
        // Si la generación de la imagen fue exitosa, guardarla en la base de datos
        if ($result['success']) {
            Image::create([
                'nombre' => $result['filename'],
                'filename' => $result['path'],
                'client_id' => $client->id,
            ]);
    
            return response()->json([
                'success' => true,
                'data' => $result,
            ]);
        }
    
        // Si hubo un error, devolver el mensaje de error
        return response()->json([
            'success' => false,
            'error' => $result['error'],
        ], 500);
    }
    
    /**
     * Genera múltiples imágenes con diferentes tipos de IA.
     *
     * @param Request $request
     * @param Client $client
     * @return \Illuminate\Http\JsonResponse
     */
    private function generateMultipleImages(Request $request, Client $client)
    {
        // Tipos de IA a utilizar
        $aiTypes = ['sd3', 'core', 'ultra'];
    
        // Generar imágenes de manera concurrente
        $results = $this->imageService->generateImagesConcurrently(
            $request->prompt,
            $aiTypes,
            $request->output_format,
            $request->aspect_ratio ?? '1:1' // Aspect ratio (por defecto 1:1)
        );
    
        // Guardar las imágenes en la base de datos
        foreach ($results as $aiType => $result) {
            if ($result['success']) {
                Image::create([
                    'nombre' => $result['filename'],
                    'filename' => $result['path'],
                    'client_id' => $client->id,
                ]);
            }
        }
    
        return response()->json([
            'success' => true,
            'data' => $results,
        ]);
    }
    // Buscar la imagen por su ID
    public function delete(Request $request, $id)
    {
        // Buscar la imagen por su ID
        $image = Image::find($id);

        // Si la imagen no existe, devolver un error
        if (!$image) {
            return response()->json([
                'success' => false,
                'message' => 'Image not found.',
            ], 404);
        }

        // Marcar la imagen como eliminada (Soft Delete)
        $image->delete();

        return response()->json([
            'success' => true,
            'message' => 'Image soft deleted successfully.',
        ]);
    }
}
