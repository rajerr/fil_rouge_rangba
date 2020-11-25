<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201124234043 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE profile_sortie (id INT AUTO_INCREMENT NOT NULL, libelle VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE apprenant ADD profile_sorttie_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE apprenant ADD CONSTRAINT FK_C4EB462EDD7E0CE8 FOREIGN KEY (profile_sorttie_id) REFERENCES profile_sortie (id)');
        $this->addSql('CREATE INDEX IDX_C4EB462EDD7E0CE8 ON apprenant (profile_sorttie_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE apprenant DROP FOREIGN KEY FK_C4EB462EDD7E0CE8');
        $this->addSql('DROP TABLE profile_sortie');
        $this->addSql('DROP INDEX IDX_C4EB462EDD7E0CE8 ON apprenant');
        $this->addSql('ALTER TABLE apprenant DROP profile_sorttie_id');
    }
}
