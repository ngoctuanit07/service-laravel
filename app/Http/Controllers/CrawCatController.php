<?php
/**
* DISCLAIMER.
*
* Do not edit or add to this file if you wish to upgrade john theme to newer
* versions in the future.
*
* @category    Craw
*
* @author      John Nguyen
* @copyright   Copyright ( c ) John Nguyen
*/

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\CrawCat;
use App\ConfigCrawCat;
use DB;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\DomCrawler\Crawler;
use GuzzleHttp\Client;
use Illuminate\Support\Str;
use Exception;

class CrawCatController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    private $client;
    private $title;
    private $content;
    private $image;
    private $clientWp;

    public function __construct()
    {
        $this->middleware('permission:create_crawcat|delete_crawcat|edit_crawcat|view_crawcat', ['only' => ['index', 'store']]);
        $this->middleware('permission:create_crawcat', ['only' => ['create', 'store']]);
        $this->middleware('permission:edit_crawcat', ['only' => ['edit', 'update']]);
        $this->middleware('permission:delete_crawcat', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $user = Auth::user();
        $userId = $user->id;

        $craws = CrawCat::orderBy('id', 'DESC')->where('user_id', $userId)->paginate(15);

        return view('crawcat.index', compact('craws'))
        ->with('i', ($request->input('page', 1) - 1) * 15);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $craw = CrawCat::get();

        return view('crawcat.create', compact('craw'));
    }

    public function edit($id)
    {
        $craws = CrawCat::find($id);

        return view('crawcat.edit', compact('craws'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $arrJson = $request->post();
        $obj = (object) $arrJson;
        $url = $obj->cat_url;
        // $catUrls = $this->getUrls($url);
        $contentfull = $obj->contentfull;
        $title = $obj->title;
        $content = $obj->content;
        $featured_image = $obj->featured_image;
        $user = Auth::user();
        $userId = $user->id;
        ConfigCrawCat::create(['title' => $title, 'content' => $content, 'featured_image' => $featured_image, 'user_id' => $userId, 'cat_url' => $url, 'contentfull' => $contentfull]);
        // foreach($catUrls as $catUrl){
        //     $resultDatas = $this->getCrawlerContent($catUrl, $contentfull, $title, $content, $featured_image);
        //     foreach ($resultDatas as $data) {
        //         if (isset($data['title']) && $data['title'] && isset($data['content']) && $data['content'] && isset($data['featured_image']) && $data['featured_image']) {
        //             ConfigCrawCat::create(['title' => $data['title'], 'content' => $data['content'], 'featured_image' => $data['featured_image'], 'user_id' => $userId,'cat_url' =>  $url]);
        //         }
        //     }
        // }

        return redirect()->route('crawcat.index')
        ->with('success', 'CrawCat created successfully');
    }

    public function importCat()
    {
        $user = Auth::user();
        $userId = $user->id;
        DB::table('configcrawcat')
            ->where('user_id', $userId)
            ->update(['status' => 1]);

        return redirect()->route('crawcat.index')
        ->with('success', 'Import started, fun while few');
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

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int                      $id
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $craw = CrawCat::find($id);
        $craw->title = $request->input('title');
        $craw->content = $request->input('content');
        $craw->featured_image = $request->input('featured_image');
        $craw->save();

        return redirect()->route('crawcat.index')
        ->with('success', 'CrawCat updated successfully');
    }

    public function destroy($id)
    {
        CrawCat::find($id)->delete();

        return redirect()->route('crawcat.index')
        ->with('success', 'CrawCat deleted successfully');
    }

    /**
     * Content Crawler.
     */
    public function getCrawlerContent($url, $contentFull, $title, $contentCraw, $imageUrl)
    {
        try {
            $user = Auth::user();
            $website = $user->website;
            $this->client = new Client([
                'timeout' => 1000,
                'verify' => false,
                'base_uri' => $website.'wp-json/',
                'cookies' => true,
                'request.options' => [
                    'proxy' => 'tcp://117.2.82.96:53988',
                ],
            ]);
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

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function sync($id)
    {
        $datas = DB::table('crawcat')->where('id', $id)->get()->toArray();
        foreach ($datas as $key => $item) {
            $this->importPostWp($item->featured_image, $item->title, $item->content);
        }

        return redirect()->route('crawcat.index')
        ->with('success', 'Craw Sync successfully');
    }

    protected function loginWp()
    {
        $login = $this->client->post(
            'jwt-auth/v1/token',
            [
                'form_params' => [
                    'username' => 'admin',
                    'password' => 'Y7V(Ias0QtMNOGSvemhm34*z',
                ],
            ]
        );
        $resultData = json_decode((string) $login->getBody());

        return $resultData->token;
    }

    protected function importPostWp($featuredImageUrl, $title, $content)
    {
        $user = Auth::user();
        $token = '';
        if ($user->token && isset($user->token)) {
            $token = $user->token;
        } else {
            $token = $this->loginWp();
        }
        $website = $user->website;
        $this->clientWp = new Client([
            'timeout' => 1000,
            'verify' => false,
            'base_uri' => $website.'/wp-json/wp/v2/',
            'headers' => [
                'User-Agent' => 'johnsystem/v1.0',
                'Authorization' => 'Bearer '.$token,
                'Accept' => 'text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,image/apng,*/*;q=0.8',
                'Accept-Encoding' => 'gzip, deflate, br',
                'Content-type' => 'application/json',
                'Content-Disposition' => 'attachment',
            ],
            'referer' => true,
            'cookies' => true,
        ]);
        $imageOnMedia = $this->clientWp->post(
            'media',
            [
                'multipart' => [
                    [
                        'name' => 'file',
                        'contents' => file_get_contents($featuredImageUrl),
                        'filename' => Str::random(40).'.jpg',
                    ],
                ],
                'query' => [
                    'status' => 'publish',
                    'title' => 'blog góc lập trình',
                    'comment_status' => 'closed',
                    'ping_status' => 'closed',
                    'alt_text' => 'blog góc lập trình',
                    'description' => '',
                    'caption' => '',
                ],
            ]
        );
        $media = json_decode($imageOnMedia->getBody(), true);
        $post = $this->clientWp->post(
            'posts',
            [
                'multipart' => [
                    [
                        'name' => 'title',
                        'contents' => $title,
                    ],
                    [
                        'name' => 'content',
                        'contents' => $content,
                    ],
                    [
                        'name' => 'featured_media',
                        'contents' => $media['id'],
                    ],
                ],
                'query' => [
                    'status' => 'draft',
                ],
            ]
        );
    }

    protected function loginWpCongThucNauAn()
    {
        $this->client = new Client([
            'timeout' => 1000,
            'verify' => false,
            'base_uri' => 'https://congthucnauanngon.johnnguyenn.com/wp-json/',
            'cookies' => true,
            'request.options' => [
                'proxy' => 'tcp://117.2.82.96:53988',
            ],
        ]);
        $login = $this->client->post(
            'jwt-auth/v1/token',
            [
                'form_params' => [
                    'username' => 'admin',
                    'password' => 'Y7V(Ias0QtMNOGSvemhm34*z',
                ],
            ]
        );
        $resultData = json_decode((string) $login->getBody());

        return $resultData->token;
    }

    protected function importPostWpCongThucNauAn($featuredImageUrl, $title, $content)
    {
        $token = $this->loginWpCongThucNauAn();
        $user = Auth::user();
        if ($token && isset($token)) {
            $token = $user->token;
        } else {
            $token = $this->loginWpCongThucNauAn();
        }
        $website = $user->website;
        $this->clientWp = new Client([
            'timeout' => 1000,
            'verify' => false,
            'base_uri' => $website.'/wp-json/wp/v2/',
            'headers' => [
                'User-Agent' => 'johnsystem/v1.0',
                'Authorization' => 'Bearer '.$token,
                'Accept' => 'text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,image/apng,*/*;q=0.8',
                'Accept-Encoding' => 'gzip, deflate, br',
                'Content-type' => 'application/json',
                'Content-Disposition' => 'attachment',
            ],
            'referer' => true,
            'cookies' => true,
        ]);
        $imageOnMedia = $this->clientWp->post(
            'media',
            [
                'multipart' => [
                    [
                        'name' => 'file',
                        'contents' => file_get_contents($featuredImageUrl),
                        'filename' => Str::random(40).'.jpg',
                    ],
                ],
                'query' => [
                    'status' => 'publish',
                    'title' => 'blog góc lập trình',
                    'comment_status' => 'closed',
                    'ping_status' => 'closed',
                    'alt_text' => 'blog góc lập trình',
                    'description' => '',
                    'caption' => '',
                ],
            ]
        );
        $media = json_decode($imageOnMedia->getBody(), true);
        $post = $this->clientWp->post(
            'posts',
            [
                'multipart' => [
                    [
                        'name' => 'title',
                        'contents' => $title,
                    ],
                    [
                        'name' => 'content',
                        'contents' => $content,
                    ],
                    [
                        'name' => 'featured_media',
                        'contents' => $media['id'],
                    ],
                ],
                'query' => [
                    'status' => 'draft',
                    'categories' => 2,
                ],
            ]
        );
    }
}
