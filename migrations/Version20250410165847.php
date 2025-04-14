<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20250410165847 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Ajout du champ is_paid à la table reservation';
    }

    public function up(Schema $schema): void
    {
        $this->addSql(<<<'SQL'
            CREATE TEMPORARY TABLE __temp__reservation AS 
            SELECT id, user_id, ajout_evenement_id, created_at, updated_at, 0 as is_paid FROM reservation
        SQL);

        $this->addSql('DROP TABLE reservation');

        $this->addSql(<<<'SQL'
            CREATE TABLE reservation (
                id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL,
                user_id INTEGER NOT NULL,
                ajout_evenement_id INTEGER NOT NULL,
                created_at DATETIME NOT NULL,
                updated_at DATETIME NOT NULL,
                is_paid BOOLEAN NOT NULL,
                CONSTRAINT FK_42C84955A76ED395 FOREIGN KEY (user_id) REFERENCES user (id) NOT DEFERRABLE INITIALLY IMMEDIATE,
                CONSTRAINT FK_42C849555078057 FOREIGN KEY (ajout_evenement_id) REFERENCES ajout_evenement (id) NOT DEFERRABLE INITIALLY IMMEDIATE
            )
        SQL);

        $this->addSql(<<<'SQL'
            INSERT INTO reservation (id, user_id, ajout_evenement_id, created_at, updated_at, is_paid)
            SELECT id, user_id, ajout_evenement_id, created_at, updated_at, is_paid FROM __temp__reservation
        SQL);

        $this->addSql('DROP TABLE __temp__reservation');
        $this->addSql('CREATE INDEX IDX_42C849555078057 ON reservation (ajout_evenement_id)');
        $this->addSql('CREATE INDEX IDX_42C84955A76ED395 ON reservation (user_id)');
    }

    public function down(Schema $schema): void
    {
        $this->addSql(<<<'SQL'
            CREATE TEMPORARY TABLE __temp__reservation AS 
            SELECT id, user_id, ajout_evenement_id, created_at, updated_at FROM reservation
        SQL);

        $this->addSql('DROP TABLE reservation');

        $this->addSql(<<<'SQL'
            CREATE TABLE reservation (
                id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL,
                user_id INTEGER NOT NULL,
                ajout_evenement_id INTEGER NOT NULL,
                created_at DATETIME NOT NULL,
                updated_at DATETIME NOT NULL,
                statut VARCHAR(255) DEFAULT NULL,
                CONSTRAINT FK_42C84955A76ED395 FOREIGN KEY (user_id) REFERENCES user (id) NOT DEFERRABLE INITIALLY IMMEDIATE,
                CONSTRAINT FK_42C849555078057 FOREIGN KEY (ajout_evenement_id) REFERENCES ajout_evenement (id) NOT DEFERRABLE INITIALLY IMMEDIATE
            )
        SQL);

        $this->addSql(<<<'SQL'
            INSERT INTO reservation (id, user_id, ajout_evenement_id, created_at, updated_at)
            SELECT id, user_id, ajout_evenement_id, created_at, updated_at FROM __temp__reservation
        SQL);

        $this->addSql('DROP TABLE __temp__reservation');
        $this->addSql('CREATE INDEX IDX_42C84955A76ED395 ON reservation (user_id)');
        $this->addSql('CREATE INDEX IDX_42C849555078057 ON reservation (ajout_evenement_id)');
    }
}