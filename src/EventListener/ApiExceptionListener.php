<?php

declare(strict_types=1);

namespace App\EventListener;

use App\Exception\ApiException;
use Symfony\Component\EventDispatcher\Attribute\AsEventListener;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;
use Symfony\Component\Validator\Exception\ValidationFailedException;

#[AsEventListener]
final class ApiExceptionListener
{
    public function __invoke(ExceptionEvent $event): void
    {
        $throwable = $event->getThrowable();

        if ($throwable instanceof ApiException) {
            $event->setResponse(new JsonResponse(
                ['error' => ['code' => $throwable->getErrorCode(), 'message' => $throwable->getMessage()]],
                $throwable->getHttpStatus(),
            ));

            return;
        }

        $validationFailure = $this->findValidationFailure($throwable);
        if ($validationFailure !== null) {
            $violations = [];
            foreach ($validationFailure->getViolations() as $violation) {
                $violations[] = [
                    'field' => $violation->getPropertyPath(),
                    'message' => (string) $violation->getMessage(),
                ];
            }
            $event->setResponse(new JsonResponse(
                [
                    'error' => [
                        'code' => 'validation_failed',
                        'message' => 'Invalid request body.',
                        'violations' => $violations,
                    ],
                ],
                422,
            ));
        }
    }

    private function findValidationFailure(\Throwable $throwable): ?ValidationFailedException
    {
        if ($throwable instanceof ValidationFailedException) {
            return $throwable;
        }
        if ($throwable instanceof HttpExceptionInterface && $throwable->getPrevious() instanceof ValidationFailedException) {
            return $throwable->getPrevious();
        }

        return null;
    }
}
