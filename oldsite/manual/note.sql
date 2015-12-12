#
# Table structure for table 'notes'
#

CREATE TABLE notes(
  id INTEGER PRIMARY KEY,
  page CHAR(100),
  lang CHAR(5),
  date INT(11),
  email CHAR(700),
  display CHAR(700),
  comment CHAR(4000)
);

