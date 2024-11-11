<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\Address;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Http\Resources\AddressResource;
use App\Services\ApiService;

class AddressController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/v1/addresses",
     *     tags={"Addresses"},
     *     summary="List all addresses",
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
            $addresses = AddressResource::collection(Address::all());
            return ApiService::response($addresses);
        } catch (\Exception $e) {
            return ApiService::response(['message' => __('messages.error_retrieving_addresses')], 500);
        }
    }

    /**
     * @OA\Post(
     *     path="/api/v1/addresses",
     *     tags={"Addresses"},
     *     summary="Create a new address",
     *     security={{"bearerAuth":{}}},
     *     @OA\RequestBody(
     *         required=true,
     *         description="Address data",
     *         @OA\JsonContent(
     *             @OA\Property(property="street", type="string", example="123 Main Street"),
     *             @OA\Property(property="city", type="string", example="City"),
     *             @OA\Property(property="country", type="string", example="Country"),
     *             @OA\Property(property="postal_code", type="string", example="12345")
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Address created successfully",
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
            'street' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'country' => 'required|string|max:255',
            'postal_code' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            return ApiService::response($validator->errors(), 422);
        }

        try {
            $address = Address::create($request->all());
            return ApiService::response(new AddressResource($address), 201);
        } catch (\Exception $e) {
            return ApiService::response(['error' => __('messages.address_creation_failed')], 500);
        }
    }

    /**
     * @OA\Get(
     *     path="/api/v1/addresses/{id}",
     *     tags={"Addresses"},
     *     summary="Get a specific address by ID",
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID of the address",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Address not found"
     *     )
     * )
     */
    public function show($id)
    {
        try {
            $address = Address::findOrFail($id);
            return ApiService::response(new AddressResource($address));
        } catch (\Exception $e) {
            return ApiService::response(['message' => __('messages.address_not_found')], 404);
        }
    }

    /**
     * @OA\Put(
     *     path="/api/v1/addresses/{id}",
     *     tags={"Addresses"},
     *     summary="Update an address",
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID of the address",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         description="Address data",
     *         @OA\JsonContent(
     *             @OA\Property(property="street", type="string", example="Updated 123 Main Street"),
     *             @OA\Property(property="city", type="string", example="Updated City"),
     *             @OA\Property(property="country", type="string", example="Updated Country"),
     *             @OA\Property(property="postal_code", type="string", example="54321")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Address updated successfully",
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Address not found"
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
            $address = Address::findOrFail($id);
            $validator = Validator::make($request->all(), [
                'street' => 'sometimes|string|max:255',
                'city' => 'sometimes|string|max:255',
                'country' => 'sometimes|string|max:255',
                'postal_code' => 'sometimes|string|max:255',
            ]);

            if ($validator->fails()) {
                return ApiService::response($validator->errors(), 422);
            }

            $address->update($request->all());
            return ApiService::response(new AddressResource($address));
        } catch (\Exception $e) {
            return ApiService::response(['message' => __('messages.error_updating_address')], 500);
        }
    }

    /**
     * @OA\Delete(
     *     path="/api/v1/addresses/{id}",
     *     tags={"Addresses"},
     *     summary="Delete an address",
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID of the address",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Address deleted successfully"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Address not found"
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
            $address = Address::findOrFail($id);
            $address->delete();
            return ApiService::response(['message' => __('messages.address_deleted_success')], 200);
        } catch (\Exception $e) {
            return ApiService::response(['message' => __('messages.error_deleting_address')], 500);
        }
    }
}
