<?php

/**
 * Model_Pin_Feed_Aggregated
 *
 * @author Michal Trmac <michal.trmac@gmail.com>
 */
class Model_Pin_Feed_Aggregated extends Gp_Stream_Feed_Cassandra_Aggregated
{

	/** @var string  - the format of the key used when storing the data */
	protected $key_format = 'feed:aggregated:%s';

	/** @var string - the name of the column family */
	protected $timeline_cf_name = 'aggregated';
}