<?php
/**
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade john theme to newer
 * versions in the future.
 *
 * @category    Craw
 * @package     Craw data
 * @author      John Nguyen
 * @copyright   Copyright (c) John Nguyen
 */
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Craw;
use DB;
use Symfony\Component\DomCrawler\Crawler;
use GuzzleHttp\Client;
use Illuminate\Support\Str;
use Exception;

class CrawController extends Controller
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
        $this->client = new Client([
            'timeout' => 1000,
            'verify' => false,
            'base_uri' => 'https://johnnguyenn.com/wp-json/',
            'cookies' => true,
            'proxy' => 'http://114.106.151.212:38801/'
        ]);
        $this->middleware('permission:craw-show|craw-create|craw-edit|craw-delete', ['only' => ['index', 'store']]);
        $this->middleware('permission:craw-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:craw-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:craw-delete', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $craws = Craw::orderBy('id', 'DESC')->paginate(15);

        return view('craw.index', compact('craws'))
        ->with('i', ($request->input('page', 1) - 1) * 15);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $craw = Craw::get();

        return view('craw.create', compact('craw'));
    }

    public function edit($id)
    {
        $craws = Craw::find($id);

        return view('craw.edit', compact('craws'));
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
        $url = $obj->url;
        $contentfull = $obj->contentfull;
        $title = $obj->title;
        $content = $obj->content;
        $featured_image = $obj->featured_image;
        $resultDatas = $this->getCrawlerContent($url, $contentfull, $title, $content, $featured_image);
        foreach ($resultDatas as $data) {
            if (isset($data['title']) && $data['title'] && isset($data['content']) && $data['content'] && isset($data['featured_image']) && $data['featured_image']) {
                Craw::create(['title' => $data['title'], 'content' => $data['content'], 'featured_image' => $data['featured_image']]);
            }
        }

        return redirect()->route('craw.index')
        ->with('success', 'Craw created successfully');
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
        $craw = Craw::find($id);
        $craw->title = $request->input('title');
        $craw->content = $request->input('content');
        $craw->featured_image = $request->input('featured_image');
        $craw->save();

        return redirect()->route('craw.index')
        ->with('success', 'Craw updated successfully');
    }

    /**
     * Content Crawler.
     */
    public function getCrawlerContent($url, $contentFull, $title, $contentCraw, $imageUrl)
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

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function dongbo($id)
    {
        $datas = DB::table('craw')->where('id', $id)->get()->toArray();
        foreach ($datas as $key => $item) {
            if ($item->cat_id == 1) {
                $this->importPostWp($item->featured_image, $item->title, $item->content);
            } else {
                $this->importPostWpCongThucNauAn($item->featured_image, $item->title, $item->content);
            }
        }

        return redirect()->route('craw.index')
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
        $token = $this->loginWp();
        $this->clientWp = new Client([
            'timeout' => 1000,
        'verify' => false,
        'base_uri' => 'https://johnnguyenn.com/wp-json/wp/v2/',
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
        $this->clientWp = new Client([
            'timeout' => 1000,
        'verify' => false,
        'base_uri' => 'https://congthucnauanngon.johnnguyenn.com/wp-json/wp/v2/',
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
