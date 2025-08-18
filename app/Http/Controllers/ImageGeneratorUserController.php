<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\ImageUser;
use App\Services\ImageGeneratorService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class ImageGeneratorUserController extends Controller
{
    private $imageService;

    public function __construct(ImageGeneratorService $imageService)
    {
        $this->imageService = $imageService;
    }

    public function index()
    {
        $user = Auth::user();
        $images = $user->imagesGenerated->sortByDesc('created_at')->values()->toArray();
        return view('single.index', compact('images'));
    }

    public function generate(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'prompt' => 'required|string',
            'output_format' => 'required|in:jpeg,png,webp',
            'aspect_ratio' => 'nullable|in:16:9,1:1,21:9,2:3,3:2,4:5,5:4,9:16,9:21',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors(),
            ], 422);
        }

        $selectionType = $request->selectionType ?? 'single';

        if ($selectionType === 'single') {
            return $this->generateSingleImage($request);
        }

        if ($selectionType === 'multiple') {
            return $this->generateMultipleImages($request);
        }

        return response()->json([
            'success' => false,
            'message' => 'Invalid selection type.',
        ], 400);
    }

    private function generateSingleImage(Request $request)
    {
        $result = $this->imageService->generateImage(
            $request->prompt,
            $request->ai_type ?? 'sd3',
            $request->output_format,
            $request->aspect_ratio ?? '1:1'
        );

        if ($result['success']) {
            ImageUser::create([
                'nombre' => $result['filename'],
                'filename' => $result['path'],
                'user_id' => auth()->id(),
            ]);

            return response()->json([
                'success' => true,
                'data' => $result,
            ]);
        }

        return response()->json([
            'success' => false,
            'error' => $result['error'],
        ], 500);
    }

    private function generateMultipleImages(Request $request)
    {
        $aiTypes = ['sd3', 'core', 'ultra'];

        $results = $this->imageService->generateImagesConcurrently(
            $request->prompt,
            $aiTypes,
            $request->output_format,
            $request->aspect_ratio ?? '1:1'
        );

        foreach ($results as $aiType => $result) {
            if ($result['success']) {
                ImageUser::create([
                    'nombre' => $result['filename'],
                    'filename' => $result['path'],
                    'user_id' => auth()->id(),
                ]);
            }
        }

        return response()->json([
            'success' => true,
            'data' => $results,
        ]);
    }

    public function delete(Request $request, $id)
    {
        $image = ImageUser::find($id);

        if (!$image) {
            return response()->json([
                'success' => false,
                'message' => 'Image not found.',
            ], 404);
        }

        $image->delete();

        return response()->json([
            'success' => true,
            'message' => 'Image deleted successfully.',
        ]);
    }

    public function rename(Request $request, $id)
    {
        $image = ImageUser::find($id);

        if (!$image) {
            return response()->json([
                'success' => false,
                'message' => 'Image not found.',
            ], 404);
        }

        $image->nombre = $request->input('name');
        $image->save();

        return response()->json([
            'success' => true,
            'message' => 'Image renamed successfully.',
            'image' => $image
        ]);
    }
}
