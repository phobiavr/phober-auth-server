<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller {
  /**
   * @OA\Post(
   *   path="/authenticate",
   *   summary="Get token",
   *   operationId="authenticate",
   *   tags={"Authentication & Authorization"},
   *   security={},
   *   @OA\RequestBody(
   *     required=true,
   *     @OA\JsonContent(
   *       example={"email":"admin@site.com","password":"admin"}
   *      )
   *   ),
   *   @OA\Response(
   *     response="200",
   *     description="ok",
   *   )
   * )
   */
  public function authenticate(Request $request): JsonResponse {
    $user = User::query()->where('email', $request->input('email'))->first();

    if (Hash::check($request->input('password'), $user->password)) {
      $token = base64_encode(self::quickRandom(40));

      $user->api_token = $token;
      $user->save();

      return response()->json(['token' => "$token"]);
    } else {
      return response()->json(['message' => 'Credentials error'], 401);
    }
  }

  /**
   * @OA\Get(
   *   path="/valid",
   *   summary="Check authentication validity",
   *   operationId="valid",
   *   tags={"Authentication & Authorization"},
   *   security={{"bearer_token": {}}},
   *   @OA\Response(
   *     response="200",
   *     description="ok",
   *   )
   * )
   */
  public function valid(Request $request): JsonResponse {
    $token = request()->bearerToken();

    if (!$token) return response()->json(['message' => 'Credentials error'], 401);

    $user = User::query()->where('api_token', $token)->first();

    if ($user) {
      return response()->json(['user' => $user->toArray()]);
    } else {
      return response()->json(['message' => 'Credentials error'], 401);
    }
  }

  private static function quickRandom($length = 16) {
    $pool = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';

    return substr(str_shuffle(str_repeat($pool, 5)), 0, $length);
  }
}
