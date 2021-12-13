<?php 

namespace App\Search;

class SearchProduct
{
    private $filterByName;

    private $filterByCategory;

    public function getFilterByName()
    {
        return $this->filterByName;
    }

    public function setFilterByName($filterByName)
    {
        $this->filterByName = $filterByName;
        return $this;
    }

    public function getFilterByCategory()
    {
        return $this->filterByCategory;
    }

    public function setFilterByCategory($filterByCategory)
    {
        $this->filterByCategory = $filterByCategory;
        return $this;
    }

}


?>