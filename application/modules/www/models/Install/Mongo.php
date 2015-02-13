<?php

/**
 * Mongo
 *
 * @author Michal Trmac <michal.trmac@gmail.com>
 */
class Model_Install_Mongo extends Gp_Mongo_Abstract
{

	/** @var array $con_params */
	private $con_params = array();

	final protected function getConnParams()
	{
		if (empty($this->con_params))
			$this->con_params = config('mongoAdapter', 'default');

		return $this->con_params;
	}

	final public function install()
	{
		$db = $this->db();
		dump('Connection to Mongo@'.$this->con_params['address']);
		dump('Droping old DB "'.$this->con_params['dbname'].'"');
		$db->drop();

		dump('Creating new collections ...');

		$this->createItemsCollection();
		$this->createFollowersCollection();

		$this->createIndexes();

		dump('Mongo DONE!!!');
	}

	final private function createItemsCollection()
	{
		dump('Create collection Items && Import Data ...');

		$file = realpath(APPLICATION_PATH.'/../items.csv');
		$lines = file($file);

		foreach ($lines as $line)
		{
			$_line = explode(';', $line);
			if (!is_numeric($_line[0]))
				continue;

			$this->collection('Items')->save(array(
				'_id' => (int)$_line[0],
				'url' => $_line[1],
				Gp_Attr::TARGET_URL => $_line[2],
				Gp_Attr::DESCRIPTION => trim($_line[3]),
			));
		}
	}

	final private function createFollowersCollection()
	{
		dump('Create collection Followers ...');
	}

	final public function createIndexes()
	{
		dump('Create indexes....');

		$this->collection('Followers')->ensureIndex(array(Gp_Attr::USER => 1, 'fid' => 1), array('unique' => true));
	}

}