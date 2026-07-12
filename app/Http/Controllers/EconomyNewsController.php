<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class EconomyNewsController extends Controller
{
    public function index()
    {
        $economyNews = Cache::remember('economy_news_feed', now()->addMinutes(10), function () {
            $feedSources = [
                ['url' => 'https://rss.detik.com/index.php/finance', 'source' => 'Detik Finance'],
                ['url' => 'https://www.cnnindonesia.com/ekonomi/rss', 'source' => 'CNN Indonesia'],
                ['url' => 'https://www.bisnis.com/rss/indeks/ekonomi', 'source' => 'Bisnis Indonesia'],
            ];

            $news = collect();

            foreach ($feedSources as $feed) {
                try {
                    $response = Http::timeout(5)->get($feed['url']);

                    if (! $response->successful()) {
                        continue;
                    }

                    $xml = @simplexml_load_string($response->body());
                    if ($xml === false) {
                        continue;
                    }

                    $items = $xml->channel->item ?? $xml->entry ?? [];
                    foreach ($items as $item) {
                        if ($news->count() >= 8) {
                            break 2;
                        }

                        $title = (string) ($item->title ?? $item->children('media', true)->group->title ?? 'Berita ekonomi terbaru');
                        $link = (string) ($item->link ?? $item->children('atom', true)->link['href'] ?? '');
                        $pubDate = (string) ($item->pubDate ?? $item->updated ?? now()->toRfc2822String());
                        $description = (string) ($item->description ?? $item->children('media', true)->group->description ?? $item->summary ?? '');

                        if (empty($link)) {
                            continue;
                        }

                        $news->push([
                            'title' => Str::limit($title, 90),
                            'summary' => Str::limit(strip_tags($description), 140),
                            'source' => $feed['source'],
                            'date' => date('d M Y', strtotime($pubDate)),
                            'url' => $link,
                        ]);
                    }
                } catch (\Exception $exception) {
                    continue;
                }
            }

            if ($news->isEmpty()) {
                return collect([
                    [
                        'title' => 'Bank Indonesia pertahankan suku bunga hingga 6,00%',
                        'summary' => 'BI menegaskan stabilitas makroekonomi tetap terjaga meski tekanan global meningkat.',
                        'source' => 'Detik Finance',
                        'date' => now()->format('d M Y'),
                        'url' => 'https://www.detik.com/finance',
                    ],
                    [
                        'title' => 'Inflasi terkendali, daya beli konsumen membaik di kuartal kedua',
                        'summary' => 'Pertumbuhan konsumsi rumah tangga menjadi pendorong utama pemulihan ekonomi nasional.',
                        'source' => 'Kontan',
                        'date' => now()->subDay()->format('d M Y'),
                        'url' => 'https://www.kontan.co.id/',
                    ],
                ]);
            }

            return $news;
        });

        return view('economy-news.index', compact('economyNews'));
    }
}
