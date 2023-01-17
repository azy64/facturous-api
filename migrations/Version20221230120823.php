<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221230120823 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE customer (id INT AUTO_INCREMENT NOT NULL, denomination VARCHAR(255) NOT NULL, nom VARCHAR(255) DEFAULT NULL, prenom VARCHAR(255) DEFAULT NULL, email VARCHAR(255) NOT NULL, adresse_customer VARCHAR(255) NOT NULL, adresse_livraison VARCHAR(255) DEFAULT NULL, adresse_facturation VARCHAR(255) DEFAULT NULL, phone_number VARCHAR(12) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE etat_facture (id INT AUTO_INCREMENT NOT NULL, libelle VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE facture (id INT AUTO_INCREMENT NOT NULL, etat_facture_id INT NOT NULL, customer_id INT NOT NULL, seller_id INT NOT NULL, num_fac VARCHAR(255) NOT NULL, date_vente DATETIME NOT NULL, num_tva VARCHAR(255) NOT NULL, num_bon_order VARCHAR(255) NOT NULL, total_amount_ht DOUBLE PRECISION NOT NULL, total_amount_ttc DOUBLE PRECISION NOT NULL, adresse_fac VARCHAR(255) NOT NULL, libelle_fac VARCHAR(255) NOT NULL, remise_ht VARCHAR(255) DEFAULT NULL, date_paiement DATETIME NOT NULL, currency VARCHAR(5) NOT NULL, UNIQUE INDEX UNIQ_FE866410D661D21D (etat_facture_id), INDEX IDX_FE8664109395C3F3 (customer_id), INDEX IDX_FE8664108DE820D9 (seller_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE item (id INT AUTO_INCREMENT NOT NULL, facture_id INT NOT NULL, description LONGTEXT NOT NULL, quantity DOUBLE PRECISION NOT NULL, unit_price_ht DOUBLE PRECISION NOT NULL, total_ht DOUBLE PRECISION NOT NULL, currency VARCHAR(5) DEFAULT NULL, tva INT NOT NULL, INDEX IDX_1F1B251E7F2DEE08 (facture_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE reglement (id INT AUTO_INCREMENT NOT NULL, facture_id INT NOT NULL, type_regelement_id INT NOT NULL, date_reglement DATETIME NOT NULL, amount DOUBLE PRECISION NOT NULL, INDEX IDX_EBE4C14C7F2DEE08 (facture_id), INDEX IDX_EBE4C14C90BAE289 (type_regelement_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE seller (id INT AUTO_INCREMENT NOT NULL, denomination VARCHAR(255) NOT NULL, nom VARCHAR(255) NOT NULL, prenom VARCHAR(255) DEFAULT NULL, adresse_siege VARCHAR(255) NOT NULL, adresse_facturation VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, mot_de_passe VARCHAR(255) NOT NULL, code_postale VARCHAR(255) NOT NULL, ville VARCHAR(255) NOT NULL, siren VARCHAR(9) NOT NULL, siret VARCHAR(14) NOT NULL, rcs VARCHAR(255) NOT NULL, logo VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE type_reglement (id INT AUTO_INCREMENT NOT NULL, libelle VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL, available_at DATETIME NOT NULL, delivered_at DATETIME DEFAULT NULL, INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE facture ADD CONSTRAINT FK_FE866410D661D21D FOREIGN KEY (etat_facture_id) REFERENCES etat_facture (id)');
        $this->addSql('ALTER TABLE facture ADD CONSTRAINT FK_FE8664109395C3F3 FOREIGN KEY (customer_id) REFERENCES customer (id)');
        $this->addSql('ALTER TABLE facture ADD CONSTRAINT FK_FE8664108DE820D9 FOREIGN KEY (seller_id) REFERENCES seller (id)');
        $this->addSql('ALTER TABLE item ADD CONSTRAINT FK_1F1B251E7F2DEE08 FOREIGN KEY (facture_id) REFERENCES facture (id)');
        $this->addSql('ALTER TABLE reglement ADD CONSTRAINT FK_EBE4C14C7F2DEE08 FOREIGN KEY (facture_id) REFERENCES facture (id)');
        $this->addSql('ALTER TABLE reglement ADD CONSTRAINT FK_EBE4C14C90BAE289 FOREIGN KEY (type_regelement_id) REFERENCES type_reglement (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE facture DROP FOREIGN KEY FK_FE866410D661D21D');
        $this->addSql('ALTER TABLE facture DROP FOREIGN KEY FK_FE8664109395C3F3');
        $this->addSql('ALTER TABLE facture DROP FOREIGN KEY FK_FE8664108DE820D9');
        $this->addSql('ALTER TABLE item DROP FOREIGN KEY FK_1F1B251E7F2DEE08');
        $this->addSql('ALTER TABLE reglement DROP FOREIGN KEY FK_EBE4C14C7F2DEE08');
        $this->addSql('ALTER TABLE reglement DROP FOREIGN KEY FK_EBE4C14C90BAE289');
        $this->addSql('DROP TABLE customer');
        $this->addSql('DROP TABLE etat_facture');
        $this->addSql('DROP TABLE facture');
        $this->addSql('DROP TABLE item');
        $this->addSql('DROP TABLE reglement');
        $this->addSql('DROP TABLE seller');
        $this->addSql('DROP TABLE type_reglement');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
