<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use GuzzleHttp\Client;

class AskQuestion extends Command
{
    // Nazwa komendy
    protected $signature = 'ask:question {question}';

    // Opis komendy
    protected $description = 'Zadaj pytanie ChatGPT lub innemu botowi';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
//        dd(env('OPENAI_API_KEY'));
        // Pobierz parametr "question"
        $question = $this->argument('question');

        // Wywołaj funkcję, która wyśle pytanie do API
        $answer = $this->sendQuestionToBot($question);

        // Wyświetl odpowiedź
        $this->info('Odpowiedź bota: ' . $answer);
    }

    // Funkcja do komunikacji z OpenAI API
    private function sendQuestionToBot($question)
    {
        // Inicjalizuj klienta HTTP
        $client = new Client();

        // Pobierz klucz API z pliku .env
        $apiKey = env('OPENAI_API_KEY');

        try {
            // Wyślij żądanie POST do API OpenAI
            $response = $client->post('https://api.openai.com/v1/chat/completions', [
                'headers' => [
                    'Authorization' => 'Bearer ' . $apiKey,
                    'Content-Type' => 'application/json',
                ],
                'json' => [
                    'model' => 'gpt-3.5-turbo',
                    'messages' => [
                        ['role' => 'system', 'content' => 'You are a helpful assistant.'],
                        ['role' => 'user', 'content' => $question],
                    ],
                    'max_tokens' => 150,
                ],
            ]);

            // Przetwórz odpowiedź
            $body = json_decode($response->getBody(), true);

            // Zwróć odpowiedź z API
            return $body['choices'][0]['message']['content'] ?? 'Brak odpowiedzi.';
        } catch (\GuzzleHttp\Exception\ClientException $e) {
            // Obsłuż błąd 429 lub inne błędy
            $statusCode = $e->getResponse()->getStatusCode();
            if ($statusCode == 429) {
                return 'Przekroczyłeś limit zapytań. Spróbuj ponownie później.';
            } else {
                return 'Wystąpił błąd: ' . $e->getMessage();
            }
        } catch (\Exception $e) {
            return 'Wystąpił błąd: ' . $e->getMessage();
        }
    }
}
