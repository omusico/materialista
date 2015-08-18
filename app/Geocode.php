<?php

namespace App;

class Geocode
{
    /**
     * Function to geocode address, it will return false if unable to geocode address
     * @param $address
     * @return array|bool
     */
    public static function geocodeAddress($address)
    {
        $address = urlencode($address);
        $url = "http://maps.google.es/maps/api/geocode/json?sensor=false&address={$address}";
        $resp_json = file_get_contents($url);
        $resp = json_decode($resp_json, true);
        if ($resp['status'] == 'OK') {
            $location = [];
            $location['lat'] = $resp['results'][0]['geometry']['location']['lat'];
            $location['lng'] = $resp['results'][0]['geometry']['location']['lng'];
            $location['formatted_address'] = $resp['results'][0]['formatted_address'];
            foreach ($resp['results'][0]['address_components'] as $component) {
                switch ($component['types']) {
                    case in_array('street_number', $component['types']):
                        $location['street_number'] = $component['long_name'];
                        break;
                    case in_array('route', $component['types']):
                        $location['route'] = $component['long_name'];
                        break;
                    case in_array('locality', $component['types']):
                        $location['locality'] = $component['long_name'];
                        break;
                    case in_array('administrative_area_level_2', $component['types']):
                        $location['administrative_area_level_2'] = $component['long_name'];
                        break;
                    case in_array('administrative_area_level_1', $component['types']):
                        $location['administrative_area_level_1'] = $component['long_name'];
                        break;
                    case in_array('country', $component['types']):
                        $location['country'] = $component['long_name'];
                        break;
                    case in_array('postal_code', $component['types']):
                        $location['postal_code'] = $component['long_name'];
                        break;
                }
            }
            if(count(array_filter($location)))
                return $location;
            return false;
        } else {
            return false;
        }
    }

    public static function generateRandomLocation()
    {
        $location = [];
        $address = '';
        $catStreets = ['Major','Catalunya','Doctor','Pau Casals','Jacint Verdaguer'];
        $catTowns = ['Barcelona','Hospitalet de Llobregat','Badalona','Tarrasa','Sabadell','Lérida','Tarragona','Mataró','Santa Coloma de Gramanet','Reus','Gerona','Cornellá de Llobregat','San Cugat del Vallés','San Baudilio de Llobregat','Manresa','Rubí','Villanueva y Geltrú','Viladecans','El Prat de Llobregat','Castelldefels','Granollers','Sardañola del Vallés','Mollet del Vallés','Esplugas de Llobregat','Gavá','Figueras','San Felíu de Llobregat','Vich','Lloret de Mar','Blanes','Igualada','Villafranca del Panadés','Ripollet','Vendrell','Tortosa','Moncada y Reixach','San Adrián de Besós','Olot','Cambrils','San Juan Despí','Barberá del Vallés','Salt','San Pedro de Ribas','Sitges','Premiá de Mar','San Vicente dels Horts','Martorell','San Andrés de la Barca','Salou','Pineda de Mar','Santa Perpetua de Moguda','Valls','Molins de Rey','Calafell','Olesa de Montserrat','Castellar del Vallés','Palafrugell','El Masnou','Vilaseca','San Felíu de Guixols','Esparraguera','Amposta','Manlleu'];
        while(!$location || count(array_filter($location))<8) {
            $address = $catStreets[array_rand($catStreets)].', '.mt_rand(1,50).', '.$catTowns[array_rand($catTowns)].', España';
            $location = Geocode::geocodeAddress($address);
        }
        $location['raw'] = $address;
        return $location;
    }
}