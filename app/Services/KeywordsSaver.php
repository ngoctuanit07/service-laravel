<?php

namespace App\Services;

use App\GoogleKeyword;
use Illuminate\Database\QueryException;

class KeywordsSaver
{
    public function saveResults($url, $results, $userId)
    {
        try {
            foreach ($results as $result) {
                GoogleKeyword::create([
                    'url' => $url,
                    'keyword' => $this->getKeyword($result),
                    'date' => $this->getDate($result),
                    'clicks' => $result->clicks,
                    'impressions' => $result->impressions,
                    'ctr' => $result->ctr,
                    'avg_position' => $result->position,
                    'user_id' => $userId,
                ]);
            }
        } catch (QueryException $e) {
        }
    }

    protected function getKeyword($result)
    {
        return $result->keys[0];
    }

    protected function getDate($result)
    {
        return $result->keys[1];
    }
}
