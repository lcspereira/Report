<?php

namespace Classes;

class ExpenseTotalizer
{
    private $expenses;
    private $totals;

    public function loadFromFile(string $path) : void
    {
        $this->expenses = [];
        if (($expFile = fopen($path, 'r')) !== false){
            while (($data = fgetcsv($expFile, 0, ',')) !== false) {
                $this->expenses[] = $data;
            }
            fclose($expFile);
        }
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
     *
     * @return  self
     */ 
    public function setTotals($totals)
    {
        $this->totals = $totals;

        return $this;
    }

    public function getCategories() : \Ds\Set
    {
        $categories = new \Ds\Set();
        array_walk($this->expenses, function($expense) use ($categories)
        {
            $categories->add($expense[0]);
        });
        return $categories->toArray();
    }

    public function totalizeCategory(string $category) : void
    {
        $this->totals[$category] = 0;

        foreach ($this->expenses as $expense) {
            if ($expense[0] == $category) {
                $this->totals[$category] += $expense[1] * $expense[2];
            }
        }
    }

    public function totalize() : void
    {
        foreach ($this->getCategories() as $category) {
            $this->totalizeCategory($category);
        }
    }

    public function toHtml()
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
        $html .= "<table>";

        return $html;
    }

    public static function exportToCsv(ExpenseTotalizer $totalizer)
    {
        $file = fopen('php://memory', 'w');
        foreach ($totalizer->getTotals() as $category => $total) {
            $line = [$category,$total];
            fputcsv($file, $line, ',');
        }
        fseek($file, 0);
        header('Content-type: application/csv');
        header('Content-Disposition: attachment; filename="total_expenses_' . date('Ymd') . '.csv');
        fpassthru($file);
        fclose($file);
    }
}