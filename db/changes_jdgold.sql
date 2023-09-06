INSERT INTO `account_group` (`account_group_id`, `parent_group_id`, `account_group_name`, `sequence`, `display_in_balance_sheet`, `is_deletable`, `is_deleted`, `created_by`, `created_at`, `updated_by`, `updated_at`, `user_created_by`, `user_updated_by`) VALUES (58, '27', 'Agent', '11', '1', '0', '0', '1', '2017-08-04 09:26:32', '1', '2017-08-04 09:26:32', NULL, NULL);

DROP TABLE IF EXISTS `swipe_machines`;
CREATE TABLE IF NOT EXISTS `swipe_machines` (
  `machine_id` int(11) NOT NULL AUTO_INCREMENT,
  `bank_acc_id` int(11) NOT NULL,
  `machine_name` varchar(40) NOT NULL,
  `bank_commission` decimal(10,2) NOT NULL DEFAULT 0.00,
  `created_on` datetime NOT NULL DEFAULT current_timestamp(),
  `created_by` int(11) NOT NULL,
  PRIMARY KEY (`machine_id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=latin1;


ALTER TABLE `transaction_entry` ADD `mach_id` INT NOT NULL AFTER `updated_by`, ADD `bank_perc` DECIMAL(10,2) NOT NULL AFTER `mach_id`, ADD `client_perc` DECIMAL(10,2) NOT NULL AFTER `bank_perc`, ADD `agent_perc` DECIMAL(10,2) NOT NULL AFTER `client_perc`;
ALTER TABLE `transaction_entry` ADD `tag` VARCHAR(20) NOT NULL AFTER `agent_perc`;

INSERT INTO `website_modules` (`website_module_id`, `title`, `main_module`) VALUES (NULL, 'Bank Transaction', NULL);
INSERT INTO `module_roles` (`module_role_id`, `title`, `role_name`, `website_module_id`) VALUES (NULL, 'View', 'view', '50'), (NULL, 'Add', 'add', '50');
INSERT INTO `module_roles` (`module_role_id`, `title`, `role_name`, `website_module_id`) VALUES (NULL, 'Edit', 'edit', '50'), (NULL, 'Delete', 'delete', '50');
INSERT INTO `user_roles` (`user_role_id`, `user_id`, `website_module_id`, `role_type_id`) VALUES (NULL, '2', '50', '140'), (NULL, '2', '50', '141');
INSERT INTO `user_roles` (`user_role_id`, `user_id`, `website_module_id`, `role_type_id`) VALUES (NULL, '2', '50', '142'), (NULL, '2', '50', '143');

ALTER TABLE `account` ADD `profile` VARCHAR(512) NULL AFTER `rtgs_ifsc_code`;
ALTER TABLE `account` ADD `ib_account_id` INT(11) NULL AFTER `account_id`;

ALTER TABLE `transaction_entry` CHANGE `multiplier` `multiplier` DOUBLE NULL DEFAULT NULL;

INSERT INTO `website_modules` (`website_module_id`, `title`, `main_module`) VALUES (NULL, 'All Allowed Accounts', '3');
INSERT INTO `module_roles` (`module_role_id`, `title`, `role_name`, `website_module_id`) VALUES (NULL, 'view', 'view', '58');

