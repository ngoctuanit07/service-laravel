<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\CrawCat as CrawCategory;
use App\ConfigCrawCat;
use Symfony\Component\DomCrawler\Crawler;
use GuzzleHttp\Client;
use DB;
class CrawCat extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'craw:cat';
    private $client;
    private $title;
    private $content;
    private $image;
    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Craw Data From category';

    /**
     * Create a new command instance.
     */
    public function __construct()
    {
        parent::__construct();
        $this->client = new Client([
            'timeout' => 1000,
            'verify' => false,
            'request.options' => [
                'proxy' => 'tcp://113.160.234.147:47469',
            ],
        ]);
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $configCats = ConfigCrawCat::orderBy('id', 'DESC')->get();
        foreach ($configCats as $configcat) {
            if ($configcat->status == 1) {
                $title = $configcat->title;
                $content = $configcat->content;
                $imageUrl = $configcat->featured_image;
                $contentFull = $configcat->contentfull;
                $url = $configcat->cat_url;
                $this->crawCat($url, $contentFull, $title, $content, $imageUrl, $configcat->user_id);
            }
        }
    }

    protected function crawCat($url, $contentFull, $title, $contentCraw, $imageUrl, $userId)
    {
        $catUrls = $this->getUrls($url);
        $count = count($catUrls);
        $count2 = 0;
        foreach ($catUrls as $catUrl) {
            $resultDatas = $this->getCrawlerContent($catUrl, $contentFull, $title, $contentCraw, $imageUrl);
            foreach ($resultDatas as $data) {
                if (isset($data['title']) && $data['title'] && isset($data['content']) && $data['content'] && isset($data['featured_image']) && $data['featured_image']) {
                    $crawDataCheck = DB::table('crawcat')->where('title', $data['title'])->first();
                    if ($crawDataCheck && isset($crawDataCheck)) {
                        break;
                    } else {
                        CrawCategory::create(['title' => $data['title'], 'content' => $data['content'], 'featured_image' => $data['featured_image'], 'user_id' => $userId, 'cat_url' => $url]);   
                    }
                }
            }
            $count2++;
            sleep(60);
        }
        if($count == $count2){
                 DB::table('configcrawcat')
                    ->where('user_id', $userId)
                    ->update(['status' => 0]);
        }
    }

    protected function getCrawlerContent($url, $contentFull, $title, $contentCraw, $imageUrl)
    {
        try {
            $response = $this->client->get($url);
            // URL, where you want to fetch the content
            // get content and pass to the crawler
            $content = $response->getBody()->getContents();
            $crawler = new Crawler($content);
            $this->title = $title;
            $this->content = $contentCraw;
            $this->image = $imageUrl;
            $_this = $this;
            $data = $crawler->filter($contentFull)
            ->each(
                function (Crawler $node, $i) use ($_this) {
                    return $_this->getNodeContent($node, $_this);
                }
            );

            return $data;
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }

    /**
     * Check is content available.
     */
    private function hasContent($node)
    {
        return $node->count() > 0 ? true : false;
    }

    /**
     * Get node values.
     *
     * @filter function required the identifires, which we want to filter from the content.
     */
    private function getNodeContent($node, $_this)
    {
        $array = [
            'title' => $this->hasContent($node->filter($_this->title)) != false ? $node->filter($_this->title)->text() : '',
            'content' => $this->hasContent($node->filter($_this->content)) != false ? $node->filter($_this->content)->html() : '',
            'featured_image' => $this->hasContent($node->filter($_this->image)) != false ? $node->filter($_this->image)->eq(0)->attr('src') : '',
        ];

        return $array;
    }

    public function getUrls($url = '')
    {
        $urls = [];

        if ($url != '') {
            $baseUrl = $url;
            $prefix = 'https';
            if (strpos($baseUrl, 'ttps://') === false) {
                $prefix = 'http';
            }
            $client = new Client();
            $response = $client->request('GET', $url);
            $html = $response->getBody();
            //Getting the exact url without http or https
            $url = str_replace('http://www.', '', $url);
            $url = str_replace('https://www.', '', $url);
            $url = str_replace('http://', '', $url);
            $url = str_replace('https://', '', $url);
            //Parsing the url for getting host information
            $parse = parse_url('https://'.$url);
            //Parsing the html of the base url
            $dom = new \DOMDocument();
            @$dom->loadHTML($html);
            // grab all the on the page
            $xpath = new \DOMXPath($dom);
            //finding the a tag
            $hrefs = $xpath->evaluate('/html/body//a');
            //Loop to display all the links
            $length = $hrefs->length;
            //Converting URLs to add the www prefix to host to a common array
            $baseUrl = str_replace('http://'.$parse['host'], 'http://www.'.$parse['host'], $baseUrl);
            $baseUrl = str_replace('https://'.$parse['host'], 'https://www.'.$parse['host'], $baseUrl);
            $urls = [$baseUrl];
            $allUrls = [$baseUrl];
            for ($i = 0; $i < $length; ++$i) {
                $href = $hrefs->item($i);
                $url = $href->getAttribute('href');
                $url = str_replace('http://'.$parse['host'], 'http://www.'.$parse['host'], $url);
                $url = str_replace('https://'.$parse['host'], 'https://www.'.$parse['host'], $url);
                //Replacing the / at the end of any url if present
                if (substr($url, -1, 1) == '/') {
                    $url = substr_replace($url, '', -1);
                }
                array_push($allUrls, $url);
            }

            //Looping for filtering the URLs into a distinct array
            foreach ($allUrls as $url) {
                //Limiting the number of urls on the site
                if (count($urls) >= 300) {
                    break;
                }
                //Filter the null links and images
                if (strpos($url, '#') === false) {
                    //Filtering the links with host
                    if (strpos($url, 'https://'.$parse['host']) !== false || strpos($url, 'https://www.'.$parse['host']) !== false) {
                        //Replacing the / at the end of any url if present
                        if (substr($url, -1, 1) == '/') {
                            $url = substr_replace($url, '', -1);
                        }
                        //Checking if the link is already preset in the final array
                        $urlSuffix = str_replace('http://www.', '', $url);
                        $urlSuffix = str_replace('https://www.', '', $urlSuffix);
                        $urlSuffix = str_replace('http://', '', $urlSuffix);
                        $urlSuffix = str_replace('https://', '', $urlSuffix);

                        if ($urlSuffix != $parse['host']) {
                            array_push($urls, $url);
                        }
                    }
                    //Filtering the links without host
                    if (strpos($url, $parse['host']) === false) {
                        if (substr($url, 0, 1) == '/') {
                            //Replacing the / at the end of any url if present
                            if (substr($url, -1, 1) == '/') {
                                $url = substr_replace($url, '', -1);
                            }
                            $newUrl = 'http://www.'.$parse['host'].$url;
                            $secondUrl = 'https://www.'.$parse['host'].$url;
                            if ($url != $parse['host']) {
                                //Checking if the link is already preset in the final array and the common array
                                if (!in_array($secondUrl, $urls) && !in_array($secondUrl, $allUrls) && !in_array($newUrl, $allUrls)) {
                                    if ($prefix == 'https') {
                                        $newUrl = $secondUrl;
                                    }
                                    array_push($urls, $newUrl);
                                }
                            }
                        }
                    }
                }
            }
        }

        return $urls;
    }
}
