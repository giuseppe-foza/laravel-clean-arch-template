<?php
declare(strict_types=1);

namespace App\Features\Base\Application\Services;

use App\Shared\Enums\EnvironmentEnum;
use App\Shared\Enums\MessagesEnum;
use App\Shared\Exceptions\AppException;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Http\Exceptions\ThrottleRequestsException;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Throwable;

class ExceptionRenderService
{
    private array $info;
    private int $code;

    public function __construct(private readonly Throwable $throwable)
    {
        $this->logError();
        $this->reset();
    }

    public function render(): self
    {
        if ($this->throwable instanceof AppException) {
            $this->setInfo($this->throwable->getMessage(), $this->throwable->getCode());
            $this->code = $this->throwable->getCode();
            return $this;
        }

        if ($this->isMapped() || App::environment(EnvironmentEnum::LOCAL)) {
            $code = method_exists($this->throwable, 'getStatusCode')
                ? $this->throwable->getStatusCode()
                : Response::HTTP_INTERNAL_SERVER_ERROR;

            $this->setInfo($this->throwable->getMessage(), $code);
            $this->code = $this->info['statusCode'];

            return $this;
        }

        $this->reset();

        return $this;
    }

    public function toJson(): JsonResponse
    {
        return response()->json($this->info, $this->code);
    }

    private function isMapped(): bool
    {
        return in_array(get_class($this->throwable), [
            MethodNotAllowedHttpException::class,
            NotFoundHttpException::class,
            ThrottleRequestsException::class,
            BindingResolutionException::class,
        ]);
    }

    private function setInfo(string $message, int $statusCode): void
    {
        $this->info = [
            'message' => $message,
            'statusCode' => $statusCode,
        ];
    }

    private function reset(): void
    {
        $this->info = [
            'message' => MessagesEnum::ERRO_INTERNO,
            'statusCode' => Response::HTTP_INTERNAL_SERVER_ERROR,
        ];
        $this->code = Response::HTTP_INTERNAL_SERVER_ERROR;
    }

    private function logError(): void
    {
        if ($this->throwable instanceof AppException) {
            Log::warning($this->throwable->getMessage());
        } else {
            Log::error($this->throwable);
        }
    }
}
