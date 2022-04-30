<?php

namespace App\Http\Controllers;
use App\Jobs\RssScrapeJob;
use App\Models\RSSfeed;
use KubAT\PhpSimple\HtmlDomParser;
use Symfony\Component\HttpClient\HttpClient;

class CrawlerController extends Controller
{
    public function dpgcrawler()
    {
        $url = 'https://www.tubantia.nl/almelo/brand-in-geparkeerde-bestelbus-in-almelo-40-jarige-man-opgepakt-op-verdenking-brandstichting~a6962c9d/';

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $response = curl_exec($ch);

        $dom = HtmlDomParser::str_get_html($response);

        $figure = $dom->find('picture.article__image')[0]->innertext;
        $page_title = $dom->find('h1.article__title')[0]->innertext;
        $article_intro = $dom->find('p.article__intro')[0]->innertext;
        $article_source = $dom->find('span.article__source')[0]->innertext;
        $article_time = $dom->find('time.article__time')[0]->innertext;
        $article_update = $dom->find('span.article__update')[0]->innertext;
        $article_credit = $dom->find('span.article__credit')[0]->innertext;
        $article = $dom->find('
        div.article__component.article__component--paragraph,
        div.article__component.article__component--subheader,
        div.article__component.article__component--quote,
        div.article__component.article__component--picture');
//        dd($article);

        echo $figure;
        echo '<br />';
        echo '<b>'.$page_title.'</b>';
        echo '<br />';
        echo $article_intro;
        echo '<p />';
        echo $article_source;
        echo '<br />';
        echo $article_time.' - '.$article_update;
        echo '<br />';
        echo $article_credit;
        echo '<br />';
        foreach ($article as $i) {
            echo $i->innertext;
        }

//        dd($dom);
    }
}
