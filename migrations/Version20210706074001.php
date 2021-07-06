<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210706074001 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE centre (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(80) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE stagiaire ADD centre_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE stagiaire ADD CONSTRAINT FK_4F62F731463CD7C3 FOREIGN KEY (centre_id) REFERENCES centre (id)');
        $this->addSql('CREATE INDEX IDX_4F62F731463CD7C3 ON stagiaire (centre_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE stagiaire DROP FOREIGN KEY FK_4F62F731463CD7C3');
        $this->addSql('DROP TABLE centre');
        $this->addSql('DROP INDEX IDX_4F62F731463CD7C3 ON stagiaire');
        $this->addSql('ALTER TABLE stagiaire DROP centre_id');
    }
}
