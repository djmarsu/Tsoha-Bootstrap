<?php
class Kategoria extends BaseModel {
  public $nimi, $kuvaus;

  public function __construct($attributes) {
    parent::__construct($attributes);
    $this->validators = array('validate_nimi');
  }

  public function validate_nimi() {
    $errors = array();
    if ($this->nimi == '' || $this->nimi == null) {
        $errors[] = "kategorian nimi ei saa olla tyhjä";
    }
    return $errors;
  }


  public static function all() {
/*    $query = DB::connection()->prepare('SELECT * FROM PostauksenKategoria ORDER kategoriannimi ASC');
    $query->execute();
    $rows = $query->fetchAll();
    $kategoriat = array();
    foreach ($rows as $row) {
      Kint::dump("moro");
      $query2 = DB::connection()->prepare('SELECT * FROM Kategoria WHERE nimi = :nimi LIMIT 1');
      $query2->execute(array('nimi' => $row['nimi']));
      $row2 = $query2->fetch();
      //if ($row2) {
        $kategoriat[] = new Kategoria(array(
          'nimi' => $row2['nimi'],
          'kuvaus' => $row2['kuvaus']
        ));
      //}
    }
*/
/*
    $kategoriat = array();
    $query2 = DB::connection()->prepare('SELECT * FROM Kategoria');
    $rows = $query2->fetchAll();
    Kint::dump($rows);
    foreach ($rows as $row) { 
      $kategoriat[] = new Kategoria(array(
          'nimi' => $row['nimi']
        ));
    }



    return $kategoriat;
*/
//    $query = DB::connection()->prepare('SELECT * FROM Kategoria');
//    $query = DB::connection()->prepare('SELECT DISTINCT kategoriannimi FROM PostauksenKategoria');

    // mitenköhän tän tekis järkevämmin
    if (!BaseController::get_user_logged_in()) {
      $query = DB::connection()->prepare("SELECT DISTINCT PostauksenKategoria.kategoriannimi FROM PostauksenKategoria, Postaus WHERE PostauksenKategoria.postausID = Postaus.id AND Postaus.julkaistu = 'y' ORDER BY PostauksenKategoria.kategoriannimi ASC");
     } else {
    $query = DB::connection()->prepare("SELECT DISTINCT PostauksenKategoria.kategoriannimi FROM PostauksenKategoria, Postaus WHERE PostauksenKategoria.postausID = Postaus.id ORDER BY PostauksenKategoria.kategoriannimi ASC");
    }
    // Suoritetaan kysely
    $query->execute();
    // Haetaan kyselyn tuottamat rivit
    $rows = $query->fetchAll();
    $kategoriat = array();

    // Käydään kyselyn tuottamat rivit läpi
    foreach($rows as $row){
      // Tämä on PHP:n hassu syntaksi alkion lisäämiseksi taulukkoon :)
      $kategoriat[] = new Kategoria(array(
        'nimi' => $row['kategoriannimi']
      ));
    }

    return $kategoriat;
  }

  public static function find($nimi) {
    $query = DB::connection()->prepare('SELECT * FROM Kategoria WHERE nimi = :nimi LIMIT 1');
    $query->execute(array('nimi' => $nimi));
    $row = $query->fetch();

    if ($row) {
      $kategoria = new Kategoria(array(
        'nimi' => $row['nimi'],
        'kuvaus' => $row['kuvaus']
      ));
      return $kategoria;
    }

    return null;
  }

  public static function poista_postaus($id) {
    $query = DB::connection()->prepare('DELETE FROM PostauksenKategoria WHERE postausID = :id');
    $query->execute(array('id' => $id));
  }

  public static function destroy($juu) {
    $query = DB::connection()->prepare('DELETE FROM PostauksenKategoria WHERE kategoriannimi = :nimi');
    $query->execute(array('nimi' => $juu));
    $query2 = DB::connection()->prepare('DELETE FROM Kategoria WHERE nimi = :nimi');
    $query2->execute(array('nimi' => $juu));
  }

  public static function postauksen_kategoriat($postausid) {
    $kategoriat = array();
    $query = DB::connection()->prepare('SELECT * FROM PostauksenKategoria WHERE postausID = :postausid');
    $query->execute(array('postausid' => $postausid));
    $rows = $query->fetchAll();

    foreach($rows as $row){
      $kategoriat[] = Kategoria::find($row['kategoriannimi']);
    }

    return $kategoriat;
  }

  public function luo() {
    $query = DB::connection()->prepare("INSERT INTO Kategoria (nimi) VALUES (:nimi) RETURNING nimi");
    $query->execute(array('nimi' => $this->nimi));
    $row = $query->fetch();
    /* tässä piti jotakin tehä */
  }

  public function liita_postaukseen($postausid) {
    $query = DB::connection()->prepare("INSERT INTO PostauksenKategoria (postausID, kategoriannimi) VALUES (:postausid, :kategoriannimi)");
    $query->execute(array('postausid' => $postausid, 'kategoriannimi' => $this->nimi));
  }



  public function update($nimi) {
    $query = DB::connection()->prepare('UPDATE Kategoria SET kuvaus = :kuvaus WHERE nimi = :nimi');
    $query->execute(array('nimi' => $this->nimi, 'kuvaus' => $this->kuvaus));
  }
}

