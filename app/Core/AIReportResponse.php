<?php
declare(strict_types=1);

final class AIReportResponse
{
    public static function content(int $httpCode, string $response): string
    {
        if ($httpCode !== 200) {
            throw new RuntimeException('Report generation failed (HTTP ' . $httpCode . '). Please try again later.');
        }
        $result = json_decode($response, true);
        if (!is_array($result) || array_key_exists('error', $result)) {
            throw new RuntimeException('Report generation failed: the service returned an invalid response. Please try again.');
        }
        $candidates = $result['candidates'] ?? null;
        $feedback = $result['promptFeedback'] ?? [];
        $candidate = is_array($candidates) ? ($candidates[0] ?? null) : null;
        if (!is_array($feedback) || !empty($feedback['blockReason']) || !is_array($candidate)
            || ($candidate['finishReason'] ?? '') !== 'STOP') {
            throw new RuntimeException('Report generation failed: no complete report was returned. Please try again.');
        }
        $ratings = $candidate['safetyRatings'] ?? [];
        if (!is_array($ratings)) throw new RuntimeException('Report generation failed: invalid safety response.');
        foreach ($ratings as $rating) {
            if (!is_array($rating) || !empty($rating['blocked'])) {
                throw new RuntimeException('Report generation failed: the response was blocked. Please revise your request.');
            }
        }
        $body = $candidate['content'] ?? null;
        $parts = is_array($body) ? ($body['parts'] ?? null) : null;
        if (!is_array($parts) || !$parts || (isset($body['role']) && $body['role'] !== 'model')) {
            throw new RuntimeException('Report generation failed: invalid report content. Please try again.');
        }
        $text = [];
        foreach ($parts as $part) {
            if (!is_array($part)) throw new RuntimeException('Report generation failed: invalid report content.');
            if (!empty($part['thought'])) continue;
            if (!isset($part['text']) || !is_string($part['text'])
                || array_key_exists('functionCall', $part) || array_key_exists('functionResponse', $part)) {
                throw new RuntimeException('Report generation failed: a text report was not returned. Please try again.');
            }
            $text[] = $part['text'];
        }
        $content = trim(implode("\n", $text));
        self::assertContent($content);
        return $content;
    }

    public static function assertContent(string $content): void
    {
        $visible = preg_replace('/[\s\p{Z}\p{C}`#*_~|>\-]+/u', '', strip_tags($content));
        if ($visible === null || $visible === '') {
            throw new RuntimeException('Report generation failed: the service returned an empty report. Please try again.');
        }
        // Reject error payloads even if a provider accidentally wraps one in a successful text response.
        $plain = trim((string)preg_replace('/\A\s*```(?:json|text)?\s*|\s*```\s*\z/i', '', $content));
        $payload = json_decode($plain, true);
        if ((is_array($payload) && array_key_exists('error', $payload))
            || preg_match('/\A\s*(?:HTTP\s+[45]\d\d\b|cURL\s+error\b|(?:Error|Exception|Report generation failed)\s*:|(?:UNAVAILABLE|RESOURCE_EXHAUSTED|PERMISSION_DENIED|UNAUTHENTICATED|INTERNAL|DEADLINE_EXCEEDED)\s*[:\-]|Gemini returned an empty response\.?\s*\z)/i', $plain)) {
            throw new RuntimeException('Report generation failed: the service returned an error instead of a report. Please try again.');
        }
    }
}
