<?php

class HtmlScrap {
	function __construct()
	{
		$this->captcha = '/class=["\']([^"\']+)["\'][^>]*data-sitekey=["\']([^"\']+)["\'][^>]*>/i';
		$this->input = '/<input[^>]*name=["\'](.*?)["\'][^>]*value=["\'](.*?)["\'][^>]*>/i';
		$this->limit = '/(\d{1,})\/(\d{1,})/';
	}
	private function scrap($pattern, $html){
		preg_match_all($pattern, $html, $matches);
		return $matches;
	}
	private function getCaptcha($html)
	{
		$scrap = $this->scrap($this->captcha, $html);
		for($i = 0; $i < count($scrap[1]); $i++){
			$data[$scrap[1][$i]] = $scrap[2][$i];
		}
		return $data;
	}
	private function getInput($html)
	{
		$form = explode('<form', $html)[1];
		$scrap = $this->scrap($this->input, $form);
		for($i = 0; $i < count($scrap[1]); $i++){
			$data[$scrap[1][$i]] = $scrap[2][$i];
		}
		return $data;
	}
	public function Result($html)
	{
		$data['cloundflare']=(preg_match('/Just a moment.../',$html))? true:false;
		$data['firewall'] =(preg_match('/Firewall/',$html))? true:false;
		$data['locked'] = (preg_match('/Locked/',$html))? true:false;
		$data["captcha"] = $this->getCaptcha($html);
		$data["input"] = $this->getInput($html);
		$data["faucet"] = $this->scrap($this->limit, $html);
		return $data;
	}
}

$scrap = new HtmlScrap();
$html = file_get_contents("https://sollcrypto.com/home/page/bitcoin/");
$res = $scrap->Result($html);
print_r($res);