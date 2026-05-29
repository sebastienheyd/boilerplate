<?php

namespace Sebastienheyd\Boilerplate\Ai;

use Illuminate\Support\Facades\Log;

class AiStreamer
{
    /**
     * Stream AI provider response as normalized Server-Sent Events.
     * Emits: data: {"content":"..."}\n\n  or  data: [DONE]\n\n.
     *
     * @codeCoverageIgnore
     */
    public function stream(AiProvider $provider, string $prompt): void
    {
        $buffer = '';

        $curl = curl_init();

        curl_setopt_array($curl, [
            CURLOPT_URL            => $provider->endpoint(),
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING       => '',
            CURLOPT_MAXREDIRS      => 10,
            CURLOPT_TIMEOUT        => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION   => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST  => 'POST',
            CURLOPT_POSTFIELDS     => json_encode($provider->body($prompt)),
            CURLOPT_HTTPHEADER     => $provider->headers(),
            CURLOPT_WRITEFUNCTION  => function ($curl, $data) use ($provider, &$buffer) {
                $buffer .= $data;

                while (($pos = strpos($buffer, "\n")) !== false) {
                    $line = substr($buffer, 0, $pos);
                    $buffer = substr($buffer, $pos + 1);

                    $line = trim($line);

                    // Skip SSE event/comment lines and empty lines
                    if ($line === '' || str_starts_with($line, 'event:') || str_starts_with($line, ':')) {
                        continue;
                    }

                    // Strip "data: " prefix if present (OpenAI/Anthropic SSE format)
                    $raw = str_starts_with($line, 'data: ') ? substr($line, 6) : $line;

                    if ($raw === '[DONE]') {
                        echo "data: [DONE]\n\n";
                        ob_flush();
                        flush();
                        continue;
                    }

                    $delta = $provider->parseChunk($raw);

                    if ($delta === '[DONE]') {
                        echo "data: [DONE]\n\n";
                        ob_flush();
                        flush();
                    } elseif ($delta !== null) {
                        echo 'data: '.json_encode(['content' => $delta])."\n\n";
                        ob_flush();
                        flush();
                    }
                }

                return strlen($data);
            },
        ]);

        curl_exec($curl);
        $err = curl_error($curl);
        curl_close($curl);

        if ($err) {
            Log::error('AI provider cURL error: '.$err);
        }
    }
}
