ALTER TABLE `account` ADD `currency_id` INT NOT NULL DEFAULT '0' AFTER `account_mobile_numbers`;

ALTER TABLE `transaction_entry` ADD `multiplier` INT NOT NULL DEFAULT '0' AFTER `select_user_default_cash_acc_id`;

ALTER TABLE `transaction_entry` ADD `base_currency_amount` DOUBLE NOT NULL AFTER `multiplier`;

ALTER TABLE `transaction_entry` ADD `base_currency_id` INT NOT NULL AFTER `currency_id`;

CREATE TABLE IF NOT EXISTS `currency_rate` (
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `currency_id` int(11) NOT NULL,
    `multiplier` double NOT NULL,
    `currency_multiplied_id` int(11) NOT NULL,
    PRIMARY KEY (`id`)
    );

INSERT INTO `currency_rate` (`id`, `currency_id`, `multiplier`, `currency_multiplied_id`) VALUES(1, 1, 3.67, 4),(2, 1, 150, 2),(3, 1, 80, 3);