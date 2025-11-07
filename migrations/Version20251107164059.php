<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20251107164059 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE category (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME DEFAULT NULL, slug VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_64C19C1989D9B62 (slug), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE category_translation (id INT AUTO_INCREMENT NOT NULL, object_id INT DEFAULT NULL, locale VARCHAR(8) NOT NULL, field VARCHAR(32) NOT NULL, content LONGTEXT DEFAULT NULL, INDEX IDX_3F20704232D562B (object_id), UNIQUE INDEX UNIQ_3F207044180C698232D562B5BF54558 (locale, object_id, field), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE contact_message (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, message TEXT NOT NULL, has_been_read TINYINT(1) DEFAULT 0 NOT NULL, reply_date DATETIME DEFAULT NULL, has_been_replied TINYINT(1) DEFAULT 0 NOT NULL, reply_message TEXT DEFAULT NULL, created_at DATETIME NOT NULL, updated_at DATETIME DEFAULT NULL, mobile_number VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE project (id INT AUTO_INCREMENT NOT NULL, category_id INT DEFAULT NULL, subtitle VARCHAR(255) DEFAULT NULL, description VARCHAR(255) DEFAULT NULL, cta_button_label VARCHAR(255) DEFAULT NULL, cta_button_link VARCHAR(255) DEFAULT NULL, is_workshop TINYINT(1) NOT NULL, is_illustration TINYINT(1) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME DEFAULT NULL, award_image VARCHAR(255) DEFAULT NULL, award_size INT DEFAULT NULL, award_mime_type VARCHAR(255) DEFAULT NULL, award_original_name VARCHAR(255) DEFAULT NULL, award_dimensions JSON DEFAULT NULL COMMENT \'(DC2Type:json)\', award_image2 VARCHAR(255) DEFAULT NULL, award_size2 INT DEFAULT NULL, award_mime_type2 VARCHAR(255) DEFAULT NULL, award_original_name2 VARCHAR(255) DEFAULT NULL, award_dimensions2 JSON DEFAULT NULL COMMENT \'(DC2Type:json)\', caption VARCHAR(255) DEFAULT NULL, is_active TINYINT(1) NOT NULL, main_image VARCHAR(255) DEFAULT NULL, size INT DEFAULT NULL, mime_type VARCHAR(255) DEFAULT NULL, original_name VARCHAR(255) DEFAULT NULL, dimensions JSON DEFAULT NULL COMMENT \'(DC2Type:json)\', position SMALLINT DEFAULT 1 NOT NULL, slug VARCHAR(255) NOT NULL, title VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_2FB3D0EE989D9B62 (slug), INDEX IDX_2FB3D0EE12469DE2 (category_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE project_image (id INT AUTO_INCREMENT NOT NULL, project_id INT NOT NULL, alt_image_text VARCHAR(255) DEFAULT NULL, created_at DATETIME NOT NULL, updated_at DATETIME DEFAULT NULL, caption VARCHAR(255) DEFAULT NULL, main_image VARCHAR(255) DEFAULT NULL, size INT DEFAULT NULL, mime_type VARCHAR(255) DEFAULT NULL, original_name VARCHAR(255) DEFAULT NULL, dimensions JSON DEFAULT NULL COMMENT \'(DC2Type:json)\', position SMALLINT DEFAULT 1 NOT NULL, INDEX IDX_D6680DC1166D1F9C (project_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE project_image_translation (id INT AUTO_INCREMENT NOT NULL, object_id INT DEFAULT NULL, locale VARCHAR(8) NOT NULL, field VARCHAR(32) NOT NULL, content LONGTEXT DEFAULT NULL, INDEX IDX_4F6C52DE232D562B (object_id), UNIQUE INDEX UNIQ_4F6C52DE4180C698232D562B5BF54558 (locale, object_id, field), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE project_translation (id INT AUTO_INCREMENT NOT NULL, object_id INT DEFAULT NULL, locale VARCHAR(8) NOT NULL, field VARCHAR(32) NOT NULL, content LONGTEXT DEFAULT NULL, INDEX IDX_7CA6B294232D562B (object_id), UNIQUE INDEX UNIQ_7CA6B2944180C698232D562B5BF54558 (locale, object_id, field), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', available_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', delivered_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE category_translation ADD CONSTRAINT FK_3F20704232D562B FOREIGN KEY (object_id) REFERENCES category (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE project ADD CONSTRAINT FK_2FB3D0EE12469DE2 FOREIGN KEY (category_id) REFERENCES category (id)');
        $this->addSql('ALTER TABLE project_image ADD CONSTRAINT FK_D6680DC1166D1F9C FOREIGN KEY (project_id) REFERENCES project (id)');
        $this->addSql('ALTER TABLE project_image_translation ADD CONSTRAINT FK_4F6C52DE232D562B FOREIGN KEY (object_id) REFERENCES project_image (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE project_translation ADD CONSTRAINT FK_7CA6B294232D562B FOREIGN KEY (object_id) REFERENCES project (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE category_translation DROP FOREIGN KEY FK_3F20704232D562B');
        $this->addSql('ALTER TABLE project DROP FOREIGN KEY FK_2FB3D0EE12469DE2');
        $this->addSql('ALTER TABLE project_image DROP FOREIGN KEY FK_D6680DC1166D1F9C');
        $this->addSql('ALTER TABLE project_image_translation DROP FOREIGN KEY FK_4F6C52DE232D562B');
        $this->addSql('ALTER TABLE project_translation DROP FOREIGN KEY FK_7CA6B294232D562B');
        $this->addSql('DROP TABLE category');
        $this->addSql('DROP TABLE category_translation');
        $this->addSql('DROP TABLE contact_message');
        $this->addSql('DROP TABLE project');
        $this->addSql('DROP TABLE project_image');
        $this->addSql('DROP TABLE project_image_translation');
        $this->addSql('DROP TABLE project_translation');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
