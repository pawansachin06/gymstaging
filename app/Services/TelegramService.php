<?php

namespace App\Services;

// use App\Models\Setting;
use Exception;
use Illuminate\Support\Facades\Log;
use function is_array;

enum TelegramParseMode: string
{
    case HTML = 'HTML';
    case Markdown = 'Markdown';
    case MarkdownV2 = 'MarkdownV2';
}

class TelegramService
{
    private const API_BASE_URL = 'https://api.telegram.org/bot';

    private string $token;
    private string $adminGroupId;
    private static ?self $instance = null;

    public function __construct()
    {
        $keys = ['telegram-bot-token', 'telegram-admin-group-id'];
        try {
            // $settings = Setting::query()->whereIn('key', $keys)
            //     ->pluck('value', 'key');
            // $this->token = $settings['telegram-bot-token'];
            // $this->adminGroupId = $settings['telegram-admin-group-id'];
            $this->token = config('services.telegram.bot.token');
            $this->adminGroupId = config('services.telegram.group.admin');
        } catch (Exception $e) {
            Log::critical('TELEGRAM-INIT', ['error' => $e->getMessage()]);
        }
    }

    public static function getInstance(): self
    {
        if (!self::$instance) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    private function truncate(string $text, int $maxLength = 36)
    {
        if ($maxLength <= 3) {
            return mb_substr($text, 0, $maxLength); // No space for dots
        }
        return mb_strlen($text) > $maxLength
            ? mb_substr($text, 0, $maxLength - 3) . '...'
            : $text;
    }

    /**
     * Sends a message to a specific chat.
     *
     * @param int|string $chatId Chat ID or username (e.g., @channel_name)
     * @param string $text The message text to send
     * @param array{
     *     parse_mode?: 'HTML'|'Markdown'|'MarkdownV2',
     *     disable_web_page_preview?: bool,
     *     silent?: bool,
     *     reply_to_message_id?: int,
     *     reply_markup?: array
     * } $options
     * @return array{success: bool, data?: array, message?: string}
     */
    public function sendMessage(int|string $chatId, string $text, array $options = [])
    {
        $url = self::API_BASE_URL . $this->token . '/sendMessage';
        $data = [
            'chat_id' => $chatId,
            'text' => $this->truncate($text, 4096),
            'disable_notification' => $options['silent'] ?? false,
            'parse_mode' => ($options['parse_mode'] ?? TelegramParseMode::HTML)->value,
            'disable_web_page_preview' => 'true',
            ...$options,
        ];
        return $this->sendRequest($url, $data);
    }

    /**
     * Sends a message to the admin group.
     *
     * @param string $text
     * @param array $options
     * @return array{success: bool, data?: array, message?: string}
     */
    public function sendAdminGroup(string $text, array $options = [])
    {
        return $this->sendMessage($this->adminGroupId, $text, $options);
    }

    /**
     * Parses incoming Telegram webhook request.
     *
     * @param string $rawData Raw JSON string from webhook POST body
     * @return array{chat_id: int, message: string, body: array}|null
     */
    public function handleWebhookRequest(string $rawData): ?array
    {
        $update = json_decode($rawData, true);

        if (!is_array($update) || !isset($update['message']['chat']['id'], $update['message']['text'])) {
            return null;
        }

        return [
            'chat_id' => $update['message']['chat']['id'],
            'message' => $update['message']['text'],
            'body' => $update,
        ];
    }

    /**
     * Sends a POST request to Telegram API.
     *
     * @param string $url Telegram API endpoint
     * @param array $data POST payload
     * @return array{success: bool, data?: array, message?: string}
     */
    private function sendRequest(string $url, array $data): array
    {
        try {
            $ch = curl_init($url);
            curl_setopt_array($ch, [
                CURLOPT_POST => true,
                CURLOPT_POSTFIELDS => http_build_query($data),
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_TIMEOUT => 10,
            ]);

            $response = curl_exec($ch);
            $error = curl_error($ch);
            curl_close($ch);

            if ($error) {
                return ['success' => false, 'message' => $error];
            }

            $decoded = json_decode($response, true);
            return $decoded['ok']
                ? ['success' => true, 'data' => $decoded]
                : ['success' => false, 'message' => $decoded['description'] ?? 'Unknown error'];
        } catch (Exception $e) {
            return ['success' => false, 'message' => $e->getMessage()];
        }
    }

}