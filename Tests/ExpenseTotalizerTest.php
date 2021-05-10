<?php declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use Classes\InvalidFileException;
use Classes\ExpenseTotalizer;

final class ExpenseTotalizerTest extends TestCase
{
    public function testInvalidData(): void
    {
        $this->expectException(InvalidFileException::class);
        $data = [['invalid', 'data'],
                ['very', 'invalid', 'data']];
        (new ExpenseTotalizer)->addExpense($data[0]);

        $this->expectException(InvalidFileException::class);
        (new ExpenseTotalizer)->addExpense($data[1]);
    }

    public function testAddExpense(): void
    {
        $totalizer = new ExpenseTotalizer;
        $totalizer->addExpense(['Test', '10.2', '2']);
        $this->assertEquals([['Test', '10.2', '2']], $totalizer->getExpenses());
    }

    public function testTotalization(): void
    {
        $totalizer = new ExpenseTotalizer;
        $totalizer->addExpense(['Test', '10.2', '2']);
        $totalizer->addExpense(['Test', '5.1', '3']);
        $totalizer->totalize();
        $this->assertEquals(['Test' => 35.7], $totalizer->getTotals());
    }
}