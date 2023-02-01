<?php

namespace App\Model;

class DiscussionManager
{
  /** @var \Nette\Database\Context */
  protected $database;

  public function __construct(\Nette\Database\Explorer $database)
  {
    $this->database = $database;
  }
  public function getDisscussionItems()
  {
    $database = $this->database;
    $database->beginTransaction();
    $rows = $database->query('SELECT id, prezdivka, email, data FROM prispevky')->fetchAll();
    $database->commit();
    //Debugger::barDump($rows);  je zajímavé zkusit odkomentovat
    return $rows; //Obvykle se vrací DTO - Data Transfer Object(y)
  }
}
