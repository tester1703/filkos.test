
### create table

```
CREATE TABLE `short_links` (
	`id` BIGINT NOT NULL AUTO_INCREMENT, 
	`link` VARCHAR(767) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL, 
	`code` VARCHAR(6) NOT NULL,
	PRIMARY KEY (`id`), 
	UNIQUE `uniq_short_links_link` (`link`(191)), 
	UNIQUE `uniq_short_links_code` (`code`)
) ENGINE = InnoDB CHARSET=utf8mb4 COLLATE utf8mb4_general_ci;
CREATE INDEX idx_short_links_link ON short_links(link);
CREATE INDEX idx_short_links_code ON short_links(code);
```

### change access to DB in
`./settings/db.php`

### run server
 - got to `./public` dir
 - run `php -S localhost:8088`

### open browser
 - go to http://localhost:8088
 - enjoy
