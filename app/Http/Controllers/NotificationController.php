<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $user = ($request->query('guard') == 'customer') ? auth('customer')->user() : backpack_user();

        return response()->json($user->unreadNotifications);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id, Request $request)
    {
        $unreadNotification = $request->user()->unreadNotifications->find($id);

        $unreadNotification->markAsRead();

        return response()->json($unreadNotification);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {


        return response()->json($user->unreadNotifications);
    }

    /**
     * Update the specified resource in storage.
     */
    public function clearAll(Request $request): JsonResponse
    {
        $user = $request->user();

        $user->unreadNotifications->markAsRead();

        return response()->json($user->unreadNotifications);
    }
}
