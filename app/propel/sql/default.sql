
# This is a fix for InnoDB in MySQL >= 4.1.x
# It "suspends judgement" for fkey relationships until are tables are set.
SET FOREIGN_KEY_CHECKS = 0;

-- ---------------------------------------------------------------------
-- api_log
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `api_log`;

CREATE TABLE `api_log`
(
    `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
    `dt_call` DATETIME NOT NULL,
    `remote_app_id` int(10) unsigned NOT NULL,
    `statuscode` INTEGER(3) NOT NULL,
    `last_response` LONGBLOB NOT NULL,
    PRIMARY KEY (`id`),
    INDEX `remote_app_id` (`remote_app_id`),
    CONSTRAINT `api_log_ibfk_1`
        FOREIGN KEY (`remote_app_id`)
        REFERENCES `remote_app` (`id`)
        ON UPDATE CASCADE
        ON DELETE CASCADE
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- country
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `country`;

CREATE TABLE `country`
(
    `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
    `code` CHAR(2) NOT NULL,
    `en` VARCHAR(50) DEFAULT '' NOT NULL,
    `de` VARCHAR(50) DEFAULT '' NOT NULL,
    PRIMARY KEY (`id`),
    INDEX `de` (`de`),
    INDEX `en` (`en`),
    INDEX `code` (`code`)
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- customer
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `customer`;

CREATE TABLE `customer`
(
    `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
    `name` VARCHAR(100) NOT NULL,
    `street` VARCHAR(50),
    `zip` VARCHAR(8),
    `city` VARCHAR(50),
    `country_id` int(10) unsigned NOT NULL,
    `phone` VARCHAR(20),
    `fax` VARCHAR(20),
    `email` VARCHAR(50) NOT NULL,
    `legalform` VARCHAR(20),
    `logo` VARCHAR(255),
    `created` DATETIME NOT NULL,
    `notes` TEXT,
    PRIMARY KEY (`id`),
    INDEX `country_id` (`country_id`),
    CONSTRAINT `customer_ibfk_1`
        FOREIGN KEY (`country_id`)
        REFERENCES `country` (`id`)
        ON UPDATE CASCADE
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- license
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `license`;

CREATE TABLE `license`
(
    `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
    `max_clients` INTEGER(3) NOT NULL,
    `domain` VARCHAR(255) NOT NULL,
    `valid_until` VARCHAR(255) NOT NULL,
    `serial` TEXT NOT NULL,
    PRIMARY KEY (`id`)
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- remote_app
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `remote_app`;

CREATE TABLE `remote_app`
(
    `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
    `type` enum('contao') DEFAULT 'contao' NOT NULL,
    `name` VARCHAR(255) NOT NULL,
    `domain` VARCHAR(255) NOT NULL,
    `api_url` VARCHAR(255) NOT NULL,
    `api_auth_http_user` VARCHAR(50),
    `api_auth_http_password` VARCHAR(255),
    `api_auth_type` enum('none','http-basic','url-user-password','url-token') DEFAULT 'none' NOT NULL,
    `api_auth_user` VARCHAR(255),
    `api_auth_password` VARCHAR(255),
    `api_auth_token` VARCHAR(255),
    `api_auth_url_user_key` VARCHAR(50),
    `api_auth_url_pw_key` VARCHAR(50),
    `cron` VARCHAR(20),
    `customer_id` int(10) unsigned,
    `activated` tinyint(1) unsigned DEFAULT 0 NOT NULL,
    `notes` TEXT,
    `last_run` DATETIME,
    `includeLog` TINYINT(1) DEFAULT 0 NOT NULL,
    `public_key` VARCHAR(512),
    `website_hash` VARCHAR(255) DEFAULT '',
    `notification_recipient` VARCHAR(255) DEFAULT '' NOT NULL,
    `notification_sender` VARCHAR(255) DEFAULT '' NOT NULL,
    `notification_change` tinyint(1) unsigned DEFAULT 1 NOT NULL,
    `notification_error` tinyint(1) unsigned DEFAULT 1 NOT NULL,
    PRIMARY KEY (`id`),
    INDEX `type` (`type`),
    INDEX `idx_customer` (`customer_id`),
    CONSTRAINT `remote_app_ibfk_1`
        FOREIGN KEY (`customer_id`)
        REFERENCES `customer` (`id`)
        ON UPDATE CASCADE
        ON DELETE SET NULL
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- remote_history_contao
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `remote_history_contao`;

CREATE TABLE `remote_history_contao`
(
    `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
    `remote_app_id` int(10) unsigned NOT NULL,
    `apiVersion` VARCHAR(10) NOT NULL,
    `name` VARCHAR(255) NOT NULL,
    `version` VARCHAR(10) NOT NULL,
    `config_displayErrors` VARCHAR(3) DEFAULT 'Off' NOT NULL,
    `config_bypassCache` VARCHAR(3) DEFAULT 'Off' NOT NULL,
    `config_minifyMarkup` VARCHAR(3) DEFAULT 'Off' NOT NULL,
    `config_debugMode` VARCHAR(3) DEFAULT 'Off' NOT NULL,
    `config_maintenanceMode` VARCHAR(3) DEFAULT 'Off' NOT NULL,
    `config_gzipScripts` VARCHAR(3) DEFAULT 'Off' NOT NULL,
    `config_rewriteURL` VARCHAR(3) DEFAULT 'Off' NOT NULL,
    `config_adminEmail` VARCHAR(255) NOT NULL,
    `config_cacheMode` VARCHAR(10) NOT NULL,
    `statuscode` INTEGER(3) NOT NULL,
    `extensions` TEXT NOT NULL,
    `log` TEXT,
    `php` TEXT,
    `mysql` TEXT,
    PRIMARY KEY (`id`),
    INDEX `remote_app_id` (`remote_app_id`),
    CONSTRAINT `remote_history_contao_ibfk_1`
        FOREIGN KEY (`remote_app_id`)
        REFERENCES `remote_app` (`id`)
        ON UPDATE CASCADE
        ON DELETE CASCADE
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- user_customer_relation
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `user_customer_relation`;

CREATE TABLE `user_customer_relation`
(
    `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
    `user_id` INTEGER NOT NULL,
    `customer_id` int(10) unsigned NOT NULL,
    PRIMARY KEY (`id`),
    UNIQUE INDEX `user_id` (`user_id`, `customer_id`),
    INDEX `user_id_2` (`user_id`),
    INDEX `customer_id` (`customer_id`),
    CONSTRAINT `user_customer_relation_ibfk_3`
        FOREIGN KEY (`user_id`)
        REFERENCES `user` (`id`)
        ON UPDATE CASCADE
        ON DELETE CASCADE,
    CONSTRAINT `user_customer_relation_ibfk_2`
        FOREIGN KEY (`customer_id`)
        REFERENCES `customer` (`id`)
        ON UPDATE CASCADE
        ON DELETE CASCADE
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- role
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `role`;

CREATE TABLE `role`
(
    `id` INTEGER NOT NULL AUTO_INCREMENT,
    `name` VARCHAR(30) NOT NULL,
    `role` VARCHAR(20) NOT NULL,
    PRIMARY KEY (`id`),
    UNIQUE INDEX `UNIQ_B63E2EC757698A6A` (`role`)
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- user_role
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `user_role`;

CREATE TABLE `user_role`
(
    `user_id` INTEGER NOT NULL,
    `role_id` INTEGER NOT NULL,
    PRIMARY KEY (`user_id`,`role_id`),
    INDEX `IDX_2DE8C6A3A76ED395` (`user_id`),
    INDEX `IDX_2DE8C6A3D60322AC` (`role_id`),
    CONSTRAINT `FK_2DE8C6A3A76ED395`
        FOREIGN KEY (`user_id`)
        REFERENCES `user` (`id`)
        ON DELETE CASCADE,
    CONSTRAINT `FK_2DE8C6A3D60322AC`
        FOREIGN KEY (`role_id`)
        REFERENCES `role` (`id`)
        ON DELETE CASCADE
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- user
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `user`;

CREATE TABLE `user`
(
    `id` INTEGER NOT NULL AUTO_INCREMENT,
    `username` VARCHAR(255) NOT NULL,
    `password` VARCHAR(255) NOT NULL,
    `salt` VARCHAR(255) NOT NULL,
    `firstname` VARCHAR(255) NOT NULL,
    `lastname` VARCHAR(255) NOT NULL,
    `email` VARCHAR(255) NOT NULL,
    `phone` VARCHAR(255) NOT NULL,
    `memo` LONGTEXT NOT NULL,
    `activated` TINYINT(1) NOT NULL,
    `last_login` DATETIME NOT NULL,
    `notification_change` tinyint(1) unsigned DEFAULT 1 NOT NULL,
    `notification_error` tinyint(1) unsigned DEFAULT 1 NOT NULL,
    PRIMARY KEY (`id`)
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- system_settings
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `system_settings`;

CREATE TABLE `system_settings`
(
    `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
    `key` VARCHAR(20) NOT NULL,
    `value` VARCHAR(255) NOT NULL,
    PRIMARY KEY (`id`)
) ENGINE=InnoDB;

# This restores the fkey checks, after having unset them earlier
SET FOREIGN_KEY_CHECKS = 1;
