<?php

/**
* Invite person to a card. 
* 1. Put it in card_sharers with the default user_id already defined in the database of NULL 
* 2. Put the user in accounts with account_status is INVITED
* 3. Send an email using the Notification service
*
* The file takes a JSON of the following format:
*	{
*		'user_id':xxxx,
*		'auth_key':xxxxxxx,
*		'email_invited': <someone@example.com>,
*		'card_id':1
*	}
*
*/

