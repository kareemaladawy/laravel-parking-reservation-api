<?php

namespace App\Http\Controllers\Api\V1\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Validation\Rule;

/**
 * @group Profile
 */
class ProfileController extends Controller
{
    /**
     * View profile information
     *
     * This endpoint allows you to view your profile information.
     */
    public function show(Request $request)
    {
        return response()->json($request->user()->only('name', 'email'));
    }

    /**
     * Update profile information
     *
     * This endpoint allows you to update your profile information.
     */
    public function update(Request $request)
    {
        $validatedData = $request->validate([
            'name' => ['sometimes', 'string', 'min:3', 'max:50'],
            'email' => ['sometimes', 'email', Rule::unique('users')->ignore(auth()->user())],
        ]);

        auth()->user()->update($validatedData);

        return response()->json($validatedData, Response::HTTP_ACCEPTED);
    }
}
