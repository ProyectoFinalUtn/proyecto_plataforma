<?php
class Llamadasrest_model extends CI_Model {

    public function __construct()
    {
        parent::__construct();
        $this->load->database();                
    }

    public function obtener_clima_lon_lat($lat, $lon)
    {
        $appId= "83be915cd8ee0182ca474204a18ae9ed";
        $request = "http://api.openweathermap.org/data/2.5/weather?lat=".$lat."&lon=".$lon."&appid=".$appId."&units=metric&lang=es";
        $json = file_get_contents($request, false);
        
        //decode JSON to array
        $data = json_decode($json,true);

        
        return $data;
    }
    
    public function obtener_direccion_lon_lat($lat, $lon, $email){
        $request = "http://nominatim.openstreetmap.org/reverse?email=".$email."&format=json&lat=".$lat."&lon=".$lon."&zoom=18&addressdetails=1";
        $json = file_get_contents($request, false);
        
        //decode JSON to array
        $data = json_decode($json,true);

        
        return $data;
    }
    
    
    

}
