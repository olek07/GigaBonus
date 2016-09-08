#
# Table structure for table 'fe_users'
#

CREATE TABLE fe_users (
    language varchar(2) DEFAULT '' NOT NULL,
    city_id int(11) unsigned DEFAULT '0' NOT NULL
);


#
# Tabellenstruktur für Tabelle `tx_gbfemanager_cities`
#

CREATE TABLE tx_gbfemanager_cities (
  uid int(11) NOT NULL auto_increment,
  postcode_city_id int(11) unsigned DEFAULT '0' NOT NULL,
  name_ua varchar(150) DEFAULT '' NOT NULL,
  name_ru varchar(150) DEFAULT '' NOT NULL,

  PRIMARY KEY (uid),
  KEY name_ua (name_ua(15)),
  KEY name_ru (name_ru(15))
);


