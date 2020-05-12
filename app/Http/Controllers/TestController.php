<?php

namespace App\Http\Controllers;

use GuzzleHttp\Client;

class TestController extends Controller
{
    private $client;
    private $title;
    private $content;
    private $image;

    public function __construct()
    {
        $username = 'admin';
        $password = 'Y7V(Ias0QtMNOGSvemhm34*z';
        $this->client = new Client([
            'timeout' => 10,
            'verify' => false,
            'base_uri' => 'https://johnnguyenn.com/wp-json/wp/v2/',
            'headers' => [
                'Authorization' => 'Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwczpcL1wvam9obm5ndXllbm4uY29tIiwiaWF0IjoxNTg4ODYwNjY2LCJuYmYiOjE1ODg4NjA2NjYsImV4cCI6MTU4OTQ2NTQ2NiwiZGF0YSI6eyJ1c2VyIjp7ImlkIjoiMSJ9fX0._QGEP6bMaC1u43xJaSw5LCbmLdKoXaKNh_aXorCTvdg',
                'Accept' => 'application/json',
                'Content-type' => 'application/json',
                'Content-Disposition' => 'attachment',
            ],
        ]);
    }

    public function index()
    {
        // $urls = $this->getUrls('https://hocwordpress.vn/lap-trinh-theme');
        // foreach ($urls as $url) {
        //     echo $url.'<br/>';
        // }
        $var = $this->fread_url('https://www.cet.edu.vn/dao-tao/che-bien-mon-an/cong-thuc');

        preg_match_all("/a[\s]+[^>]*?href[\s]?=[\s\"\']+".
                    "(.*?)[\"\']+.*?>"."([^<]+|.*?)?<\/a>/", $var, $matches);

        $matches = $matches[1];
        $list = array();

        foreach ($matches as $var) {
            echo $var.'<br>';
        }

        $excel = Importer::make('Excel');
        $excel->load($filepath);
        $excel->setSheet($sheetNumber);
        $collection = $excel->getCollection();
        //dd($collection)
    }

    public function fread_url($url, $ref = '')
    {
        if (function_exists('curl_init')) {
            $ch = curl_init();
            $user_agent = 'Mozilla/4.0 (compatible; MSIE 5.01; '.
                          'Windows NT 5.0)';
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_USERAGENT, $user_agent);
            curl_setopt($ch, CURLOPT_HTTPGET, 1);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_REFERER, $ref);
            curl_setopt($ch, CURLOPT_COOKIEJAR, 'cookie.txt');
            $html = curl_exec($ch);
            curl_close($ch);
        } else {
            $hfile = fopen($url, 'r');
            if ($hfile) {
                while (!feof($hfile)) {
                    $html .= fgets($hfile, 1024);
                }
            }
        }

        return $html;
    }

    public function getinboundLinks($domain_name)
    {
        ini_set('user_agent', 'NameOfAgent (<a class="linkclass" href="http://localhost">http://localhost</a>)');
        $url = $domain_name;
        $url_without_www = str_replace('http://', '', $url);
        $url_without_www = str_replace('www.', '', $url_without_www);
        $url_without_www = str_replace(strstr($url_without_www, '/'), '', $url_without_www);
        $url_without_www = trim($url_without_www);
        $input = @file_get_contents($url) or die('Could not access file: $url');
        $regexp = "<a\s[^>]*href=(\"??)([^\" >]*?)\\1[^>]*>(.*)<\/a>";
        //$inbound=0;
        $outbound = 0;
        $nonfollow = 0;
        if (preg_match_all("/$regexp/siU", $input, $matches, PREG_SET_ORDER)) {
            foreach ($matches as $match) {
                // $match[2] = link address
                // $match[3] = link text
                //echo $match[3].'<br>';
                if (!empty($match[2]) && !empty($match[3])) {
                    if (strstr(strtolower($match[2]), 'URL:') || strstr(strtolower($match[2]), 'url:')) {
                        ++$nonfollow;
                    } elseif (strstr(strtolower($match[2]), $url_without_www) || !strstr(strtolower($match[2]), 'http://')) {
                        ++$inbound;
                        echo '<br>inbound '.$match[2];
                    } elseif (!strstr(strtolower($match[2]), $url_without_www) && strstr(strtolower($match[2]), 'http://')) {
                        echo '<br>outbound '.$match[2];
                        ++$outbound;
                    }
                }
            }
        }
        $links['inbound'] = $inbound;
        $links['outbound'] = $outbound;
        $links['nonfollow'] = $nonfollow;

        return $links;
    }

    public function crawl_page($page_url, $domain)
    {
        /* $page_url - page to extract links from, $domain -
            crawl only this domain (and subdomains)
            Returns an array of absolute URLs or false on failure.
        */

        /* I'm using cURL to retrieve the page */
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $page_url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);

        /* Spoof the User-Agent header value; just to be safe */
        curl_setopt($ch, CURLOPT_USERAGENT,
              'Mozilla/4.0 (compatible; MSIE 5.01; Windows NT 5.0)');

        /* I set timeout values for the connection and download
        because I don't want my script to get stuck
        downloading huge files or trying to connect to
        a nonresponsive server. These are optional. */
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
        curl_setopt($ch, CURLOPT_TIMEOUT, 15);

        /* This ensures 404 Not Found (and similar) will be
            treated as errors */
        curl_setopt($ch, CURLOPT_FAILONERROR, true);

        /* This might/should help against accidentally
          downloading mp3 files and such, but it
          doesn't really work :/  */
        $header[] = 'Accept: text/html, text/*';
        curl_setopt($ch, CURLOPT_HTTPHEADER, $header);

        /* Download the page */
        $html = curl_exec($ch);
        curl_close($ch);

        if (!$html) {
            return false;
        }

        /* Extract the BASE tag (if present) for
          relative-to-absolute URL conversions later */
        if (preg_match('/<base&#91;\s&#93;+href=\s*&#91;\"\'&#93;?(&#91;^\'\" >]+)[\'\" >]/i', $html, $matches)) {
            $base_url = $matches[1];
        } else {
            $base_url = $page_url;
        }

        $links = array();

        $html = str_replace("\n", ' ', $html);
        preg_match_all('/<a&#91;\s&#93;+&#91;^>]*href\s*=\s*([\"\']+)([^>]+?)(\1|>)/i', $html, $m);
        /* this regexp is a combination of numerous
            versions I saw online; should be good. */

        foreach ($m[2] as $url) {
            $url = trim($url);

            /* get rid of PHPSESSID, #linkname, &amp; and javascript: */
            $url = preg_replace(
                    array('/([\?&]PHPSESSID=\w+)$/i', '/(#[^\/]*)$/i', '/&amp;/', '/^(javascript:.*)/i'),
                    array('', '', '&', ''),
                    $url);

            /* turn relative URLs into absolute URLs.
              relative2absolute() is defined further down
              below on this page. */
            $url = relative2absolute($base_url, $url);

            // check if in the same (sub-)$domain
            if (preg_match("/^http[s]?:\/\/[^\/]*".str_replace('.', '\.', $domain).'/i', $url)) {
                //save the URL
                if (!in_array($url, $links)) {
                    $links[] = $url;
                }
            }
        }

        return $links;
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
