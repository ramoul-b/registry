<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\Account;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Http\Resources\AccountResource;
use App\Services\ApiService;

class AccountController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/v1/accounts",
     *     tags={"Accounts"},
     *     summary="List all accounts",
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
            $accounts = AccountResource::collection(Account::all());
            return ApiService::response($accounts);
        } catch (\Exception $e) {
            return ApiService::response(['message' => __('messages.error_retrieving_accounts')], 500);
        }
    }

    /**
     * @OA\Post(
     *     path="/api/v1/accounts",
     *     tags={"Accounts"},
     *     summary="Create a new account",
     *     security={{"bearerAuth":{}}},
     *     @OA\RequestBody(
     *         required=true,
     *         description="Account data",
     *         @OA\JsonContent(
     *             @OA\Property(property="name", type="string", example="Account Name"),
     *             @OA\Property(property="type", type="string", example="creator"),
     *             @OA\Property(property="registry_id", type="integer", example=1)
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Account created successfully",
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
            'type' => 'required|string|in:creator,owner,user',
            'registry_id' => 'required|integer|exists:registries,id',
        ]);

        if ($validator->fails()) {
            return ApiService::response($validator->errors(), 422);
        }

        try {
            $account = Account::create($request->all());
            return ApiService::response(new AccountResource($account), 201);
        } catch (\Exception $e) {
            return ApiService::response(['error' => __('messages.account_creation_failed')], 500);
        }
    }

    /**
     * @OA\Get(
     *     path="/api/v1/accounts/{id}",
     *     tags={"Accounts"},
     *     summary="Get a specific account by ID",
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID of the account",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Account not found"
     *     )
     * )
     */
    public function show($id)
    {
        try {
            $account = Account::findOrFail($id);
            return ApiService::response(new AccountResource($account));
        } catch (\Exception $e) {
            return ApiService::response(['message' => __('messages.account_not_found')], 404);
        }
    }

    /**
     * @OA\Put(
     *     path="/api/v1/accounts/{id}",
     *     tags={"Accounts"},
     *     summary="Update an account",
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID of the account",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         description="Account data",
     *         @OA\JsonContent(
     *             @OA\Property(property="name", type="string", example="Updated Account Name"),
     *             @OA\Property(property="type", type="string", example="owner"),
     *             @OA\Property(property="registry_id", type="integer", example=2)
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Account updated successfully",
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Account not found"
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
            $account = Account::findOrFail($id);
            $validator = Validator::make($request->all(), [
                'name' => 'sometimes|string|max:255',
                'type' => 'sometimes|string|in:creator,owner,user',
                'registry_id' => 'sometimes|integer|exists:registries,id',
            ]);

            if ($validator->fails()) {
                return ApiService::response($validator->errors(), 422);
            }

            $account->update($request->all());
            return ApiService::response(new AccountResource($account));
        } catch (\Exception $e) {
            return ApiService::response(['message' => __('messages.error_updating_account')], 500);
        }
    }

    /**
     * @OA\Delete(
     *     path="/api/v1/accounts/{id}",
     *     tags={"Accounts"},
     *     summary="Delete an account",
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID of the account",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Account deleted successfully"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Account not found"
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
            $account = Account::findOrFail($id);
            $account->delete();
            return ApiService::response(['message' => __('messages.account_deleted_success')], 200);
        } catch (\Exception $e) {
            return ApiService::response(['message' => __('messages.error_deleting_account')], 500);
        }
    }
}
