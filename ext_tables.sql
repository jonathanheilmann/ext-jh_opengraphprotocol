#
# Table structure for table 'pages'
#
CREATE TABLE pages (
	tx_jhopengraphprotocol_ogtitle tinytext,
	tx_jhopengraphprotocol_ogtype tinytext,
	tx_jhopengraphprotocol_ogimage text,
	tx_jhopengraphprotocol_ogfalimages int(11) unsigned DEFAULT '0',
	tx_jhopengraphprotocol_ogdescription tinytext
);

#
# Table structure for table 'pages_language_overlay'
#
CREATE TABLE pages_language_overlay (
	tx_jhopengraphprotocol_ogtitle tinytext,
	tx_jhopengraphprotocol_ogtype tinytext,
	tx_jhopengraphprotocol_ogimage text,
	tx_jhopengraphprotocol_ogfalimages int(11) unsigned DEFAULT '0',
	tx_jhopengraphprotocol_ogdescription tinytext
);