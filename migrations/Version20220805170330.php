<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220805170330 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE application (id INT AUTO_INCREMENT NOT NULL, applicant_id INT NOT NULL, mobility_id INT NOT NULL, application_date DATE NOT NULL, status TINYINT(1) DEFAULT NULL, INDEX IDX_A45BDDC197139001 (applicant_id), INDEX IDX_A45BDDC18D92EAA4 (mobility_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE certification (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(500) NOT NULL, field VARCHAR(500) DEFAULT NULL, string_marks_allowed TINYINT(1) NOT NULL, mark_description VARCHAR(500) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE certification_detail (id INT AUTO_INCREMENT NOT NULL, certified_id INT NOT NULL, certification_id INT NOT NULL, obtain_date DATE NOT NULL, mark VARCHAR(100) DEFAULT NULL, authentic TINYINT(1) DEFAULT NULL, INDEX IDX_C82E66242EC69D07 (certified_id), INDEX IDX_C82E6624CB47068A (certification_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE grade (id INT AUTO_INCREMENT NOT NULL, institution_id INT NOT NULL, name VARCHAR(255) NOT NULL, INDEX IDX_595AAE3410405986 (institution_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE institution (id INT AUTO_INCREMENT NOT NULL, photo_url VARCHAR(666) DEFAULT NULL, name VARCHAR(444) NOT NULL, description VARCHAR(666) DEFAULT NULL, longitude DOUBLE PRECISION DEFAULT NULL, latitude DOUBLE PRECISION DEFAULT NULL, website VARCHAR(666) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE mobility (id INT AUTO_INCREMENT NOT NULL, institution_id INT NOT NULL, name VARCHAR(333) NOT NULL, description VARCHAR(888) DEFAULT NULL, start_date DATE NOT NULL, end_date DATE DEFAULT NULL, size INT DEFAULT NULL, INDEX IDX_D650201C10405986 (institution_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE mobility_grade (mobility_id INT NOT NULL, grade_id INT NOT NULL, INDEX IDX_24BEE96C8D92EAA4 (mobility_id), INDEX IDX_24BEE96CFE19A1A8 (grade_id), PRIMARY KEY(mobility_id, grade_id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE mobility_certification (mobility_id INT NOT NULL, certification_id INT NOT NULL, INDEX IDX_E7C4B31B8D92EAA4 (mobility_id), INDEX IDX_E7C4B31BCB47068A (certification_id), PRIMARY KEY(mobility_id, certification_id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(333) NOT NULL, password VARCHAR(255) NOT NULL, name VARCHAR(300) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE year_detail (id INT AUTO_INCREMENT NOT NULL, student_id INT NOT NULL, grade_id INT NOT NULL, moyennes LONGTEXT NOT NULL COMMENT \'(DC2Type:array)\', eng VARCHAR(100) DEFAULT NULL, fr VARCHAR(100) DEFAULT NULL, academic_year INT NOT NULL, authentic TINYINT(1) DEFAULT NULL, INDEX IDX_361256CACB944F1A (student_id), INDEX IDX_361256CAFE19A1A8 (grade_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL, available_at DATETIME NOT NULL, delivered_at DATETIME DEFAULT NULL, INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE application ADD CONSTRAINT FK_A45BDDC197139001 FOREIGN KEY (applicant_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE application ADD CONSTRAINT FK_A45BDDC18D92EAA4 FOREIGN KEY (mobility_id) REFERENCES mobility (id)');
        $this->addSql('ALTER TABLE certification_detail ADD CONSTRAINT FK_C82E66242EC69D07 FOREIGN KEY (certified_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE certification_detail ADD CONSTRAINT FK_C82E6624CB47068A FOREIGN KEY (certification_id) REFERENCES certification (id)');
        $this->addSql('ALTER TABLE grade ADD CONSTRAINT FK_595AAE3410405986 FOREIGN KEY (institution_id) REFERENCES institution (id)');
        $this->addSql('ALTER TABLE mobility ADD CONSTRAINT FK_D650201C10405986 FOREIGN KEY (institution_id) REFERENCES institution (id)');
        $this->addSql('ALTER TABLE mobility_grade ADD CONSTRAINT FK_24BEE96C8D92EAA4 FOREIGN KEY (mobility_id) REFERENCES mobility (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE mobility_grade ADD CONSTRAINT FK_24BEE96CFE19A1A8 FOREIGN KEY (grade_id) REFERENCES grade (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE mobility_certification ADD CONSTRAINT FK_E7C4B31B8D92EAA4 FOREIGN KEY (mobility_id) REFERENCES mobility (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE mobility_certification ADD CONSTRAINT FK_E7C4B31BCB47068A FOREIGN KEY (certification_id) REFERENCES certification (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE year_detail ADD CONSTRAINT FK_361256CACB944F1A FOREIGN KEY (student_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE year_detail ADD CONSTRAINT FK_361256CAFE19A1A8 FOREIGN KEY (grade_id) REFERENCES grade (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE certification_detail DROP FOREIGN KEY FK_C82E6624CB47068A');
        $this->addSql('ALTER TABLE mobility_certification DROP FOREIGN KEY FK_E7C4B31BCB47068A');
        $this->addSql('ALTER TABLE mobility_grade DROP FOREIGN KEY FK_24BEE96CFE19A1A8');
        $this->addSql('ALTER TABLE year_detail DROP FOREIGN KEY FK_361256CAFE19A1A8');
        $this->addSql('ALTER TABLE grade DROP FOREIGN KEY FK_595AAE3410405986');
        $this->addSql('ALTER TABLE mobility DROP FOREIGN KEY FK_D650201C10405986');
        $this->addSql('ALTER TABLE application DROP FOREIGN KEY FK_A45BDDC18D92EAA4');
        $this->addSql('ALTER TABLE mobility_grade DROP FOREIGN KEY FK_24BEE96C8D92EAA4');
        $this->addSql('ALTER TABLE mobility_certification DROP FOREIGN KEY FK_E7C4B31B8D92EAA4');
        $this->addSql('ALTER TABLE application DROP FOREIGN KEY FK_A45BDDC197139001');
        $this->addSql('ALTER TABLE certification_detail DROP FOREIGN KEY FK_C82E66242EC69D07');
        $this->addSql('ALTER TABLE year_detail DROP FOREIGN KEY FK_361256CACB944F1A');
        $this->addSql('DROP TABLE application');
        $this->addSql('DROP TABLE certification');
        $this->addSql('DROP TABLE certification_detail');
        $this->addSql('DROP TABLE grade');
        $this->addSql('DROP TABLE institution');
        $this->addSql('DROP TABLE mobility');
        $this->addSql('DROP TABLE mobility_grade');
        $this->addSql('DROP TABLE mobility_certification');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE year_detail');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
