<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\Registry;
use Illuminate\Http\Request;
//use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\Http\Resources\RegistryResource;
use App\Services\ApiService;

/**
 * @OA\Info(
 *     title="Mon API",
 *     version="1.0.0",
 *     description="Description de mon API"
 * )
 */
class RegistryController extends Controller
{
/**
 * @OA\Get(
 *     path="/api/v1/registry",
 *     tags={"Registries"},
 *     summary="List all items in the registry",
 *     security={{"bearerAuth":{}}},
 *     @OA\Response(
 *         response=200,
 *         description="Successful operation",
 *         @OA\JsonContent(
 *             type="array",
 *             @OA\Items(
 *                 type="object",
 *             )
 *         )
 *     ),
 *     @OA\Response(
 *         response=401,
 *         description="Unauthorized"
 *     )
 * )
 */
    public function index()
    {
        try {
            $registries = RegistryResource::collection(Registry::all());
            return ApiService::response($registries);
        } catch (\Exception $e) {
            return ApiService::response(['message' => __('messages.error_retrieving_registries')], 500);
        }
    }

    /**
     * @OA\Post(
     *     path="/api/v1/registries",
     *     tags={"Registries"},
     *     summary="Create a new registry",
     *     security={{"bearerAuth":{}}},
     *     @OA\RequestBody(
     *         required=true,
     *         description="Registry data",
     *         @OA\JsonContent(
     *             @OA\Property(property="name", type="string", example="Registry Name"),
     *             @OA\Property(property="description", type="string", example="Registry Description")
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Registry created successfully",
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Invalid input"
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Validation error"
     *     )
     * )
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'description' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            return ApiService::response($validator->errors(), 422);
        }

        try {
            $registry = Registry::create($request->all());
            return ApiService::response(new RegistryResource($registry), 201);
        } catch (\Exception $e) {
            return ApiService::response(['error' => __('messages.registry_creation_failed')], 500);
        }
    }

    /**
     * @OA\Get(
     *     path="/api/v1/registries/{id}",
     *     tags={"Registries"},
     *     summary="Get a specific registry by ID",
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Registry not found"
     *     )
     * )
     */
    public function show($id)
    {
        try {
            $registry = Registry::findOrFail($id);
            return ApiService::response(new RegistryResource($registry));
        } catch (\Exception $e) {
            return ApiService::response(['message' => __('messages.registry_not_found')], 404);
        }
    }

    /**
     * @OA\Put(
     *     path="/api/v1/registries/{id}",
     *     tags={"Registries"},
     *     summary="Update a registry",
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         description="Registry data",
     *         @OA\JsonContent(
     *             @OA\Property(property="name", type="string", example="Updated Registry Name"),
     *             @OA\Property(property="description", type="string", example="Updated Registry Description")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Registry updated successfully",
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Invalid input"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Registry not found"
     *     )
     * )
     */
    public function update(Request $request, $id)
    {
        try {
            $registry = Registry::findOrFail($id);
            $validator = Validator::make($request->all(), [
                'name' => 'sometimes|string|max:255',
                'description' => 'sometimes|string|max:255',
            ]);

            if ($validator->fails()) {
                return ApiService::response($validator->errors(), 422);
            }

            $registry->update($request->all());
            return ApiService::response(new RegistryResource($registry));
        } catch (\Exception $e) {
            return ApiService::response(['message' => __('messages.error_updating_registry')], 500);
        }
    }

    /**
     * @OA\Delete(
     *     path="/api/v1/registries/{id}",
     *     tags={"Registries"},
     *     summary="Delete a registry",
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Registry deleted successfully"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Registry not found"
     *     )
     * )
     */
    public function destroy($id)
    {
        try {
            $registry = Registry::findOrFail($id);
            $registry->delete();
            return ApiService::response(['message' => __('messages.registry_deleted_success')], 200);
        } catch (\Exception $e) {
            return ApiService::response(['message' => __('messages.error_deleting_registry')], 500);
        }
    }
}
