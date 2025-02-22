<?php

use Illuminate\Database\Seeder;
use League\Csv\Reader;

class EntidadesContratos2017Seeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      $table      = "entidades_contratos2017s";
      $file_path  = base_path() . "/data/entidades-contratos.csv";
      // recomendación de la librería de CSV para mac OSX
      if (! ini_get("auto_detect_line_endings")){
        ini_set("auto_detect_line_endings", '1');
      }
      // elimina todo lo que hay en la tabla
      DB::table($table)->delete();

      // genera y configura el lector de CSV
      $reader = Reader::createFromPath($file_path);

      // guarda los datos del CSV en la tabla
      $data = $reader->fetchAssoc();
      foreach($data as $row){
        DB::table($table)->insert($row);
      }

      $this->command->info('opa table seeded!');
        //
    }
}
