<?php

namespace App\Http\Middleware;

use Closure;

class ValidParenthesesToken
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle($request, Closure $next)
    {
        $token = $request->bearerToken();

        if (!$this->isValidParentheses($token)) {
            return response()->json(['error' => 'Invalid token'], 401);
        }

        return $next($request);
    }

    /**
     * Check if the parentheses, brackets, and braces are balanced in the token.
     *
     * @param  string $string
     * @return bool
     */
    private function isValidParentheses($string)
    {
        if (!preg_match('/[\{\}\[\]\(\)]/', $string)) {
            return false;
        }

        $stack = [];
        $map = ['}' => '{', ']' => '[', ')' => '('];

        for ($i = 0; $i < strlen($string); $i++) {
            $char = $string[$i];

            if (in_array($char, ['{', '[', '('])) {
                array_push($stack, $char);
            } elseif (in_array($char, ['}', ']', ')'])) {
                if (empty($stack) || array_pop($stack) != $map[$char]) {
                    return false;
                }
            }
        }

        return empty($stack);
    }
}
