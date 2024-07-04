<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ContentAuditMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // $post_content = $request->post();
        // $comment = $post_content['content'];
        if($request->has("content")){
            $content = $request->post()['content'];
            $sensitiveWords = ['草泥马', '操你妈'];
            foreach ($sensitiveWords as $word) {
                if (strpos($content, $word) !== false) {
                    return response('含有不允许的词汇', 400);
                }
            }
        }

        return $next($request);
    }
}
