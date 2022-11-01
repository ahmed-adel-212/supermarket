<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Address;
use Auth;
use Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class AddressesController extends AbstractApiController
{
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string'],
            'street' => ['nullable', 'string'],
            'building_number' => ['nullable', 'string'],
            'floor_number' => ['nullable', 'string'],
            'landmark' => ['nullable'],
            'area_id' => ['required', 'exists:areas,id'],
            'user_id' => ['exists:users,id'],
        ]);
        if ($validator->fails())
            return $this->sendError(__('general.validation_errors'), $validator->errors(), 400);

        $address = Address::firstOrCreate($request->all());

        if (!$address)
            return $this->sendError(__('general.error'), 400);

        return $this->sendResponse($address, __('general.address.created'));
    }

    public function update(Request $request,$addressId)
    {
        $address = Address::find($addressId);
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string'],
            'street' => ['nullable', 'string'],
            'building_number' => ['nullable', 'string'],
            'floor_number' => ['nullable', 'string'],
            'landmark' => ['nullable'],
            'area_id' => ['required', 'exists:areas,id'],
            'user_id' => ['exists:users,id'],
        ]);
        if ($validator->fails()) {
            return $this->sendError($validator->errors(), __('general.validation_errors'), 400);
        }

        if (!$address->update($request->all())) {
            return $this->sendError(__('general.error'), 400);
        }

        return $this->sendResponse($address, __('general.address.updated'));
    }

    public function destroy($addressId, Request $request)
    {
        $address=Address::find($addressId);
        if ($request->user()) {
            if ($address->user_id == auth()->user()->id) {
                if ($address->delete())
                    return $this->sendResponse(null, __('general.address deleted successfully'));
            }
        } 
            return $this->sendError(__('general.error'));
    }
}

