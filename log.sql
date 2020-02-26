CREATE TABLE `log` (
	`starttime` TEXT NOT NULL,
	`pageid` INT(11) NOT NULL,
	`eventname` TEXT NOT NULL,
	`target` TEXT NOT NULL,
	`targetid` INT(11) NOT NULL,
	`uid` INT(11) NOT NULL
)
COLLATE='utf8mb4_0900_ai_ci'
ENGINE=InnoDB
;
