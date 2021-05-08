<?php

namespace Classes;
use Classes\InvalidFileException;

/**
 * Class to calculate expenses from expenses file
 */
class ExpenseTotalizer
{
    private $expenses;
    private $totals;

    /**
     * Load expenses from file
     * 
     * @param string: File path
     */
    public function loadFromFile(string $path) : void
    {
        $this->expenses = [];
        if (($expFile = fopen($path, 'r')) !== false){
            while (($data = fgetcsv($expFile, 0, ',')) !== false) {
                $data = array_map(array($this, 'sanitize'), $data);
                if ((isset ($data[1]) && !is_numeric($data[1])) || (isset($data[2]) && !is_numeric($data[2]))) {
                    throw new InvalidFileException("Invalid file format", -1);
                }
                $this->expenses[] = $data;
            }
            fclose($expFile);
        }
    }

    /**
     * Sanitize data
     * 
     * @param string: Info to be sanitized
     * @return: Info without slashes and tags
     */
    private function sanitize(string $info) : string
    {
        $info = stripcslashes($info);
        $info = strip_tags($info);
        return $info;
    }

    /**
     * Get the value of expenses
     */ 
    public function getExpenses()
    {
        return $this->expenses;
    }

    /**
     * Set the value of expenses
     */ 
    public function setExpenses($expenses)
    {
        $this->expenses = $expenses;
    }

    /**
     * Get the value of totals
     */ 
    public function getTotals()
    {
        return $this->totals;
    }

    /**
     * Set the value of totals
     */ 
    public function setTotals($totals)
    {
        $this->totals = $totals;
    }

    /**
     * Get the expense categories list
     * 
     * @return array: Unique categories list
     */
    public function getCategories() : array
    {
        $categories = new \Ds\Set();
        array_walk($this->expenses, function($expense) use ($categories)
        {
            $categories->add($expense[0]);
        });
        return $categories->toArray();
    }

    /**
     * Calculates expense total for a category and stores on total
     * 
     * @param string: Category to be calculated
     */
    public function totalizeCategory(string $category) : void
    {
        $this->totals[$category] = 0;

        foreach ($this->expenses as $expense) {
            if ($expense[0] == $category) {
                $this->totals[$category] += $expense[1] * $expense[2];
            }
        }
    }

    /**
     * Totalize expenses for all categories on expenses file
     */
    public function totalize() : void
    {
        foreach ($this->getCategories() as $category) {
            $this->totalizeCategory($category);
        }
    }

    /**
     * Prints expense totals table to HTML
     * 
     * @return string: Expense totals in HTML table format
     */
    public function toHtml() : string
    {
        $html  = "<table>";
        $html .= "  <thead>";
        $html .= "  </thead>";
        $html .= "  <tbody>";
        foreach ($this->totals as $category => $total) {
            $html .= "<tr>";
            $html .= "  <td>" . $category . "</td>";
            $html .= "  <td>" . $total . "</td>";
            $html .= "</tr>";
        }
        $html .= "  </tbody>";
        $html .= "</table>";

        return $html;
    }

    /**
     * Exports expense totals to CSV
     * 
     * @param ExpenseTotalizer: Expense totalizer object to be exported
     */
    public static function exportToCsv(ExpenseTotalizer $totalizer) : void
    {
        $file = fopen('php://memory', 'w');
        foreach ($totalizer->getTotals() as $category => $total) {
            $line = [$category,$total];
            fputcsv($file, $line, ',');
        }
        fseek($file, 0);
        header('Content-type: application/csv');
        header('Content-Disposition: attachment; filename="total_expenses_' . time() . '.csv');
        fpassthru($file);
        fclose($file);
    }
}