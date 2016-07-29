<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20160615180446 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql("INSERT INTO attributes VALUES ('627f06b8-18c7-4f36-a82e-579860310cae', 'Кухня', 'kuhnya', 1);");
        $this->addSql("INSERT INTO attributes VALUES ('63f581f4-3d32-420c-93a7-255255c4d96d', 'Гостинная', 'gostinnaya', 1);");
        $this->addSql("INSERT INTO attributes VALUES ('46735892-c66e-4d6e-ae7e-8a9d07491a20', 'Спальня', 'spalnya', 1);");
        $this->addSql("INSERT INTO attributes VALUES ('7ef9a141-822f-458c-abd7-5c2aee2f5124', 'Кабинет', 'kabinet', 1);");
        $this->addSql("INSERT INTO attributes VALUES ('5181e9b7-b07f-425d-bea5-dc8465aa663d', 'Детская', 'detskaya', 1);");
        $this->addSql("INSERT INTO attributes VALUES ('9074d079-0b32-44f4-95dd-b499025b9bc4', 'Ванная', 'vannaya', 1);");
        $this->addSql("INSERT INTO attributes VALUES ('0a5b8f13-18fe-4250-b2f0-0437659dea6f', 'Классика', 'klassika', 2);");
        $this->addSql("INSERT INTO attributes VALUES ('5449cbdf-e93a-4bc3-bab2-7447e0fe8614', 'Минимализм', 'minimalizm', 2);");
        $this->addSql("INSERT INTO attributes VALUES ('c9610d7e-d831-4a77-9dca-1911789ffc61', 'Античность', 'antichnost', 2);");
        $this->addSql("INSERT INTO attributes VALUES ('3b75bd90-d649-4c20-b389-51436b79dc35', 'Восток', 'vostok', 2);");
        $this->addSql("INSERT INTO roles VALUES ('09b99bec-a1bc-461d-a481-f7b7d0b45c9d', 'Designer');");
        $this->addSql("INSERT INTO roles VALUES ('b44b8a82-5240-4e22-bd5a-1daf56c7a7a4', 'Administrator');");
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        $this->addSql("DELETE FROM attributes WHERE id IN (
            '627f06b8-18c7-4f36-a82e-579860310cae',
            '63f581f4-3d32-420c-93a7-255255c4d96d',
            '46735892-c66e-4d6e-ae7e-8a9d07491a20',
            '7ef9a141-822f-458c-abd7-5c2aee2f5124',
            '5181e9b7-b07f-425d-bea5-dc8465aa663d',
            '9074d079-0b32-44f4-95dd-b499025b9bc4',
            '0a5b8f13-18fe-4250-b2f0-0437659dea6f',
            '5449cbdf-e93a-4bc3-bab2-7447e0fe8614',
            'c9610d7e-d831-4a77-9dca-1911789ffc61',
            '3b75bd90-d649-4c20-b389-51436b79dc35'
        );");
        $this->addSql("DELETE FROM roles WHERE id IN ('09b99bec-a1bc-461d-a481-f7b7d0b45c9d', 'b44b8a82-5240-4e22-bd5a-1daf56c7a7a4')");
    }
}
