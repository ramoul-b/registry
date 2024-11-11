<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\Type;
use Illuminate\Http\Request;
use App\Http\Resources\TypeResource;
use App\Http\Resources\TypeCollection;
use App\Services\ApiService;
use Illuminate\Support\Facades\Validator;

class TypeController extends Controller
{

/**
 * @OA\Get(
 *     path="/api/v1/types",
 *     tags={"Types"},
 *     summary="List all types",
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
            $types = new TypeCollection(Type::all());
            return ApiService::response($types);
        } catch (\Exception $e) {
            return ApiService::response(['message' => __('messages.error_retrieving_types')], 500);
        }
    }

    /**
 * @OA\Get(
 *     path="/api/v1/types/{id}",
 *     tags={"Types"},
 *     summary="Get a specific type by ID",
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
 *         description="Type not found"
 *     )
 * )
 */
    public function show($id)
    {
        try {
            $type = new TypeResource(Type::findOrFail($id));
            return ApiService::response($type);
        } catch (\Exception $e) {
            return ApiService::response(['message' => __('messages.type_not_found')], 404);
        }
    }

/**
 * @OA\Post(
 *     path="/api/v1/types",
 *     tags={"Types"},
 *     summary="Create a new type",
 *     security={{"bearerAuth":{}}},
 *     @OA\RequestBody(
 *         required=true,
 *         description="Type data",
 *         @OA\JsonContent(
 *             @OA\Property(property="country", type="string", example="Country"),
 *             @OA\Property(property="name", type="string", example="Type Name"),
 *             @OA\Property(property="description", type="string", example="Type Description"),
 *             @OA\Property(property="business_type_code", type="string", example="Type Code"),
 *             @OA\Property(property="has_vat_code", type="boolean", example=true),
 *             @OA\Property(property="required_vat_code", type="boolean", example=true),
 *             @OA\Property(property="vat_code_in_unique", type="boolean", example=true),
 *             @OA\Property(property="has_tax_identification", type="boolean", example=true),
 *             @OA\Property(property="required_tax_identification", type="boolean", example=true),
 *             @OA\Property(property="tax_identification_in_unique", type="boolean", example=true),
 *             @OA\Property(property="has_name", type="boolean", example=true),
 *             @OA\Property(property="required_name", type="boolean", example=true),
 *             @OA\Property(property="has_surname", type="boolean", example=true)
 *         )
 *     ),
 *     @OA\Response(
 *         response=201,
 *         description="Type created successfully",
 *     ),
 *     @OA\Response(
 *         response=400,
 *         description="Invalid input"
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
            'country' => 'required|string|max:255',
            'name' => 'required|string|max:255',
            'description' => 'required|string|max:255',
            'business_type_code' => 'required|string|max:255',
            'has_vat_code' => 'required|boolean',
            'required_vat_code' => 'required|boolean',
            'vat_code_in_unique' => 'required|boolean',
            'has_tax_identification' => 'required|boolean',
            'required_tax_identification' => 'required|boolean',
            'tax_identification_in_unique' => 'required|boolean',
            'has_name' => 'required|boolean',
            'required_name' => 'required|boolean',
            'has_surname' => 'required|boolean',
        ]);
        

        if ($validator->fails()) {
            return ApiService::response($validator->errors(), 422);
        }

        try {
            $type = Type::create($request->all());
            return ApiService::response(new TypeResource($type), 201);
        } catch (\Exception $e) {
            return ApiService::response(['error' => __('messages.type_creation_failed')], 500);
        }
    }
/**
 * @OA\Put(
 *     path="/api/v1/types/{id}",
 *     tags={"Types"},
 *     summary="Update a type",
 *     security={{"bearerAuth":{}}},
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         description="ID of the type",
 *         @OA\Schema(type="integer")
 *     ),
 *     @OA\RequestBody(
 *         required=true,
 *         description="Type data",
 *         @OA\JsonContent(
 *             @OA\Property(property="country", type="string", example="Updated Country"),
 *             @OA\Property(property="name", type="string", example="Updated Type Name"),
 *             @OA\Property(property="description", type="string", example="Updated Type Description"),
 *             @OA\Property(property="business_type_code", type="string", example="Updated Type Code"),
 *             @OA\Property(property="has_vat_code", type="boolean", example=false),
 *             @OA\Property(property="required_vat_code", type="boolean", example=false),
 *             @OA\Property(property="vat_code_in_unique", type="boolean", example=false),
 *             @OA\Property(property="has_tax_identification", type="boolean", example=false),
 *             @OA\Property(property="required_tax_identification", type="boolean", example=false),
 *             @OA\Property(property="tax_identification_in_unique", type="boolean", example=false),
 *             @OA\Property(property="has_name", type="boolean", example=false),
 *             @OA\Property(property="required_name", type="boolean", example=false),
 *             @OA\Property(property="has_surname", type="boolean", example=false)
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Type updated successfully",
 *     ),
 *     @OA\Response(
 *         response=400,
 *         description="Invalid input"
 *     ),
 *     @OA\Response(
 *         response=404,
 *         description="Type not found"
 *     )
 * )
 */
    public function update(Request $request, $id)
    {
        try {
            $type = Type::findOrFail($id);
            $validator = Validator::make($request->all(), [
                'country' => 'sometimes|string|max:255',
                'name' => 'sometimes|string|max:255',
                'description' => 'sometimes|string|max:255',
                'business_type_code' => 'sometimes|string|max:255',
                'has_vat_code' => 'sometimes|boolean',
                'required_vat_code' => 'sometimes|boolean',
                'vat_code_in_unique' => 'sometimes|boolean',
                'has_tax_identification' => 'sometimes|boolean',
                'required_tax_identification' => 'sometimes|boolean',
                'tax_identification_in_unique' => 'sometimes|boolean',
                'has_name' => 'sometimes|boolean',
                'required_name' => 'sometimes|boolean',
                'has_surname' => 'sometimes|boolean',
            ]);
            

            if ($validator->fails()) {
                return ApiService::response($validator->errors(), 422);
            }

            $type->update($request->all());
            return ApiService::response(new TypeResource($type));
        } catch (\Exception $e) {
            return ApiService::response(['message' => __('messages.error_updating_type')], 500);
        }
    }
/**
 * @OA\Delete(
 *     path="/api/v1/types/{id}",
 *     tags={"Types"},
 *     summary="Delete a type",
 *     security={{"bearerAuth":{}}},
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         @OA\Schema(type="integer")
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Type deleted successfully"
 *     ),
 *     @OA\Response(
 *         response=404,
 *         description="Type not found"
 *     )
 * )
 */
    public function destroy($id)
    {
        try {
            $type = Type::findOrFail($id);
            $type->delete();
            return ApiService::response(['message' => __('messages.type_deleted_success')], 200);
        } catch (\Exception $e) {
            return ApiService::response(['message' => __('messages.error_deleting_type')], 500);
        }
    }
}
