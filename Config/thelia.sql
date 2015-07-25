
# This is a fix for InnoDB in MySQL >= 4.1.x
# It "suspends judgement" for fkey relationships until are tables are set.
SET FOREIGN_KEY_CHECKS = 0;

-- ---------------------------------------------------------------------
-- customer_product
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `customer_product`;

CREATE TABLE `customer_product`
(
    `customer_id` INTEGER NOT NULL,
    `product_id` INTEGER NOT NULL,
    INDEX `FI_product_id` (`product_id`),
    INDEX `FI_customer_id` (`customer_id`),
    CONSTRAINT `fk_product_id`
        FOREIGN KEY (`product_id`)
        REFERENCES `product` (`id`)
        ON DELETE CASCADE,
    CONSTRAINT `fk_customer_id`
        FOREIGN KEY (`customer_id`)
        REFERENCES `customer` (`id`)
        ON DELETE CASCADE
) ENGINE=InnoDB;

# This restores the fkey checks, after having unset them earlier
SET FOREIGN_KEY_CHECKS = 1;
