<?php
class Postaus extends BaseModel {
  public $id, $blogi, $pvm, $otsikko, $leipateksti, $julkaistu;

/*		public function __construct($nimi, $kenen, $osoite) {
			$this->nimi = $nimi;
			$this->kenen = $kenen;
			$this->osoite = $osoite;
		}
*/
  public function __construct($attributes) {
    parent::__construct($attributes);
  }

  public static function all() {
    $query = DB::connection()->prepare('SELECT * FROM Postaus ORDER BY id DESC');
    $query->execute();
    $rows = $query->fetchAll();
    $postaukset = array();

    foreach ($rows as $row) {
      $postaukset[] = new Postaus(array(
        'id' => $row['id'],
        'blogi' => $row['blogi'],
        'pvm' => $row['pvm'],
        'otsikko' => $row['otsikko'],
        'leipateksti' => $row['leipateksti'],
        'julkaistu' => $row['julkaistu']
      ));
    }

    return $postaukset;
  }
}