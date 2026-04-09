<?php

use Illuminate\Support\Facades\Log;

if (!function_exists('notifyError')) {
    function notifyError($err = null)
    {
        if ($err instanceof Throwable) {
            $url = request()->getRequestUri();
            $msg = $err->getMessage();
            $file = $err->getFile();
            $line = $err->getLine();
            // Limit to top 6 trace lines
            $stack = collect($err->getTrace())->take(6)->map(function($t, $i){
                return sprintf(
                    "#%d %s(%s): %s%s%s()",
                    $i,
                    $t['file'] ?? '[internal]',
                    $t['line'] ?? '?',
                    $t['class'] ?? '',
                    $t['type'] ?? '',
                    $t['function']
                );
            })->implode("\n");
            $message = "$msg<pre>$url</pre><pre>$file:$line</pre><pre>$stack</pre>";
            $tres = telegram()->sendAdminGroup($message);
            if (!$tres['success']) {
                Log::error('telegram', ['msg' => $tres['message']]);
            }
        }
    }
}

if (!function_exists('resJson')) {
    function resJson($response = [], $code = 200, $err = null)
    {
        if ($err instanceof Throwable) {
            notifyError($err);
        }
        if (is_string($response)) {
            $response = ['message' => $response];
        }
        return response()->json($response, $code);
    }
}

