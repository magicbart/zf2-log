# zf2-log
Module Log for a zf2 project




CREATE TABLE `log` (
	`id`	INTEGER PRIMARY KEY AUTOINCREMENT,
	`timestamp`	TEXT,
	`priority`	INTEGER,
	`priorityName`	TEXT,
	`message`	TEXT
);



CREATE TABLE `token` (
	`key`	TEXT
);