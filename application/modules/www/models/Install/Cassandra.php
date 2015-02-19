<?php

/**
 * Cassandra
 *
 * @author Michal Trmac <michal.trmac@gmail.com>
 */
class Model_Install_Cassandra extends Gp_Stream_Install_Cassandra
{

	/** @var string $timeline_cf */
	protected $timeline_cf = 'timeline';

	/** @var string $aggregated_cf */
	protected $aggregated_cf = 'aggregated';

	/** @var string $notification_cf */
	protected $notification_cf = 'notification';

	/** @var string $notification_count_cf */
	protected $notification_count_cf = 'notification_count';

}