<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221219133615 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE adresse (id INT AUTO_INCREMENT NOT NULL, complement_adresse VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE boutique (id INT AUTO_INCREMENT NOT NULL, adresse_id_id INT DEFAULT NULL, nom VARCHAR(255) NOT NULL, horaires_de_ouverture LONGTEXT NOT NULL COMMENT \'(DC2Type:json)\', en_conge TINYINT(1) NOT NULL, date_de_creation DATETIME NOT NULL, UNIQUE INDEX UNIQ_A1223C541004EF61 (adresse_id_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE categorie (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE produit (id INT AUTO_INCREMENT NOT NULL, boutique_id_id INT DEFAULT NULL, nom VARCHAR(255) NOT NULL, prix DOUBLE PRECISION NOT NULL, description VARCHAR(255) DEFAULT NULL, INDEX IDX_29A5EC27D4333D4F (boutique_id_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE produit_categorie (produit_id INT NOT NULL, categorie_id INT NOT NULL, INDEX IDX_CDEA88D8F347EFB (produit_id), INDEX IDX_CDEA88D8BCF5E72D (categorie_id), PRIMARY KEY(produit_id, categorie_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE ville (id INT AUTO_INCREMENT NOT NULL, code_postale INT NOT NULL, nom VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE boutique ADD CONSTRAINT FK_A1223C541004EF61 FOREIGN KEY (adresse_id_id) REFERENCES adresse (id)');
        $this->addSql('ALTER TABLE produit ADD CONSTRAINT FK_29A5EC27D4333D4F FOREIGN KEY (boutique_id_id) REFERENCES boutique (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE produit_categorie ADD CONSTRAINT FK_CDEA88D8F347EFB FOREIGN KEY (produit_id) REFERENCES produit (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE produit_categorie ADD CONSTRAINT FK_CDEA88D8BCF5E72D FOREIGN KEY (categorie_id) REFERENCES categorie (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user ADD adresse_id_id INT DEFAULT NULL, ADD boutique_id_id INT DEFAULT NULL, DROP date_de_naissance');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D6491004EF61 FOREIGN KEY (adresse_id_id) REFERENCES adresse (id)');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D649D4333D4F FOREIGN KEY (boutique_id_id) REFERENCES boutique (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8D93D6491004EF61 ON user (adresse_id_id)');
        $this->addSql('CREATE INDEX IDX_8D93D649D4333D4F ON user (boutique_id_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D6491004EF61');
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D649D4333D4F');
        $this->addSql('ALTER TABLE boutique DROP FOREIGN KEY FK_A1223C541004EF61');
        $this->addSql('ALTER TABLE produit DROP FOREIGN KEY FK_29A5EC27D4333D4F');
        $this->addSql('ALTER TABLE produit_categorie DROP FOREIGN KEY FK_CDEA88D8F347EFB');
        $this->addSql('ALTER TABLE produit_categorie DROP FOREIGN KEY FK_CDEA88D8BCF5E72D');
        $this->addSql('DROP TABLE adresse');
        $this->addSql('DROP TABLE boutique');
        $this->addSql('DROP TABLE categorie');
        $this->addSql('DROP TABLE produit');
        $this->addSql('DROP TABLE produit_categorie');
        $this->addSql('DROP TABLE ville');
        $this->addSql('DROP INDEX UNIQ_8D93D6491004EF61 ON user');
        $this->addSql('DROP INDEX IDX_8D93D649D4333D4F ON user');
        $this->addSql('ALTER TABLE user ADD date_de_naissance DATE NOT NULL, DROP adresse_id_id, DROP boutique_id_id');
    }
}
