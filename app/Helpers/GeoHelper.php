<?php

namespace App\Helpers;

class GeoHelper
{

    public string $host = 'http://www.geoplugin.net/php.gp?ip={IP}&base_currency={CURRENCY}&lang={LANG}';

    public string $currency = 'USD';

    public string $lang = 'en';

    //initiate the geoPlugin vars
    public $ip = null;
    public $city = null;
    public $region = null;
    public $regionCode = null;
    public $regionName = null;
    public $dmaCode = null;
    public $countryCode = null;
    public $countryName = null;
    public $inEU = null;
    public $euVATrate = false;
    public $continentCode = null;
    public $continentName = null;
    public $latitude = null;
    public $longitude = null;
    public $locationAccuracyRadius = null;
    public $timezone = null;
    public $currencyCode = null;
    public $currencySymbol = null;
    public $currencyConverter = null;

    function __construct()
    {

    }

    function locate($ip = null)
    {

        global $_SERVER;

        if (is_null($ip)) {
            $ip = $_SERVER['REMOTE_ADDR'];
        }

        $host = str_replace('{IP}', $ip, $this->host);
        $host = str_replace('{CURRENCY}', $this->currency, $host);
        $host = str_replace('{LANG}', $this->lang, $host);

        $data = array();

        $response = $this->fetch($host);

        $data = unserialize($response);

        //set the geoPlugin vars
        $this->ip = $ip;
        $this->city = $data['geoplugin_city'];
        $this->region = $data['geoplugin_region'];
        $this->regionCode = $data['geoplugin_regionCode'];
        $this->regionName = $data['geoplugin_regionName'];
        $this->dmaCode = $data['geoplugin_dmaCode'];
        $this->countryCode = $data['geoplugin_countryCode'];
        $this->countryName = $data['geoplugin_countryName'];
        $this->inEU = $data['geoplugin_inEU'];
        $this->euVATrate = $data['geoplugin_euVATrate'];
        $this->continentCode = $data['geoplugin_continentCode'];
        $this->continentName = $data['geoplugin_continentName'];
        $this->latitude = $data['geoplugin_latitude'];
        $this->longitude = $data['geoplugin_longitude'];
        $this->locationAccuracyRadius = $data['geoplugin_locationAccuracyRadius'];
        $this->timezone = $data['geoplugin_timezone'];
        $this->currencyCode = $data['geoplugin_currencyCode'];
        $this->currencySymbol = $data['geoplugin_currencySymbol'];
        $this->currencyConverter = $data['geoplugin_currencyConverter'];

    }

    function fetch($host)
    {

        if (function_exists('curl_init')) {

            //use cURL to fetch data
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $host);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_USERAGENT, 'geoPlugin PHP Class v1.1');
            $response = curl_exec($ch);
            curl_close($ch);

        } else if (ini_get('allow_url_fopen')) {

            //fall back to fopen()
            $response = file_get_contents($host, 'r');

        } else {

            trigger_error('geoPlugin class Error: Cannot retrieve data. Either compile PHP with cURL support or enable allow_url_fopen in php.ini ', E_USER_ERROR);
            return;

        }

        return $response;
    }

    function convert($amount, $float = 2, $symbol = true)
    {

        //easily convert amounts to geolocated currency.
        if (!is_numeric($this->currencyConverter) || $this->currencyConverter == 0) {
            trigger_error('geoPlugin class Notice: currencyConverter has no value.', E_USER_NOTICE);
            return $amount;
        }
        if (!is_numeric($amount)) {
            trigger_error('geoPlugin class Warning: The amount passed to geoPlugin::convert is not numeric.', E_USER_WARNING);
            return $amount;
        }
        if ($symbol === true) {
            return $this->currencySymbol . round(($amount * $this->currencyConverter), $float);
        } else {
            return round(($amount * $this->currencyConverter), $float);
        }
    }

    function nearby($radius = 10, $limit = null)
    {

        if (!is_numeric($this->latitude) || !is_numeric($this->longitude)) {
            trigger_error('geoPlugin class Warning: Incorrect latitude or longitude values.', E_USER_NOTICE);
            return array(array());
        }

        $host = "http://www.geoplugin.net/extras/nearby.gp?lat=" . $this->latitude . "&long=" . $this->longitude . "&radius={$radius}";

        if (is_numeric($limit))
            $host .= "&limit={$limit}";

        return unserialize($this->fetch($host));

    }

    public function fetchCountry(string $countryCode): string
    {
        $country = [
            'LKL' => 'LOCAL PC',
            'A1' => "Anonymous Proxy",
            'A2' => "Satellite Provider",
            'AD' => "Andorra",
            'AE' => "United Arab Emirates",
            'AF' => "Afghanistan",
            'AG' => "Antigua and Barbuda",
            'AI' => "Anguilla",
            'AL' => "Albania",
            'AM' => "Armenia",
            'AN' => "Netherlands Antilles",
            'AO' => "Angola",
            'AP' => "Asia/Pacific Region",
            'AQ' => "Antarctica",
            'AR' => "Argentina",
            'AS' => "American Samoa",
            'AT' => "Austria",
            'AU' => "Australia",
            'AW' => "Aruba",
            'AX' => "Aland Islands",
            'AZ' => "Azerbaijan",
            'BA' => "Bosnia and Herzegovina",
            'BB' => "Barbados",
            'BD' => "Bangladesh",
            'BE' => "Belgium",
            'BF' => "Burkina Faso",
            'BG' => "Bulgaria",
            'BH' => "Bahrain",
            'BI' => "Burundi",
            'BJ' => "Benin",
            'BM' => "Bermuda",
            'BN' => "Brunei Darussalam",
            'BO' => "Bolivia",
            'BR' => "Brazil",
            'BS' => "Bahamas",
            'BT' => "Bhutan",
            'BV' => "Bouvet Island",
            'BW' => "Botswana",
            'BY' => "Belarus",
            'BZ' => "Belize",
            'CA' => "Canada",
            'CC' => "Cocos (Keeling) Islands",
            'CD' => "Congo, The Democratic Republic of the",
            'CF' => "Central African Republic",
            'CG' => "Congo",
            'CH' => "Switzerland",
            'CI' => "Cote d'Ivoire",
            'CK' => "Cook Islands",
            'CL' => "Chile",
            'CM' => "Cameroon",
            'CN' => "China",
            'CO' => "Colombia",
            'CR' => "Costa Rica",
            'CU' => "Cuba",
            'CV' => "Cape Verde",
            'CX' => "Christmas Island",
            'CY' => "Cyprus",
            'CZ' => "Czech Republic",
            'DE' => "Germany",
            'DJ' => "Djibouti",
            'DK' => "Denmark",
            'DM' => "Dominica",
            'DO' => "Dominican Republic",
            'DZ' => "Algeria",
            'EC' => "Ecuador",
            'EE' => "Estonia",
            'EG' => "Egypt",
            'EH' => "Western Sahara",
            'ER' => "Eritrea",
            'ES' => "Spain",
            'ET' => "Ethiopia",
            'EU' => "Europe",
            'FI' => "Finland",
            'FJ' => "Fiji",
            'FK' => "Falkland Islands (Malvinas)",
            'FM' => "Micronesia, Federated States of",
            'FO' => "Faroe Islands",
            'FR' => "France",
            'GA' => "Gabon",
            'GB' => "United Kingdom",
            'GD' => "Grenada",
            'GE' => "Georgia",
            'GF' => "French Guiana",
            'GG' => "Guernsey",
            'GH' => "Ghana",
            'GI' => "Gibraltar",
            'GL' => "Greenland",
            'GM' => "Gambia",
            'GN' => "Guinea",
            'GP' => "Guadeloupe",
            'GQ' => "Equatorial Guinea",
            'GR' => "Greece",
            'GS' => "South Georgia and the South Sandwich Islands",
            'GT' => "Guatemala",
            'GU' => "Guam",
            'GW' => "Guinea-Bissau",
            'GY' => "Guyana",
            'HK' => "Hong Kong",
            'HM' => "Heard Island and McDonald Islands",
            'HN' => "Honduras",
            'HR' => "Croatia",
            'HT' => "Haiti",
            'HU' => "Hungary",
            'ID' => "Indonesia",
            'IE' => "Ireland",
            'IL' => "Israel",
            'IM' => "Isle of Man",
            'IN' => "India",
            'IO' => "British Indian Ocean Territory",
            'IQ' => "Iraq",
            'IR' => "Iran, Islamic Republic of",
            'IS' => "Iceland",
            'IT' => "Italy",
            'JE' => "Jersey",
            'JM' => "Jamaica",
            'JO' => "Jordan",
            'JP' => "Japan",
            'KE' => "Kenya",
            'KG' => "Kyrgyzstan",
            'KH' => "Cambodia",
            'KI' => "Kiribati",
            'KM' => "Comoros",
            'KN' => "Saint Kitts and Nevis",
            'KP' => "Korea, Democratic People's Republic of",
            'KR' => "Korea, Republic of",
            'KW' => "Kuwait",
            'KY' => "Cayman Islands",
            'KZ' => "Kazakhstan",
            'LA' => "Lao People's Democratic Republic",
            'LB' => "Lebanon",
            'LC' => "Saint Lucia",
            'LI' => "Liechtenstein",
            'LK' => "Sri Lanka",
            'LR' => "Liberia",
            'LS' => "Lesotho",
            'LT' => "Lithuania",
            'LU' => "Luxembourg",
            'LV' => "Latvia",
            'LY' => "Libyan Arab Jamahiriya",
            'MA' => "Morocco",
            'MC' => "Monaco",
            'MD' => "Moldova, Republic of",
            'ME' => "Montenegro",
            'MG' => "Madagascar",
            'MH' => "Marshall Islands",
            'MK' => "Macedonia",
            'ML' => "Mali",
            'MM' => "Myanmar",
            'MN' => "Mongolia",
            'MO' => "Macao",
            'MP' => "Northern Mariana Islands",
            'MQ' => "Martinique",
            'MR' => "Mauritania",
            'MS' => "Montserrat",
            'MT' => "Malta",
            'MU' => "Mauritius",
            'MV' => "Maldives",
            'MW' => "Malawi",
            'MX' => "Mexico",
            'MY' => "Malaysia",
            'MZ' => "Mozambique",
            'NA' => "Namibia",
            'NC' => "New Caledonia",
            'NE' => "Niger",
            'NF' => "Norfolk Island",
            'NG' => "Nigeria",
            'NI' => "Nicaragua",
            'NL' => "Netherlands",
            'NO' => "Norway",
            'NP' => "Nepal",
            'NR' => "Nauru",
            'NU' => "Niue",
            'NZ' => "New Zealand",
            'OM' => "Oman",
            'PA' => "Panama",
            'PE' => "Peru",
            'PF' => "French Polynesia",
            'PG' => "Papua New Guinea",
            'PH' => "Philippines",
            'PK' => "Pakistan",
            'PL' => "Poland",
            'PM' => "Saint Pierre and Miquelon",
            'PN' => "Pitcairn",
            'PR' => "Puerto Rico",
            'PS' => "Palestinian Territory",
            'PT' => "Portugal",
            'PW' => "Palau",
            'PY' => "Paraguay",
            'QA' => "Qatar",
            'RE' => "Reunion",
            'RO' => "Romania",
            'RS' => "Serbia",
            'RU' => "Russian Federation",
            'RW' => "Rwanda",
            'SA' => "Saudi Arabia",
            'SB' => "Solomon Islands",
            'SC' => "Seychelles",
            'SD' => "Sudan",
            'SE' => "Sweden",
            'SG' => "Singapore",
            'SH' => "Saint Helena",
            'SI' => "Slovenia",
            'SJ' => "Svalbard and Jan Mayen",
            'SK' => "Slovakia",
            'SL' => "Sierra Leone",
            'SM' => "San Marino",
            'SN' => "Senegal",
            'SO' => "Somalia",
            'SR' => "Suriname",
            'ST' => "Sao Tome and Principe",
            'SV' => "El Salvador",
            'SY' => "Syrian Arab Republic",
            'SZ' => "Swaziland",
            'TC' => "Turks and Caicos Islands",
            'TD' => "Chad",
            'TF' => "French Southern Territories",
            'TG' => "Togo",
            'TH' => "Thailand",
            'TJ' => "Tajikistan",
            'TK' => "Tokelau",
            'TL' => "Timor-Leste",
            'TM' => "Turkmenistan",
            'TN' => "Tunisia",
            'TO' => "Tonga",
            'TR' => "Turkey",
            'TT' => "Trinidad and Tobago",
            'TV' => "Tuvalu",
            'TW' => "Taiwan",
            'TZ' => "Tanzania, United Republic of",
            'UA' => "Ukraine",
            'UG' => "Uganda",
            'UM' => "United States Minor Outlying Islands",
            'US' => "United States",
            'UY' => "Uruguay",
            'UZ' => "Uzbekistan",
            'VA' => "Holy See (Vatican City State)",
            'VC' => "Saint Vincent and the Grenadines",
            'VE' => "Venezuela",
            'VG' => "Virgin Islands, British",
            'VI' => "Virgin Islands, U.S.",
            'VN' => "Vietnam",
            'VU' => "Vanuatu",
            'WF' => "Wallis and Futuna",
            'WS' => "Samoa",
            'YE' => "Yemen",
            'YT' => "Mayotte",
            'ZA' => "South Africa",
            'ZM' => "Zambia",
            'ZW' => "Zimbabwe"
        ];
        return $country[$countryCode];
    }
}
