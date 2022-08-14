<?php

declare(strict_types=1);

namespace Src\Status\System\Infrastructure\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Src\Shared\Infrastructure\Controllers\CustomController;
use Src\Status\System\Domain\Exceptions\StatusNotResponseException;

final class SystemStatusController extends CustomController
{
    private DB $DB;

    public function __construct()
    {
        parent::__construct();
        $this->DB = new DB;
    }

    /**
     * @return JsonResponse
     * @throws StatusNotResponseException
     */
    public function __invoke(): JsonResponse
    {
        try {
            $this->connection();
            return $this->defaultJsonResponse(
                200,
                false,
                "OK",
                ['current' => '/status']
            );
        } catch (\Exception $e) {
            throw new StatusNotResponseException("¡NOT OK!", 503);
        }
    }

    /**
     * @return void
     */
    private function connection(): void
    {
        $this->DB::connection()->getPDO();
    }
}
