<?php

/**
 * Model_Pin_Feed_Notification
 *
 * @author Michal Trmac <michal.trmac@gmail.com>
 */
class Model_Pin_Feed_Notification extends Gp_Stream_Feed_Cassandra_Notification
{

	/** @var string - the name of the column family */
	protected $timeline_cf_name = 'notification';

	/** @var string - the name of the column family for notification count */
	protected $column_family_count = 'notification_count';

}