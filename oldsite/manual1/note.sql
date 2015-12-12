#
# Table structure for table 'note'
#

CREATE TABLE note (
  id mediumint(9) NOT NULL auto_increment,
  sect varchar(80),
  user varchar(80),
  note text,
  ts datetime,
  status varchar(16),
  lang varchar(16),
  votes mediumint(9) DEFAULT '0' NOT NULL,
  rating mediumint(9) DEFAULT '0' NOT NULL,
  PRIMARY KEY (id),
  KEY sect (sect)
);

