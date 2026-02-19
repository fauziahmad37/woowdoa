<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class FirebaseService
{
    protected $credentials;
    protected $projectId;

    public function __construct()
    {
        $this->credentials = json_decode(file_get_contents(base_path(env('FIREBASE_CREDENTIALS'))), true);
        $this->projectId = env('FIREBASE_PROJECT_ID');
    }

    private function getAccessToken()
    {
        $now = time();
        $payload = [
            'iss' => $this->credentials['client_email'],
            'sub' => $this->credentials['client_email'],
            'aud' => $this->credentials['token_uri'],
            'iat' => $now,
            'exp' => $now + 3600,
            'scope' => 'https://www.googleapis.com/auth/firebase.messaging',
        ];

        $jwt = \Firebase\JWT\JWT::encode(
            $payload,
            $this->credentials['private_key'],
            'RS256'
        );

        $response = Http::asForm()->post($this->credentials['token_uri'], [
            'grant_type' => 'urn:ietf:params:oauth:grant-type:jwt-bearer',
            'assertion' => $jwt,
        ]);

        return $response->json()['access_token'];
    }

    public function sendNotification($deviceToken, $title, $body)
    {
        $accessToken = $this->getAccessToken();

        $url = "https://fcm.googleapis.com/v1/projects/{$this->projectId}/messages:send";

        return Http::withToken($accessToken)
            ->post($url, [
                'message' => [
                    'token' => $deviceToken,
                    'notification' => [
                        'title' => $title,
                        'body' => $body,
                    ],
                ],
            ])
            ->json();
    }

    public function sendToTopic($topic, $title, $body)
    {
        $accessToken = $this->getAccessToken();

        $url = "https://fcm.googleapis.com/v1/projects/{$this->projectId}/messages:send";

        return Http::withToken($accessToken)
            ->post($url, [
                'message' => [
                    'topic' => $topic,
                    'notification' => [
                        'title' => $title,
                        'body' => $body,
                    ],
                ],
            ])
            ->json();
    }
}
