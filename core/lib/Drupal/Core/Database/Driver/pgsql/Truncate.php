<?php

/**
 * @file
 * Contains \Drupal\Core\Database\Driver\pgsql\Truncate.
 */

namespace Drupal\Core\Database\Driver\pgsql;

use Drupal\Core\Database\Query\Truncate as QueryTruncate;

class Truncate extends QueryTruncate {

  /**
   * {@inheritdoc}
   */
  public function execute() {
    $this->connection->addSavepoint();
    try {
      $result = parent::execute();
    }
    catch (\Exception $e) {
      $this->connection->rollbackSavepoint();
      throw $e;
    }
    $this->connection->releaseSavepoint();

    return $result;
  }
}
