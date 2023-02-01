<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221219194444 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE adresse DROP FOREIGN KEY FK_C35F0816F269AF88');
        $this->addSql('DROP INDEX IDX_C35F0816F269AF88 ON adresse');
        $this->addSql('ALTER TABLE adresse CHANGE vile_id_id ville_id_id INT NOT NULL');
        $this->addSql('ALTER TABLE adresse ADD CONSTRAINT FK_C35F0816F0C17188 FOREIGN KEY (ville_id_id) REFERENCES ville (id)');
        $this->addSql('CREATE INDEX IDX_C35F0816F0C17188 ON adresse (ville_id_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE adresse DROP FOREIGN KEY FK_C35F0816F0C17188');
        $this->addSql('DROP INDEX IDX_C35F0816F0C17188 ON adresse');
        $this->addSql('ALTER TABLE adresse CHANGE ville_id_id vile_id_id INT NOT NULL');
        $this->addSql('ALTER TABLE adresse ADD CONSTRAINT FK_C35F0816F269AF88 FOREIGN KEY (vile_id_id) REFERENCES ville (id)');
        $this->addSql('CREATE INDEX IDX_C35F0816F269AF88 ON adresse (vile_id_id)');
    }
}
