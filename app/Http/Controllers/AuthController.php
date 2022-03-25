<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AuthController extends Controller {
  /**
   * @OA\Get(
   *   path="/authorize",
   *   summary="Get token",
   *   operationId="authorize",
   *   tags={"Authentication & Authorization"},
   *   security={},
   *   @OA\Response(
   *     response="200",
   *     description="ok",
   *   )
   * )
   */
  public function getToken(Request $request) {
    //
  }
}
