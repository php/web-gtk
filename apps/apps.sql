DROP TABLE IF EXISTS app;
CREATE TABLE app (
	id				INT UNSIGNED NOT NULL AUTO_INCREMENT,
	modify_id		INT UNSIGNED,
	status			CHAR(1) DEFAULT 'P' NOT NULL,
	cat_id			INT UNSIGNED NOT NULL,
	date_added		DATETIME NOT NULL,
	rating			FLOAT DEFAULT 0.0 NOT NULL,
	votes			INT UNSIGNED DEFAULT 0 NOT NULL,
	name			VARCHAR(255) NOT NULL,
	has_screenshot	CHAR(1) DEFAULT 'N' NOT NULL,
	homepage_url	VARCHAR(255),
	submitter		VARCHAR(100),
	approved_by		VARCHAR(20),
	blurb			TEXT,
	#
	PRIMARY KEY app_pk (id),
	INDEX app_status_idx (status),
	INDEX app_cat_id_idx (cat_id),
	INDEX app_date_added_idx (date_added)
);
