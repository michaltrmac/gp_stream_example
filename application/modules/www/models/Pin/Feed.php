<?php

/**
 * Model_Pin_Feed
 *
 * @author Michal Trmac <michal.trmac@gmail.com>
 */
class Model_Pin_Feed extends Gp_Stream_Feed_Cassandra
{

	/** @var string  - the format of the key used when storing the data */
	protected $key_format = 'feed:flat:%s';

	/** @var string - the name of the column family */
	protected $timeline_cf_name = 'example';

}