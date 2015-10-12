<?php namespace Archon\Tests\DataFrame\SQL;

use Archon\DataFrame;
use PDO;

class SQLDataFrameUnitTest extends \PHPUnit_Framework_TestCase
{

    public function testToSQL()
    {
        $df = DataFrame::fromArray([
            ['a' => 1, 'b' => 2, 'c' => 3],
            ['a' => 4, 'b' => 5, 'c' => 6],
            ['a' => 7, 'b' => 8, 'c' => 9],
        ]);

        $pdo = new PDO('sqlite::memory:');

        $pdo->exec("CREATE TABLE testTable (a TEXT, b TEXT, c TEXT);");
        $df->toSQL($pdo, 'testTable');
        $result = $pdo->query("SELECT * FROM testTable;")->fetchAll(PDO::FETCH_ASSOC);
        $this->assertEquals($result, $df->toArray());
        $pdo->exec("DROP TABLE testTable;");
    }
}
