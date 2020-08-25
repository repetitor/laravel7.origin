<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class Quick extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     *
     * @OA\Get(
     *     path="/api/try",
     *     operationId="operationIdQuickInvoke",
     *     tags={"Quickly"},
     *     security={{"bearerAuth":{}}},
     *     summary="lalala - Display a listing of the resource",
     *     @OA\Response(
     *         response="200",
     *         description="Everything is fine"
     *     ),
     *     @OA\Response(
     *         response="404",
     *         description="Example not found"
     *     )
     * )
     */
    public function __invoke(Request $request)
    {
//        return $request;
        return ['message' => 'success'];
    }

    /**
     * @OA\Get(
     *     path="/try-get",
     *     tags={"Quickly"},
     *     @OA\Response(response="200", description="try-get - An example resource"),
     *     @OA\Parameter(
     *         name="page",
     *         in="query",
     *         description="The page number",
     *         required=false,
     *         @OA\Schema(
     *             type="integer",
     *         )
     *     ),
     *     @OA\Response(response="400", description="try-get - An example resource2")
     * )
     */
    public function get(Request $request)
    {
//        return 'default (invoke) action is also GET) What do you want from me?)';
        return $request;
    }

    /**
     * @OA\Post(
     *     path="/try-post-query",
     *     tags={"Quickly"},
     *     @OA\Response(response="200", description="try-post - An example resource"),
     *     @OA\Response(response="400", description="try-post - An example resource2"),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/ExampleStoreRequest")
     *     ),
     *     security={
     *         {"bearer": {}}
     *     }
     * )
     */
    public function postQuery(Request $request)
    {
//        return 'default (invoke) action is also GET) What do you want from me?)';
//        return ['message' => 'success-post'];
        return $request;
    }
}
