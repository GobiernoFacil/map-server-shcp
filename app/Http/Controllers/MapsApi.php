<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\ProyectosSuspendidosSfu;
use App\Consolidado2015;
use App\Models\entidades2017;

use DB;

class MapsApi extends Controller
{
  const PAGE_SIZE = 500;
  public function sfuState(Request $request, $row = "COMPROMETIDO_PER"){
    //$value = $request->input("value");

    $response = ProyectosSuspendidosSfu::select(DB::raw("KA_ENTIDAD_FEDERATIVA as state_id, sum({$row}) as {$row}"))
                ->groupBy("KA_ENTIDAD_FEDERATIVA")
                ->get();

    return response()->json($response)->header("Access-Control-Allow-Origin", "*");
  }

  public function consolidado2015single(Request $request, $magic_num){
    $response = Consolidado2015::find($magic_num);

    if(!$response){
      abort(404);
    }

    return response()
           ->json($response)
           ->header("Access-Control-Allow-Origin", "*");
  }

  public function consolidado2015(Request $request, $page = 1){
    $branch = $request->input("branch");
    $state  = $request->input("state");
    $year   = $request->input("year");
    $_page  = (int)$page >0 ? (int)$page - 1 : 0; 

    $response = Consolidado2015::where("LONGITUD","!=", "")->where("LATITUD", "!=", "");
    $total    = Consolidado2015::where("LONGITUD","!=", "")->where("LATITUD", "!=", "");

    if($branch){
      $response = $response->where("ID_RAMO", $branch);
      $total    = $total->where("ID_RAMO", $branch);
    }

    if($state){
      $response = $response->where("ID_ENTIDAD_FEDERATIVA", $state);
      $total    = $total->where("ID_ENTIDAD_FEDERATIVA", $state);
    }

    if($year){
      $response = $response->where("CICLO", $year);
      $total    = $total->where("CICLO", $year);
    }

    $response = $response->take(self::PAGE_SIZE)->skip($_page * self::PAGE_SIZE)->get();
    $total    = $total->count();
    $_response = [
      "total"    => $total,
      "results"  => $response,
      "page"     => $_page + 1,
      "pageSize" => self::PAGE_SIZE,
      "pages"    => ceil($total/self::PAGE_SIZE)
    ];

    return response()->json($_response)->header("Access-Control-Allow-Origin", "*");
  }

  public function entidades(Request $request, $page = 1){
    /*
    {"type" : "search", "field" : "NOMBRE_PROYECTO"},
    {"type" : "state", "field" : "ID_ENTIDAD_FEDERATIVA"},
    {"type" : "city", "field" : "ID_MUNICIPIO"},
    {"type" : "branch", "field" : "ID_RAMO"},
    {"type" : "year", "field" : "CICLO_RECURSO"}
    */
    $branch = $request->input("branch");
    $state  = $request->input("state");
    $year   = $request->input("year");
    $city   = $request->input("city");
    $_page  = (int)$page >0 ? (int)$page - 1 : 0; 

    $response = entidades2017::where("LONGITUD","!=", "")->where("LATITUD", "!=", "");

    $total    = entidades2017::where("LONGITUD","!=", "")->where("LATITUD", "!=", "");

    if($branch){
      $response = $response->where("ID_RAMO", $branch);
      $total    = $total->where("ID_RAMO", $branch);
    }

    if($state){
      $response = $response->where("ID_ENTIDAD_FEDERATIVA", $state);
      $total    = $total->where("ID_ENTIDAD_FEDERATIVA", $state);
    }

    if($year){
      $response = $response->where("CICLO_RECURSO", $year);
      $total    = $total->where("CICLO_RECURSO", $year);
    }

    if($city){
      $response = $response->where("ID_MUNICIPIO", $city);
      $total    = $total->where("ID_MUNICIPIO", $city);
    }

    $response = $response->take(self::PAGE_SIZE)->skip($_page * self::PAGE_SIZE)->get();
    $total    = $total->count();
    $_response = [
      "total"    => $total,
      "results"  => $response,
      "page"     => $_page + 1,
      "pageSize" => self::PAGE_SIZE,
      "pages"    => ceil($total/self::PAGE_SIZE)
    ];

    return response()->json($_response)->header("Access-Control-Allow-Origin", "*");
  }

  public function entidadesv2(Request $request){
    $name   = str_replace("'", "", $request->input("NOMBRE_PROYECTO") );
    $state  = str_replace("'", "", $request->input("ID_ENTIDAD_FEDERATIVA") );
    $city   = str_replace("'", "", $request->input("GFSHCPCityId") );
    $branch = str_replace("'", "", $request->input("ID_RAMO") );
    $year   = str_replace("'", "", $request->input("CICLO_RECURSO") );
    $page   = $request->input("page") >= 0 ? $request->input("page") : 0;
    $size   = $request->input("pageSize") ? $request->input("pageSize") : self::PAGE_SIZE;

    $response = entidades2017::where("LONGITUD","!=", "")->where("LATITUD", "!=", "");

    if($branch){
      $branch   = explode("|", $branch);
      $response = $response->whereIn("ID_RAMO", $branch);
    }

    if($state && $city){
      $states = explode("|", $state);
      $cities = explode("|", $city);
      $states2 = [];
      $states3 = [];

      foreach($cities as $city){
        $cityStr  = str_pad($city, 5, "0", STR_PAD_LEFT);
        //$city   = (int)substr($cityStr, -3);
        $state    = (int)substr($cityStr, 0, 2);
        $states2[] = $state;
      }

      foreach($states as $st){
        if(!in_array($st, $states2)){
          $states3[] = $st;
        }
      }



      $response = $response->where(function($query) use($cities, $states3){
        $first = array_shift($cities);


        $query->where(function($q) use($first){
          $cityStr = str_pad($first, 5, "0", STR_PAD_LEFT);
          $city    = (int)substr($cityStr, -3);
          $state   = (int)substr($cityStr, 0, 2);
          $q->where("ID_ENTIDAD_FEDERATIVA", "=", $state)
            ->where("ID_MUNICIPIO", "=", $city);
        });
        

        
        foreach($cities as $cityComp){
          $query->orWhere(function($q) use($cityComp){
            $cityStr = str_pad($cityComp, 5, "0", STR_PAD_LEFT);
            $city    = (int)substr($cityStr, -3);
            $state   = (int)substr($cityStr, 0, 2);
            $q->where("ID_ENTIDAD_FEDERATIVA", "=", $state);
            $q->where("ID_MUNICIPIO", "=", $city);
          });
        }

        if(!empty($states3)){
          $query->orWhereIn("ID_ENTIDAD_FEDERATIVA", $states3);
        }
        
      });

    }

    else if($state){
      $state   = explode("|", $state);
      $response = $response->whereIn("ID_ENTIDAD_FEDERATIVA", $state);
    }

    else if($city){
      $cityArray = explode("|", $city);

      $response = $response->where(function($query) use($cityArray){
        $first = array_shift($cityArray);


        $query->where(function($q) use($first){
          $cityStr = str_pad($first, 5, "0", STR_PAD_LEFT);
          $city    = (int)substr($cityStr, -3);
          $state   = (int)substr($cityStr, 0, 2);
          $q->where("ID_ENTIDAD_FEDERATIVA", "=", $state)
            ->where("ID_MUNICIPIO", "=", $city);
        });
        

        
        foreach($cityArray as $cityComp){
          $query->orWhere(function($q) use($cityComp){
            $cityStr = str_pad($cityComp, 5, "0", STR_PAD_LEFT);
            $city    = (int)substr($cityStr, -3);
            $state   = (int)substr($cityStr, 0, 2);
            $q->where("ID_ENTIDAD_FEDERATIVA", "=", $state);
            $q->where("ID_MUNICIPIO", "=", $city);
          });
        }
        
      });

      

    }

    if($year){
      $year   = explode("|", $year);
      $response = $response->whereIn("CICLO_RECURSO", $year);
    }

    if($name){
      $response = $response->where("NOMBRE_PROYECTO", "like", "%$name%");
    }

    $total = clone $response;
    $response = $response->take($size)->skip($page * $size)->get();

    $total    = $total->count();
    $_response = [
      "total"    => $total,
      "results"  => $response,
      "page"     => $page,
      "pageSize" => $size,
      "pages"    => ceil($total/$size),
      "request"  => $request->all()
    ];

    return response()->json($_response)->header("Access-Control-Allow-Origin", "*");
  }
}
