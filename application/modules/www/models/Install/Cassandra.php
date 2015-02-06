<?php

/**
 * Cassandra
 *
 * @author Michal Trmac <michal.trmac@gmail.com>
 */
class Model_Install_Cassandra extends Gp_Stream_Install_Cassandra
{

	/** @var string $timeline_cf */
	protected $timeline_cf = 'example';

	/** @var string $aggregated_cf */
	protected $aggregated_cf = 'aggregated';

}