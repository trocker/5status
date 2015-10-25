Database Type : MySQL
Database Name : 5status
Database User : root
Database Password :
Database Host : 127.0.0.1 or localhost


Databse Tables :

	cards
	accounts
	comments
	card_sharers


Database Schema:

	Table - cards :

		id (unique), card_title, owner_id, creation_date, modified_date, card_status

		notes:
			card_status -> if it is TO-DO, QUEUED ON, WAITING ON, DOING BY, DONE BY.

	Table - accounts:

		id (unique), user_id, email_id, password_hash, creation_date, modified_data, account_status

			notes:
				account_status -> invited, joined, deleted


	Table - comments:

		id (unique), comment, card_id, creation_date

			notes:
				every comment on 5status will be linked to a card_id and will have its unique id.

	Table - card_sharers:

		id (unique), card_id, user_id, priority, creation_date, joined_comments

			notes:
				- every user sharing a card will have an entry in card_sharers
				- every person have their own priority