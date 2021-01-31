<?php

namespace App\Http\Controllers\API\Users;

use App\Models\Address;
use App\Http\Controllers\Controller;
use App\Http\Requests\AddressRequest;
use Illuminate\Auth\Access\AuthorizationException;

class AddressController extends Controller
{
    public function index()
    {
        return auth_factory('user')->addresses;
    }

    public function show(Address $address)
    {
        if ($address->user_id == auth_factory('user')->id) {
            return response()->json(['data' => $address]);
        }
        throw (new AuthorizationException());
    }

    public function store(AddressRequest $request)
    {
        $validated = $request->validated();
        $address =  auth_factory('user')->addresses()->create($validated);

        return response()->json([
            'message' => 'Address Created Succussfully',
            'data' => $address
        ]);
    }

    public function update(AddressRequest $request, Address $address)
    {
        $address->update($request->validated());

        return response()->json([
            'message' => 'Address Updated Succussfully',
            'data' => $address
        ]);
    }

    public function destroy(Address $address)
    {
        if (!$address->user_id == auth_factory('user')->id) {
            throw (new AuthorizationException());
        }
        $address->delete();

        return response()->json([
            'message' => 'Address Deleted Succussfully',
        ]);
    }
}
