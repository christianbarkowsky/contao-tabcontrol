-- **********************************************************
-- *                                                        *
-- * IMPORTANT NOTE                                         *
-- *                                                        *
-- * Do not import this file manually but use the TYPOlight *
-- * install tool to create and maintain database tables!   *
-- *                                                        *
-- **********************************************************


-- --------------------------------------------------------

--
-- Table `tl_content`
--

CREATE TABLE `tl_content` (
  `tabType` varchar(32) NOT NULL default '',
  `tabTitles` blob NULL,
  `tabClasses` varchar(255) NOT NULL default '',
  `tabBehaviour` varchar(64) NOT NULL default '',
  `tab_autoplay_autoSlide` char(1) NOT NULL default '0',
  `tab_autoplay_delay` int(10) NOT NULL default '2500',
) ENGINE=MyISAM DEFAULT CHARSET=utf8;