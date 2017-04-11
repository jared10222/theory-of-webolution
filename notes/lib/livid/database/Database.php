<?php
namespace livid\database;

abstract class Database {
	abstract public function query($sql);	
}