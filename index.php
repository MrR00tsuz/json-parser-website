<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ülke Kodu Girin</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }

        h1 {
            text-align: center;
            margin-top: 20px;
            color: #333;
        }

        form {
            text-align: center;
            margin-top: 20px;
        }

        label {
            font-weight: bold;
        }

        textarea {
            width: 100%;
            padding: 10px;
            font-size: 16px;
            margin-bottom: 10px;
        }

        button {
            padding: 10px 20px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
        }

        button:hover {
            background-color: #45a049;
        }

        table {
            border-collapse: collapse;
            width: 80%;
            margin: 20px auto;
            background-color: #fff;
        }

        th, td {
            border: 1px solid #dddddd;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
    <h1>Ülke Kodu Girin</h1>
    <form method="GET">
        <label for="country_codes">Ülke Kodları (Her bir ülke kodunu ayrı satıra yazın):</label><br>
        <textarea id="country_codes" name="country_codes" rows="5" cols="3" required></textarea><br>
        <button type="submit">Gönder</button>
    </form>

    <?php
    if (isset($_GET['country_codes'])) {
        $ulkeler = explode("\n", $_GET['country_codes']); 

        echo "<table>";
        echo "<tr><th>Ülke</th><th>Şehir Adı</th></tr>";

        foreach ($ulkeler as $ulk) {
            $ulk = trim($ulk);

            if (empty($ulk)) continue;

            $country_name = get_country_name($ulk);

            if ($ulk === "TRNC") {
                echo "<tr><td>$country_name</td><td>KKTC</td></tr>"; 
                continue;
            }

            $url = "https://www.turkishairlines.com/com.thy.web.online.miles/ms/parameters/addressCities?countryCode=" . $ulk . "&stateCode=&_=1712054407755";
            
            $curl = curl_init($url);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            $response = curl_exec($curl);

            if ($response === false) {
                echo "<tr><td>$country_name</td><td>cURL Error: " . curl_error($curl) . "</td></tr>";
            } else {
                $data = json_decode($response, true);

                if (!empty($data)) {
                    foreach ($data["data"] as $city) {
                        echo "<tr>";
                        echo "<td>$country_name</td>";
                        echo "<td>" . $city["name"] . "</td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td>$country_name</td><td>Beklenen veri bulunamadı.</td></tr>";
                }
            }

            curl_close($curl);
        }

        echo "</table>";
    }

    function get_country_name($country_code) {
        $country_codes = array(
            "TR" => "Türkiye",
            "AF" => "Afganistan",
            "DE" => "Almanya",
            "US" => "Amerika Birleşik Devletleri",
            "AS" => "Amerikan Samoası",
            "AD" => "Andorra",
            "AO" => "Angola",
            "AI" => "Anguilla",
            "AQ" => "Antarktika",
            "AG" => "Antigua Ve Barbuda",
            "AR" => "Arjantin",
            "AL" => "Arnavutluk",
            "AW" => "Aruba",
            "AU" => "Avustralya",
            "AT" => "Avusturya",
            "AZ" => "Azerbaycan",
            "BS" => "Bahamalar",
            "BH" => "Bahreyn",
            "BD" => "Bangladeş",
            "BB" => "Barbados",
            "EH" => "Batı Sahra",
            "BY" => "Belarus",
            "BE" => "Belçika",
            "BZ" => "Belize",
            "BJ" => "Benin",
            "BM" => "Bermuda",
            "BT" => "Bhutan",
            "AE" => "Birleşik Arap Emirlikleri",
            "GB" => "Birleşik Krallık",
            "BO" => "Bolivya",
            "BA" => "Bosna-Hersek",
            "BW" => "Botsvana",
            "BV" => "Bouvet Adası",
            "BR" => "Brezilya",
            "IO" => "Britanya Hint Okyanusu Toprakları",
            "BN" => "Brunei Darusselam",
            "BG" => "Bulgaristan",
            "BF" => "Burkina Faso",
            "BI" => "Burundi",
            "KY" => "Cayman Adaları",
            "GI" => "Cebelitarık",
            "DZ" => "Cezayir",
            "CX" => "Christmas Adası",
            "DJ" => "Cibuti",
            "CC" => "Cocos (Keyling) Adaları",
            "CK" => "Cook Adaları",
            "CW" => "Curaçao",
            "TD" => "Çad",
            "CZ" => "Çekya",
            "CN" => "Çin",
            "DK" => "Danimarka",
            "CD" => "Demokratik Kongo",
            "TL" => "Doğu Timor",
            "DM" => "Dominika",
            "DO" => "Dominik Cumhuriyeti",
            "EC" => "Ekvador",
            "GQ" => "Ekvator Ginesi",
            "SV" => "El Salvador",
            "ID" => "Endonezya",
            "ER" => "Eritre",
            "AM" => "Ermenistan",
            "EE" => "Estonya",
            "ET" => "Etiyopya",
            "FK" => "Falkland Adaları",
            "FO" => "Faroe Adaları",
            "MA" => "Fas",
            "FJ" => "Fiji",
            "CI" => "Fildişi Sahili",
            "PH" => "Filipinler",
            "PS" => "Filistin",
            "FI" => "Finlandiya",
            "FR" => "Fransa",
            "GF" => "Fransız Guyanası",
            "TF" => "Fransız Güney ve Antarktika Toprakları",
            "PF" => "Fransız Polinezyası",
            "GA" => "Gabon",
            "GM" => "Gambiya",
            "GH" => "Gana",
            "GN" => "Gine",
            "GW" => "Gine-Bissau",
            "GD" => "Grenada",
            "GL" => "Grönland",
            "GP" => "Guadeloupe",
            "GU" => "Guam",
            "GT" => "Guatemala",
            "GY" => "Guyana",
            "ZA" => "Güney Afrika",
            "GS" => "Güney Georgia Ve Güney Sandwich Adaları",
            "KR" => "Güney Kore",
            "SS" => "Güney Sudan",
            "GE" => "Gürcistan",
            "HT" => "Haiti",
            "HM" => "Heard Adası Ve Mcdonald Adaları",
            "HR" => "Hırvatistan",
            "IN" => "Hindistan",
            "NL" => "Hollanda",
            "AN" => "Hollanda Antilleri",
            "HN" => "Honduras",
            "HK" => "Hong Kong - Çin Özel İdari Bölgesi",
            "IQ" => "Irak",
            "IR" => "İran",
            "IE" => "İrlanda",
            "ES" => "İspanya",
            "IL" => "İsrail",
            "SE" => "İsveç",
            "CH" => "İsviçre",
            "IT" => "İtalya",
            "IS" => "İzlanda",
            "JM" => "Jamaika",
            "JP" => "Japonya",
            "KH" => "Kamboçya",
            "CM" => "Kamerun",
            "CA" => "Kanada",
            "ME" => "Karadağ",
            "QA" => "Katar",
            "KZ" => "Kazakistan",
            "KE" => "Kenya",
            "KG" => "Kırgızistan",
            "KI" => "Kiribati",
            "KP" => "Kuzey Kore",
            "MK" => "Kuzey Makedonya",
            "MP" => "Kuzey Mariana Adaları",
            "CU" => "Küba",
            "LA" => "Laos",
            "LS" => "Lesoto",
            "LV" => "Letonya",
            "LR" => "Liberya",
            "LY" => "Libya",
            "LI" => "Lihtenştayn",
            "LT" => "Litvanya",
            "LB" => "Lübnan",
            "LU" => "Lüksemburg",
            "HU" => "Macaristan",
            "MG" => "Madagaskar",
            "MO" => "Makao - Çin Özel İdari Bölgesi",
            "MW" => "Malavi",
            "MV" => "Maldivler",
            "MY" => "Malezya",
            "ML" => "Mali",
            "MT" => "Malta",
            "MH" => "Marşal Adaları",
            "MQ" => "Martinique",
            "MR" => "Moritanya",
            "MU" => "Mauritius",
            "YT" => "Mayotte",
            "MX" => "Meksika",
            "EG" => "Mısır",
            "FM" => "Mikronezya",
            "MD" => "Moldova",
            "MC" => "Monako",
            "MN" => "Moğolistan",
            "MS" => "Montserrat",
            "MZ" => "Mozambik",
            "MM" => "Myanmar",
            "NA" => "Namibya",
            "NR" => "Nauru",
            "NP" => "Nepal",
            "NE" => "Nijer",
            "NG" => "Nijerya",
            "NI" => "Nikaragua",
            "NU" => "Niue",
            "NF" => "Norfolk Adası",
            "NO" => "Norveç",
            "CF" => "Orta Afrika",
            "UZ" => "Özbekistan",
            "PK" => "Pakistan",
            "PW" => "Palau",
            "PA" => "Panama",
            "PG" => "Papua Yeni Gine",
            "PY" => "Paraguay",
            "PE" => "Peru",
            "PN" => "Pitcairn Adaları",
            "PL" => "Polonya",
            "PT" => "Portekiz",
            "PR" => "Porto Riko",
            "RE" => "Reunion",
            "RO" => "Romanya",
            "RW" => "Ruanda",
            "RU" => "Rusya",
            "SH" => "Saint Helena",
            "KN" => "Saint Kitts Ve Nevis",
            "LC" => "Saint Lucia",
            "MF" => "Saint Marteen",
            "PM" => "Saint Pierre Ve Miquelon",
            "VC" => "Saint Vincent ve Grenadinler",
            "WS" => "Samoa",
            "SM" => "San Marino",
            "ST" => "Sao Tome Ve Prıncipe",
            "SN" => "Senegal",
            "SC" => "Seyşeller",
            "RS" => "Sırbistan",
            "SL" => "Sierra Leone",
            "SG" => "Singapur",
            "SK" => "Slovakya",
            "SI" => "Slovenya",
            "SB" => "Solomon Adaları",
            "SO" => "Somali",
            "LK" => "Sri Lanka",
            "SD" => "Sudan",
            "SR" => "Surinam",
            "SY" => "Suriye",
            "SA" => "Suudi Arabistan",
            "SJ" => "Svalbard Ve Jan Mayen Adaları",
            "SZ" => "Svaziland",
            "CL" => "Şili",
            "TJ" => "Tacikistan",
            "TZ" => "Tanzanya",
            "TH" => "Tayland",
            "TW" => "Tayvan - Çin",
            "TG" => "Togo",
            "TK" => "Tokelau",
            "TO" => "Tonga",
            "TT" => "Trinidad Ve Tobago",
            "TN" => "Tunus",
            "CY" => "Türk Cumhuriyeti Kuzey Kıbrıs",
            "TM" => "Türkmenistan",
            "UG" => "Uganda",
            "UA" => "Ukrayna",
            "OM" => "Umman",
            "UM" => "Unıted States Mınor Outlyıng Islands",
            "UY" => "Uruguay",
            "JO" => "Ürdün",
            "VU" => "Vanuatu",
            "VA" => "Vatikan",
            "VE" => "Venezuela",
            "VN" => "Vietnam",
            "VG" => "Virgin Adaları (İngiliz)",
            "VI" => "Virgin Adaları (ABD)",
            "WF" => "Wallis Ve Futuna Adaları",
            "YE" => "Yemen",
            "NC" => "Yeni Kaledonya",
            "NZ" => "Yeni Zelanda",
            "CV" => "Yeşil Burun Adaları",
            "YU" => "Yugoslavya",
            "GR" => "Yunanistan",
            "ZM" => "Zambiya",
            "ZW" => "Zimbabve",
        );

        return isset($country_codes[$country_code]) ? $country_codes[$country_code] : $country_code;
    }
    ?>
</body>
</html>
