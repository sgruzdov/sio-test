<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Exception;
use Doctrine\DBAL\Schema\Schema;
use Doctrine\DBAL\Schema\SchemaException;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240601045544 extends AbstractMigration
{
    /**
     * @return string
     */
    public function getDescription(): string
    {
        return 'Initial database schema';
    }

    /**
     * @param Schema $schema
     * @return void
     * @throws SchemaException
     */
    public function up(Schema $schema): void
    {
        $this->createProductTable($schema);
        $this->createCouponTable($schema);
    }

    /**
     * @param Schema $schema
     * @return void
     * @throws Exception
     */
    public function postUp(Schema $schema): void
    {
        $this->connection->executeQuery("ALTER TABLE doctrine_migration_versions CHANGE executed_at executed_at DATETIME NOT NULL COMMENT '(DC2Type:datetime_immutable)'");
    }

    /**
     * @param Schema $schema
     * @return void
     * @throws SchemaException
     */
    private function createProductTable(Schema $schema): void
    {
        if (!$schema->hasTable('product')) {
            $table = $schema->createTable('product');

            $table->addColumn('product_id', 'integer', ['autoincrement' => true, 'unsigned' => true, 'notnull' => true]);
            $table->addColumn('label', 'string', ['notnull' => true, 'length' => 255]);
            $table->addColumn('price', 'decimal', ['unsigned' => true, 'notnull' => true, 'precision' => 10, 'scale' => 2]);
            $table->addColumn('is_active', 'boolean', ['unsigned' => true, 'notnull' => true, 'default' => 1]);

            $table->setPrimaryKey(['product_id']);
            $table->addOption('engine', 'InnoDB');
            $table->addOption('comment', 'Таблица для хранения продуктов');

            $table->addIndex(['is_active'], 'is_active');
        }
    }

    /**
     * @param Schema $schema
     * @return void
     * @throws SchemaException
     */
    private function createCouponTable(Schema $schema): void
    {
        if (!$schema->hasTable('coupon')) {
            $table = $schema->createTable('coupon');

            $table->addColumn('coupon_id', 'integer', ['autoincrement' => true, 'unsigned' => true, 'notnull' => true]);
            $table->addColumn('code', 'string', ['notnull' => true, 'length' => 255]);
            $table->addColumn('type_id', 'smallint', ['unsigned' => true, 'notnull' => true]);
            $table->addColumn('amount', 'decimal', ['unsigned' => true, 'notnull' => true, 'precision' => 10, 'scale' => 2]);
            $table->addColumn('is_used', 'boolean', ['unsigned' => true, 'notnull' => true, 'default' => 0]);

            $table->setPrimaryKey(['coupon_id']);
            $table->addOption('engine', 'InnoDB');
            $table->addOption('comment', 'Таблица для хранения купонов');

            $table->addIndex(['is_used'], 'is_used');
        }
    }

    /**
     * @param Schema $schema
     * @return void
     */
    public function down(Schema $schema): void
    {
        // do nothing
    }
}
