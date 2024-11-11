<?php

namespace App\Http\Controllers\Api\V1;

//use App\Http\Controllers\Controller;
use App\Http\Resources\AttributeCollection;
use App\Http\Resources\AttributeResource;
use App\Models\Attribute;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Services\ApiService;

class AttributeController extends Controller
{
/**
 * @OA\Get(
 *     path="/api/v1/attributes",
 *     tags={"Attributes"},
 *     summary="List all attributes",
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
 *         response=500,
 *         description="Internal server error"
 *     )
 * )
 */
    public function index()
    {
        try {
            $attributes = Attribute::all();
            return new AttributeCollection($attributes);
        } catch (\Exception $e) {
            return ApiService::response(['message' => __('messages.error_retrieving_attributes')], 500);
        }
    }

/**
 * @OA\Get(
 *     path="/api/v1/attributes/{id}",
 *     tags={"Attributes"},
 *     summary="Get a specific attribute by ID",
 *     security={{"bearerAuth":{}}},
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         description="ID of the attribute",
 *         @OA\Schema(type="integer")
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Successful operation",
 *     ),
 *     @OA\Response(
 *         response=404,
 *         description="Attribute not found"
 *     )
 * )
 */
    public function show($id)
    {
        try {
            $attribute = Attribute::findOrFail($id);
            return new AttributeResource($attribute);
        } catch (\Exception $e) {
            return ApiService::response(['message' => __('messages.attribute_not_found')], 404);
        }
    }

/**
 * @OA\Post(
 *     path="/api/v1/attributes",
 *     tags={"Attributes"},
 *     summary="Create a new attribute",
 *     security={{"bearerAuth":{}}},
 *     @OA\RequestBody(
 *         required=true,
 *         description="Attribute data",
 *         @OA\JsonContent(
 *             @OA\Property(property="name", type="string", example="Attribute Name"),
 *             @OA\Property(property="code", type="string", example="Attribute Code"),
 *             @OA\Property(property="type", type="string", example="varchar")
 *         )
 *     ),
 *     @OA\Response(
 *         response=201,
 *         description="Attribute created successfully",
 *     ),
 *     @OA\Response(
 *         response=422,
 *         description="Validation error"
 *     ),
 *     @OA\Response(
 *         response=500,
 *         description="Internal server error"
 *     )
 * )
 */

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:255',
            'type' => 'required|string|in:varchar,int,text,decimal',
        ]);

        if ($validator->fails()) {
            return ApiService::response($validator->errors(), 422);
        }

        try {
            $attribute = Attribute::create($request->all());
            return ApiService::response(new AttributeResource($attribute), 201);
        } catch (\Exception $e) {
            return ApiService::response(['message' => __('messages.attribute_creation_failed')], 500);
        }
    }

/**
 * @OA\Put(
 *     path="/api/v1/attributes/{id}",
 *     tags={"Attributes"},
 *     summary="Update an attribute",
 *     security={{"bearerAuth":{}}},
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         description="ID of the attribute",
 *         @OA\Schema(type="integer")
 *     ),
 *     @OA\RequestBody(
 *         required=true,
 *         description="Attribute data",
 *         @OA\JsonContent(
 *             @OA\Property(property="name", type="string", example="Updated Attribute Name"),
 *             @OA\Property(property="code", type="string", example="Updated Attribute Code"),
 *             @OA\Property(property="type", type="string", example="int")
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Attribute updated successfully",
 *     ),
 *     @OA\Response(
 *         response=404,
 *         description="Attribute not found"
 *     ),
 *     @OA\Response(
 *         response=422,
 *         description="Validation error"
 *     ),
 *     @OA\Response(
 *         response=500,
 *         description="Internal server error"
 *     )
 * )
 */
    public function update(Request $request, $id)
    {
        try {
            $attribute = Attribute::findOrFail($id);
            $validator = Validator::make($request->all(), [
                'name' => 'sometimes|string|max:255',
                'code' => 'sometimes|string|max:255',
                'type' => 'sometimes|string|in:varchar,int,text,decimal',
            ]);

            if ($validator->fails()) {
                return ApiService::response($validator->errors(), 422);
            }

            $attribute->update($request->all());
            return ApiService::response(new AttributeResource($attribute));
        } catch (\Exception $e) {
            return ApiService::response(['message' => __('messages.error_updating_attribute')], 500);
        }
    }

/**
 * @OA\Delete(
 *     path="/api/v1/attributes/{id}",
 *     tags={"Attributes"},
 *     summary="Delete an attribute",
 *     security={{"bearerAuth":{}}},
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         description="ID of the attribute",
 *         @OA\Schema(type="integer")
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Attribute deleted successfully"
 *     ),
 *     @OA\Response(
 *         response=404,
 *         description="Attribute not found"
 *     ),
 *     @OA\Response(
 *         response=500,
 *         description="Internal server error"
 *     )
 * )
 */
    public function destroy($id)
    {
        try {
            $attribute = Attribute::findOrFail($id);
            $attribute->delete();
            return ApiService::response(['message' => __('messages.attribute_deleted_success')], 200);
        } catch (\Exception $e) {
            return ApiService::response(['message' => __('messages.error_deleting_attribute')], 500);
        }
    }
}
