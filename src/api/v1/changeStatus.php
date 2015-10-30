<?php

/**
* Changes the status of the task and logs this in the comments. Only the card sharers can change the status.
*
* The file takes a JSON of the following format:
*	{
*		'user_id':xxxx,
*		'auth_key':xxxxxxx,
*		'card_id':<card_id>,
*		'card_status':<card_status>
*	}
*
*/