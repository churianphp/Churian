<?php

class IpHandler {
	public $ip;

	public function __construct($ip=null) {
		$this->ip = filter_var($ip, FILTER_VALIDATE_IP) ? $ip : $this->ip_dectect();
	}

	public function get_data($purpose=false) {
		$ip_data = $this->ip_data();

		$continent = [
			"AF" => "Africa",
			"AN" => "Antarctica",
			"AS" => "Asia",
			"EU" => "Europe",
			"OC" => "Australia (Oceania)",
			"NA" => "North America",
			"SA" => "South America"
		];

		$address = array(@$ip_data->geoplugin_countryName);

		if (strlen(@$ip_data->geoplugin_regionName) >= 1) $address[] = @$ip_data->geoplugin_regionName;
		if (strlen(@$ip_data->geoplugin_city) >= 1) $address[] = @$ip_data->geoplugin_city;

		$address = implode(", ", array_reverse($address));

		switch (strtolower($purpose)) {
			case false:
				return array(
					"continent" => @$continent[strtoupper($ip_data->geoplugin_continentCode)],
					"continent_code" => @$ip_data->geoplugin_continentCode,
					"country" => @$ip_data->geoplugin_countryName,
					"country_code" => @$ip_data->geoplugin_countryCode,
					"city" => @$ip_data->geoplugin_city,
					"state" => @$ip_data->geoplugin_regionName,
					"address" => @$address,
					"currency_code" => @$ip_data->geoplugin_currencyCode,
					"currency_symbol" => @$ip_data->geoplugin_currencySymbol_UTF8,
					"currency_convertion" => @$ip_data->geoplugin_currencyConverter,
				);

			case "continent":
				return @$continent[strtoupper($ip_data->geoplugin_continentCode)];

			case "continent_code":
				return @$ip_data->geoplugin_continentCode;

			case "country":
				return @$ip_data->geoplugin_countryName;

			case "country_code":
				return @$ip_data->geoplugin_continentCode;

			case "city":
				return @$ip_data->geoplugin_city;

			case "state":
				return @$ip_data->geoplugin_regionName;

			case "address":
				return @$address;

			case "currency_code":
				return @$ip_data->geoplugin_currencyCode;

			case "currency_symbol":
				return @$ip_data->geoplugin_currencySymbol_UTF8;

			case "currency_convertion":
				return @$ip_data->geoplugin_currencyConverter;
		}
	}

	private function ip_data() {
		return @json_decode(file_get_contents("http://www.geoplugin.net/json.gp?ip=$this->ip"));
	}

	private function ip_dectect() {
		if (array_key_exists("REMOTE_ADDR", $_SERVER)) return $_SERVER["REMOTE_ADDR"];
		if (array_key_exists("HTTP_X_FORWARDED_FOR", $_SERVER)) return $_SERVER["HTTP_X_FORWARDED_FOR"];
		if (array_key_exists("HTTP_CLIENT_IP", $_SERVER)) return $_SERVER["HTTP_CLIENT_IP"];
	}
}

?>