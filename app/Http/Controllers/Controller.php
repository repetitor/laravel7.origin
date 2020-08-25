<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    /**
     * @OA\Info(
     *      version="1.0.0",
     *      title="Laravel OpenApi Demo Documentation",
     *      description="L5 Swagger OpenApi description",
     *      @OA\Contact(
     *          email="admin@admin.com"
     *      ),
     *      @OA\License(
     *          name="Apache 2.0",
     *          url="http://www.apache.org/licenses/LICENSE-2.0.html"
     *      )
     * )

     * @OA\Server(
     *     description="Laravel Swagger API server",
     *     url="http://localhost:86/api"
     * )

     *
     * @OA\SecurityScheme(
     *     type="apiKey",
     *     in="header",
     *     scheme="bearer",
     *     securityScheme="bearer"
     * )
     *
     *
     * @OA\OpenApi(
     *   security={
     *     {
     *       "oauth2": {"read:oauth2"},
     *     }
     *   }
     * )
     *
     *
     * @OA\Tag(
     *     name="Quickly",
     *     description="Quickly - API Endpoints of Projects"
     * )
     *
     *
     * @OA\Tag(
     *     name="Auth",
     *     description="Auth - API Endpoints of Projects"
     * )
     */
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
}
