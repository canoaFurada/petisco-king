-- -----------------------------------------------------
-- Schema ifesp_plano_estudo
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `ifesp_plano_estudo` DEFAULT CHARACTER SET utf8 ;
USE `ifesp_plano_estudo` ;

-- -----------------------------------------------------
-- Table `ifesp_plano_estudo`.`type_courses`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `ifesp_plano_estudo`.`type_courses` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(100) NOT NULL,
  `number_steps` INT NOT NULL,
  `number_groups` INT NOT NULL,
  `type` TINYINT(1) NOT NULL DEFAULT 0,
  `slug` VARCHAR(100) NOT NULL,
  `status` TINYINT(1) NULL,
  `created_at` TIMESTAMP NULL,
  `updated_at` TIMESTAMP NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `ifesp_plano_estudo`.`study_plans`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `ifesp_plano_estudo`.`study_plans` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `type_course_id` INT NOT NULL,
  `structure` LONGTEXT NOT NULL,
  `slug` TEXT NOT NULL,
  `status` TINYINT(1) NULL,
  `created_at` TIMESTAMP NULL,
  `updated_at` TIMESTAMP NULL,
  PRIMARY KEY (`id`, `type_course_id`),
  CONSTRAINT `fk_study_plans_type_courses`
    FOREIGN KEY (`type_course_id`)
    REFERENCES `ifesp_plano_estudo`.`type_courses` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;

CREATE INDEX `fk_study_plans_type_courses_idx` ON `ifesp_plano_estudo`.`study_plans` (`type_course_id` ASC);