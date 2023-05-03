<?php

namespace App\Services;


// TODO add interface
use App\Data\PersonDTO;
use App\Interfaces\PersonApiInterface;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;

class PersonApiService implements PersonApiInterface
{
    private const PERSON_CACHE_KEY = 'person-api-response-';
    private const TTL = 60 * 60 * 24 * 30; // in seconds

    public function __construct(
        private string $apiUrl,
        private string $apiKey
    ) {
    }

    public function getPerson(string $email): PersonDTO
    {
        $data = Cache::get(self::PERSON_CACHE_KEY . $email, function () use ($email) {
            $person = $this->fetchPersonFromAPI($email);
            Cache::put(self::PERSON_CACHE_KEY . $email, $person, self::TTL);
            return $person;
        });
        return PersonDTO::from($data);
    }

    public function fetchPersonFromAPI(string $email): array
    {
        return Http::withToken($this->apiKey)
            ->get($this->apiUrl . '/' . $email)
            ->json();
    }
}
