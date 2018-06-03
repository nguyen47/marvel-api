<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ComicController extends Controller
{
	public function getHero(Request $request){
		if ($request->input('characters')) {
			$characters = $request->input('characters');
			$ts = time();
			$hash = md5($ts.env('PRIV_KEY').env('PUBL_KEY'));
			$params = [
				'apikey' => env('PUBL_KEY'),
				'ts' => $ts,
				'hash' => $hash
			];
			$url = "https://gateway.marvel.com:443/v1/public/characters?name=".$characters.'&'.http_build_query($params);
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($ch, CURLOPT_URL,$url);
			$result=curl_exec($ch);
			curl_close($ch);
			$result = json_decode($result, true);
			if (!empty($result['data']['results'])) {
				$data = $result['data']['results'][0];
				$arrayComics = $result['data']['results'][0]['comics']['items'];

				$comicsInformation = [];
				for ($i=0; $i < count($arrayComics); $i++) { 
					$comicUrl = explode("/", $arrayComics[$i]['resourceURI']);
					$comicId = end($comicUrl);

					$url = "https://gateway.marvel.com:443/v1/public/comics/".$comicId.'?'.http_build_query($params);

					$ch = curl_init();
					curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
					curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
					curl_setopt($ch, CURLOPT_URL,$url);
					$result=curl_exec($ch);
					curl_close($ch);
					$result = json_decode($result, true);					
					array_push($comicsInformation, $result['data']['results'][0]);

				}
				return view('herodetails', compact('data','comicsInformation'));
			} else {
				return "DEO CO HERO";
			}
			
		}
		return view('hero');
	}
}
