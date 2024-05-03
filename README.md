# Chatbox PHP 4
A chatbox in PHP 4.
## Requirements
This website runs on the french ISP's server ("Free"). Since this service comes with the ISP for free, and it has been used for small websites since 2008, the requirements are quite outdated.
- PHP `4.4.3-dev`
- MySQL `5.0.83`
- Apache MySQL client `5.1.61`

## Get Started
1. Clone this repo to your website.
2. Create the SQL table:
```sql
CREATE TABLE IF NOT EXISTS ChatMessages (
	idMessage INT(11) NOT NULL,
	contentMessage VARCHAR(15000) NOT NULL,
	dateMessage DATE NOT NULL,
	timeMessage TIME NOT NULL,
	usernameMessage VARCHAR(1500) NULL,
	PRIMARY KEY  (idMessage)
);
```
3. Insert a first message manually (the chat won't work with zero messages):
```sql
INSERT INTO ChatMessages (
	idMessage, contentMessage, dateMessage, timeMessage, usernameMessage
) VALUES (
	0,				--idMessage
	'Hello, World', --Content of Message (in ASCII, or HTML entities!)
	CURRENT_DATE(),
	CURRENT_TIME(),
	'Admin'			--Username
);
```
4. Go in `/config.php` and put the correct informations.
5. You're all done.

## Known bugs
- Some UTF-8 characters are not recognized.
- Requires a first message.