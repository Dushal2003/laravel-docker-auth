<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Validation\ValidationException;
use Illuminate\Auth\AuthenticationException;         
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;
use Throwable;

class Handler extends ExceptionHandler
{
   
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

   
    protected function invalidJson($request, ValidationException $e)
    {
        return response()->json([
            'message' => 'Validation failed.',
            'errors'  => $e->errors(),
            'code'    => 422, 
        ], 422);
    }

  
    public function render($request, Throwable $e)
    {
       
        if ($this->shouldReturnJson($request, $e)) {

            
            if ($e instanceof HttpExceptionInterface) {
                $status  = $e->getStatusCode();
                $message = $e->getMessage() ?: $this->defaultMessage($status);

                return response()->json([
                    'message' => $message,
                    'code'    => $status,
                ], $status);
            }

          
            return response()->json([
                'message' => 'Server error',
                'code'    => 500,
            ], 500);
        }

       
        return parent::render($request, $e);
    }

   
    public function unauthenticated($request, AuthenticationException $exception)
    {
        if ($request->expectsJson() || $request->is('api/*')) {
            return response()->json([
                'message' => 'Unauthenticated',
                'code'    => 401,
            ], 401);
        }

        return redirect()->guest(route('login'));
    }

    private function defaultMessage(int $status): string
    {
        return match ($status) {
            400 => 'Bad request',
            401 => 'Unauthenticated',
            403 => 'Forbidden',
            404 => 'Resource not found',
            422 => 'Unprocessable entity',
            default => 'Error',
        };
    }
}
