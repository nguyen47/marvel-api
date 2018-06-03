<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ComicController extends Controller
{
	public function getHero(Request $request){
		if ($request->input('characters')) {
			$characters = $request->input('characters');
			$ts = time();
			$hash = md5($ts."20e47789c610164804b5a941825f8b065a0a90f2"."cdc0925698b9fc7e092dfa8e0fe9cc96");
			$params = [
				'apikey' => "cdc0925698b9fc7e092dfa8e0fe9cc96",
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
			dd($result);
			if (isset($result['data']['results'])) {
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
