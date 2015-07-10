SET FOREIGN_KEY_CHECKS=0;
SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


--
-- Daten für Tabelle `country`
--

INSERT INTO `country` (`id`, `code`, `en`, `de`) VALUES
(1, 'AD', 'Andorra', 'Andorra'),
(2, 'AE', 'United Arab Emirates', 'Vereinigte Arabische Emirate'),
(3, 'AF', 'Afghanistan', 'Afghanistan'),
(4, 'AG', 'Antigua and Barbuda', 'Antigua und Barbuda'),
(5, 'AI', 'Anguilla', 'Anguilla'),
(6, 'AL', 'Albania', 'Albanien'),
(7, 'AM', 'Armenia', 'Armenien'),
(8, 'AN', 'Netherlands Antilles', 'Niederländische Antillen'),
(9, 'AO', 'Angola', 'Angola'),
(10, 'AQ', 'Antarctica', 'Antarktis'),
(11, 'AR', 'Argentina', 'Argentinien'),
(12, 'AS', 'American Samoa', 'Amerikanisch-Samoa'),
(13, 'AT', 'Austria', 'Österreich'),
(14, 'AU', 'Australia', 'Australien'),
(15, 'AW', 'Aruba', 'Aruba'),
(16, 'AX', 'Aland Islands', 'Åland'),
(17, 'AZ', 'Azerbaijan', 'Aserbaidschan'),
(18, 'BA', 'Bosnia and Herzegovina', 'Bosnien und Herzegowina'),
(19, 'BB', 'Barbados', 'Barbados'),
(20, 'BD', 'Bangladesh', 'Bangladesch'),
(21, 'BE', 'Belgium', 'Belgien'),
(22, 'BF', 'Burkina Faso', 'Burkina Faso'),
(23, 'BG', 'Bulgaria', 'Bulgarien'),
(24, 'BH', 'Bahrain', 'Bahrain'),
(25, 'BI', 'Burundi', 'Burundi'),
(26, 'BJ', 'Benin', 'Benin'),
(27, 'BM', 'Bermuda', 'Bermuda'),
(28, 'BN', 'Brunei', 'Brunei Darussalam'),
(29, 'BO', 'Bolivia', 'Bolivien'),
(30, 'BR', 'Brazil', 'Brasilien'),
(31, 'BS', 'Bahamas', 'Bahamas'),
(32, 'BT', 'Bhutan', 'Bhutan'),
(33, 'BV', 'Bouvet Island', 'Bouvetinsel'),
(34, 'BW', 'Botswana', 'Botswana'),
(35, 'BY', 'Belarus', 'Belarus (Weißrussland)'),
(36, 'BZ', 'Belize', 'Belize'),
(37, 'CA', 'Canada', 'Kanada'),
(38, 'CC', 'Cocos (Keeling) Islands', 'Kokosinseln (Keelinginseln)'),
(39, 'CD', 'Congo (Kinshasa)', 'Kongo'),
(40, 'CF', 'Central African Republic', 'Zentralafrikanische Republik'),
(41, 'CG', 'Congo (Brazzaville)', 'Republik Kongo'),
(42, 'CH', 'Switzerland', 'Schweiz'),
(43, 'CI', 'Ivory Coast', 'Elfenbeinküste'),
(44, 'CK', 'Cook Islands', 'Cookinseln'),
(45, 'CL', 'Chile', 'Chile'),
(46, 'CM', 'Cameroon', 'Kamerun'),
(47, 'CN', 'China', 'China, Volksrepublik'),
(48, 'CO', 'Colombia', 'Kolumbien'),
(49, 'CR', 'Costa Rica', 'Costa Rica'),
(50, 'CS', 'Serbia And Montenegro', 'Serbien und Montenegro'),
(51, 'CU', 'Cuba', 'Kuba'),
(52, 'CV', 'Cape Verde', 'Kap Verde'),
(53, 'CX', 'Christmas Island', 'Weihnachtsinsel'),
(54, 'CY', 'Cyprus', 'Zypern'),
(55, 'CZ', 'Czech Republic', 'Tschechische Republik'),
(56, 'DE', 'Germany', 'Deutschland'),
(57, 'DJ', 'Djibouti', 'Dschibuti'),
(58, 'DK', 'Denmark', 'Dänemark'),
(59, 'DM', 'Dominica', 'Dominica'),
(60, 'DO', 'Dominican Republic', 'Dominikanische Republik'),
(61, 'DZ', 'Algeria', 'Algerien'),
(62, 'EC', 'Ecuador', 'Ecuador'),
(63, 'EE', 'Estonia', 'Estland (Reval)'),
(64, 'EG', 'Egypt', 'Ägypten'),
(65, 'EH', 'Western Sahara', 'Westsahara'),
(66, 'ER', 'Eritrea', 'Eritrea'),
(67, 'ES', 'Spain', 'Spanien'),
(68, 'ET', 'Ethiopia', 'Äthiopien'),
(69, 'FI', 'Finland', 'Finnland'),
(70, 'FJ', 'Fiji', 'Fidschi'),
(71, 'FK', 'Falkland Islands', 'Falklandinseln (Malwinen)'),
(72, 'FM', 'Micronesia', 'Mikronesien'),
(73, 'FO', 'Faroe Islands', 'Färöer'),
(74, 'FR', 'France', 'Frankreich'),
(75, 'GA', 'Gabon', 'Gabun'),
(76, 'GB', 'United Kingdom', 'Großbritannien und Nordirland'),
(77, 'GD', 'Grenada', 'Grenada'),
(78, 'GE', 'Georgia', 'Georgien'),
(79, 'GF', 'French Guiana', 'Französisch-Guayana'),
(80, 'GG', 'Guernsey', 'Guernsey (Kanalinsel)'),
(81, 'GH', 'Ghana', 'Ghana'),
(82, 'GI', 'Gibraltar', 'Gibraltar'),
(83, 'GL', 'Greenland', 'Grönland'),
(84, 'GM', 'Gambia', 'Gambia'),
(85, 'GN', 'Guinea', 'Guinea'),
(86, 'GP', 'Guadeloupe', 'Guadeloupe'),
(87, 'GQ', 'Equatorial Guinea', 'Äquatorialguinea'),
(88, 'GR', 'Greece', 'Griechenland'),
(89, 'GS', 'South Georgia and the South Sandwich Islands', 'Südgeorgien und die Südl. Sandwichinseln'),
(90, 'GT', 'Guatemala', 'Guatemala'),
(91, 'GU', 'Guam', 'Guam'),
(92, 'GW', 'Guinea-Bissau', 'Guinea-Bissau'),
(93, 'GY', 'Guyana', 'Guyana'),
(94, 'HK', 'Hong Kong S.A.R., China', 'Hongkong'),
(95, 'HM', 'Heard Island and McDonald Islands', 'Heard- und McDonald-Inseln'),
(96, 'HN', 'Honduras', 'Honduras'),
(97, 'HR', 'Croatia', 'Kroatien'),
(98, 'HT', 'Haiti', 'Haiti'),
(99, 'HU', 'Hungary', 'Ungarn'),
(100, 'ID', 'Indonesia', 'Indonesien'),
(101, 'IE', 'Ireland', 'Irland'),
(102, 'IL', 'Israel', 'Israel'),
(103, 'IM', 'Isle of Man', 'Insel Man'),
(104, 'IN', 'India', 'Indien'),
(105, 'IO', 'British Indian Ocean Territory', 'Britisches Territorium im Indischen Ozean'),
(106, 'IQ', 'Iraq', 'Irak'),
(107, 'IR', 'Iran', 'Iran'),
(108, 'IS', 'Iceland', 'Island'),
(109, 'IT', 'Italy', 'Italien'),
(110, 'JE', 'Jersey', 'Jersey (Kanalinsel)'),
(111, 'JM', 'Jamaica', 'Jamaika'),
(112, 'JO', 'Jordan', 'Jordanien'),
(113, 'JP', 'Japan', 'Japan'),
(114, 'KE', 'Kenya', 'Kenia'),
(115, 'KG', 'Kyrgyzstan', 'Kirgisistan'),
(116, 'KH', 'Cambodia', 'Kambodscha'),
(117, 'KI', 'Kiribati', 'Kiribati'),
(118, 'KM', 'Comoros', 'Komoren'),
(119, 'KN', 'Saint Kitts and Nevis', 'St. Kitts und Nevis'),
(120, 'KP', 'North Korea', 'Nordkorea'),
(121, 'KR', 'South Korea', 'Südkorea'),
(122, 'KW', 'Kuwait', 'Kuwait'),
(123, 'KY', 'Cayman Islands', 'Kaimaninseln'),
(124, 'KZ', 'Kazakhstan', 'Kasachstan'),
(125, 'LA', 'Laos', 'Laos'),
(126, 'LB', 'Lebanon', 'Libanon'),
(127, 'LC', 'Saint Lucia', 'St. Lucia'),
(128, 'LI', 'Liechtenstein', 'Liechtenstein'),
(129, 'LK', 'Sri Lanka', 'Sri Lanka'),
(130, 'LR', 'Liberia', 'Liberia'),
(131, 'LS', 'Lesotho', 'Lesotho'),
(132, 'LT', 'Lithuania', 'Litauen'),
(133, 'LU', 'Luxembourg', 'Luxemburg'),
(134, 'LV', 'Latvia', 'Lettland'),
(135, 'LY', 'Libya', 'Libyen'),
(136, 'MA', 'Morocco', 'Marokko'),
(137, 'MC', 'Monaco', 'Monaco'),
(138, 'MD', 'Moldova', 'Moldawien'),
(139, 'MG', 'Madagascar', 'Madagaskar'),
(140, 'MH', 'Marshall Islands', 'Marshallinseln'),
(141, 'MK', 'Macedonia', 'Mazedonien'),
(142, 'ML', 'Mali', 'Mali'),
(143, 'MM', 'Myanmar', 'Myanmar (Burma)'),
(144, 'MN', 'Mongolia', 'Mongolei'),
(145, 'MO', 'Macao S.A.R., China', 'Macao'),
(146, 'MP', 'Northern Mariana Islands', 'Nördliche Marianen'),
(147, 'MQ', 'Martinique', 'Martinique'),
(148, 'MR', 'Mauritania', 'Mauretanien'),
(149, 'MS', 'Montserrat', 'Montserrat'),
(150, 'MT', 'Malta', 'Malta'),
(151, 'MU', 'Mauritius', 'Mauritius'),
(152, 'MV', 'Maldives', 'Malediven'),
(153, 'MW', 'Malawi', 'Malawi'),
(154, 'MX', 'Mexico', 'Mexiko'),
(155, 'MY', 'Malaysia', 'Malaysia'),
(156, 'MZ', 'Mozambique', 'Mosambik'),
(157, 'NA', 'Namibia', 'Namibia'),
(158, 'NC', 'New Caledonia', 'Neukaledonien'),
(159, 'NE', 'Niger', 'Niger'),
(160, 'NF', 'Norfolk Island', 'Norfolkinsel'),
(161, 'NG', 'Nigeria', 'Nigeria'),
(162, 'NI', 'Nicaragua', 'Nicaragua'),
(163, 'NL', 'Netherlands', 'Niederlande'),
(164, 'NO', 'Norway', 'Norwegen'),
(165, 'NP', 'Nepal', 'Nepal'),
(166, 'NR', 'Nauru', 'Nauru'),
(167, 'NU', 'Niue', 'Niue'),
(168, 'NZ', 'New Zealand', 'Neuseeland'),
(169, 'OM', 'Oman', 'Oman'),
(170, 'PA', 'Panama', 'Panama'),
(171, 'PE', 'Peru', 'Peru'),
(172, 'PF', 'French Polynesia', 'Französisch-Polynesien'),
(173, 'PG', 'Papua New Guinea', 'Papua-Neuguinea'),
(174, 'PH', 'Philippines', 'Philippinen'),
(175, 'PK', 'Pakistan', 'Pakistan'),
(176, 'PL', 'Poland', 'Polen'),
(177, 'PM', 'Saint Pierre and Miquelon', 'St. Pierre und Miquelon'),
(178, 'PN', 'Pitcairn', 'Pitcairninseln'),
(179, 'PR', 'Puerto Rico', 'Puerto Rico'),
(180, 'PS', 'Palestinian Territory', 'Palästinensische Autonomiegebiete'),
(181, 'PT', 'Portugal', 'Portugal'),
(182, 'PW', 'Palau', 'Palau'),
(183, 'PY', 'Paraguay', 'Paraguay'),
(184, 'QA', 'Qatar', 'Katar'),
(185, 'RE', 'Reunion', 'Réunion'),
(186, 'RO', 'Romania', 'Rumänien'),
(187, 'RU', 'Russia', 'Russische Föderation'),
(188, 'RW', 'Rwanda', 'Ruanda'),
(189, 'SA', 'Saudi Arabia', 'Saudi-Arabien'),
(190, 'SB', 'Solomon Islands', 'Salomonen'),
(191, 'SC', 'Seychelles', 'Seychellen'),
(192, 'SD', 'Sudan', 'Sudan'),
(193, 'SE', 'Sweden', 'Schweden'),
(194, 'SG', 'Singapore', 'Singapur'),
(195, 'SH', 'Saint Helena', 'St. Helena'),
(196, 'SI', 'Slovenia', 'Slowenien'),
(197, 'SJ', 'Svalbard and Jan Mayen', 'Svalbard und Jan Mayen'),
(198, 'SK', 'Slovakia', 'Slowakei'),
(199, 'SL', 'Sierra Leone', 'Sierra Leone'),
(200, 'SM', 'San Marino', 'San Marino'),
(201, 'SN', 'Senegal', 'Senegal'),
(202, 'SO', 'Somalia', 'Somalia'),
(203, 'SR', 'Suriname', 'Suriname'),
(204, 'ST', 'Sao Tome and Principe', 'São Tomé und Príncipe'),
(205, 'SV', 'El Salvador', 'El Salvador'),
(206, 'SY', 'Syria', 'Syrien'),
(207, 'SZ', 'Swaziland', 'Swasiland'),
(208, 'TC', 'Turks and Caicos Islands', 'Turks- und Caicosinseln'),
(209, 'TD', 'Chad', 'Tschad'),
(210, 'TF', 'French Southern Territories', 'Französische Süd- und Antarktisgebiete'),
(211, 'TG', 'Togo', 'Togo'),
(212, 'TH', 'Thailand', 'Thailand'),
(213, 'TJ', 'Tajikistan', 'Tadschikistan'),
(214, 'TK', 'Tokelau', 'Tokelau'),
(215, 'TL', 'East Timor', 'Timor-Leste'),
(216, 'TM', 'Turkmenistan', 'Turkmenistan'),
(217, 'TN', 'Tunisia', 'Tunesien'),
(218, 'TO', 'Tonga', 'Tonga'),
(219, 'TR', 'Turkey', 'Türkei'),
(220, 'TT', 'Trinidad and Tobago', 'Trinidad und Tobago'),
(221, 'TV', 'Tuvalu', 'Tuvalu'),
(222, 'TW', 'Taiwan', 'Taiwan'),
(223, 'TZ', 'Tanzania', 'Tansania'),
(224, 'UA', 'Ukraine', 'Ukraine'),
(225, 'UG', 'Uganda', 'Uganda'),
(226, 'UM', 'United States Minor Outlying Islands', 'Amerikanisch-Ozeanien'),
(227, 'US', 'United States', 'Vereinigte Staaten von Amerika'),
(228, 'UY', 'Uruguay', 'Uruguay'),
(229, 'UZ', 'Uzbekistan', 'Usbekistan'),
(230, 'VA', 'Vatican', 'Vatikanstadt'),
(231, 'VC', 'Saint Vincent and the Grenadines', 'St. Vincent und die Grenadinen'),
(232, 'VE', 'Venezuela', 'Venezuela'),
(233, 'VG', 'British Virgin Islands', 'Britische Jungferninseln'),
(234, 'VI', 'U.S. Virgin Islands', 'Amerikanische Jungferninseln'),
(235, 'VN', 'Vietnam', 'Vietnam'),
(236, 'VU', 'Vanuatu', 'Vanuatu'),
(237, 'WF', 'Wallis and Futuna', 'Wallis und Futuna'),
(238, 'WS', 'Samoa', 'Samoa'),
(239, 'YE', 'Yemen', 'Jemen'),
(240, 'YT', 'Mayotte', 'Mayotte'),
(241, 'ZA', 'South Africa', 'Südafrika'),
(242, 'ZM', 'Zambia', 'Sambia'),
(243, 'ZW', 'Zimbabwe', 'Simbabwe');

--
-- Daten für Tabelle `role`
--

INSERT INTO `role` (`id`, `name`, `role`) VALUES
(6, 'admin', 'ROLE_ADMIN'),
(7, 'user', 'ROLE_USER'),
(8, 'customer', 'ROLE_CUSTOMER');

--
-- Daten für Tabelle `system_settings`
--

INSERT INTO `system_settings` (`id`, `key`, `value`) VALUES
(1, 'version', '0.2.4'),
(2, 'app_name', 'control'),
(3, 'lvdc', '0'),
(7, 'lico', 'https://lico.slash.works');


SET FOREIGN_KEY_CHECKS=1;
