<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231206122112 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE viande (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, description VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE detail_vente ADD produit_id INT NOT NULL');
        $this->addSql('ALTER TABLE detail_vente ADD CONSTRAINT FK_F57AE115F347EFB FOREIGN KEY (produit_id) REFERENCES produit (id)');
        $this->addSql('CREATE INDEX IDX_F57AE115F347EFB ON detail_vente (produit_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE viande');
        $this->addSql('ALTER TABLE detail_vente DROP FOREIGN KEY FK_F57AE115F347EFB');
        $this->addSql('DROP INDEX IDX_F57AE115F347EFB ON detail_vente');
        $this->addSql('ALTER TABLE detail_vente DROP produit_id');
    }
}
