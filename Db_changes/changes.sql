ALTER TABLE `user_details` CHANGE `credit_balance` `credit_balance` FLOAT NOT NULL DEFAULT '0';
ALTER TABLE `user_details` CHANGE `gender` `gender` ENUM('male','female') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL;

-- changes on 08/07/2023
ALTER TABLE `flight_bookings` ADD `direction` VARCHAR(191) NULL DEFAULT NULL AFTER `unique_booking_id`;




ALTER TABLE `flight_searches` ADD `direction` VARCHAR(191) NULL DEFAULT NULL AFTER `booking_id`;
ALTER TABLE `flight_bookings` ADD `reissue_quote_ptr` VARCHAR(191) NULL DEFAULT NULL AFTER `agents_amount`;