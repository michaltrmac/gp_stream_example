<?php

/**
 * Model_Verb_Storage_Memorys
 *
 * @author Michal Trmac <michal.trmac@gmail.com>
 */
class Model_Verb_Storage_Memory extends Gp_Stream_Verb_Storage_Memory
{

	/** @var array */
	protected $custom_verbs = array(
		5 => 'Model_Verb_Pin',
	);

}