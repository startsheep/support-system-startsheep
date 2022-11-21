<?php

namespace App\Http\Traits;

use Illuminate\Http\Response;
use Illuminate\Support\Str;

trait MessageFixer
{
    protected function createSuccess($feature, $message)
    {
        return response()->json([
            'message' => $feature . ' has been created!',
            'type' => 'success',
            'data' => $message
        ], Response::HTTP_CREATED);
    }

    protected function updateSuccess($feature, $message)
    {
        return response()->json([
            'message' => $feature . ' has been updated!',
            'type' => 'success',
            'data' => $message
        ], Response::HTTP_OK);
    }

    protected function statusSuccess($feature, $message)
    {
        return response()->json([
            'message' => $feature . ' has been updated status!',
            'type' => 'success',
            'data' => $message
        ], Response::HTTP_OK);
    }

    protected function deleteSuccess($feature, $message)
    {
        return response()->json([
            'message' => $feature . ' has been deleted!',
            'type' => 'success',
            'data' => $message
        ], Response::HTTP_OK);
    }

    protected function error($message)
    {
        return response()->json([
            'message' => $message,
            'type' => 'error',
        ], Response::HTTP_INTERNAL_SERVER_ERROR);
    }
}
