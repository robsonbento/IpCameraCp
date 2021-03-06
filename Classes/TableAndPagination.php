<?php
// Version 1.0.0

require_once("System/Utility.php");

class TableAndPagination {
    // Vars
    private $searchIndex;
    private $paginationIndex;
    
    private $utility;
    
    // Properties
    
    // Functions public
    public function __construct() {
        $this->searchIndex = "";
        $this->paginationIndex = "";
        
        $this->utility = new Utility();
    }
    
    public function request($rows, $page, $sessionTag, $reverse, $flat) {
        $newRows = $reverse == true ? array_reverse($rows, true) : $rows;
        
        // Search
        $searchWritten = isset($_POST['searchWritten']) == true ? $_POST['searchWritten'] : -1;
        $search = $this->search($sessionTag . "Search", $searchWritten);
        $elements = $this->utility->arrayLike($newRows, $search['value'], $flat);
        
        // Pagination
        $paginationCurrent = isset($_POST['paginationCurrent']) == true ? $_POST['paginationCurrent'] : -1;
        $pagination = $this->pagination($sessionTag . "Pagination", $paginationCurrent, count($elements), $page);
        $listHtml = array_slice($elements, $pagination['offset'], $pagination['show']);
        
        return Array(
            'search' => $search,
            'pagination' => $pagination,
            'listHtml' => $listHtml
        );
    }
    
    public function checkPost() {
        if (isset($_POST['searchWritten']) == true && isset($_POST['paginationCurrent']) == true)
            return true;
        
        return false;
    }
    
    private function search($index, $value) {
        $this->searchIndex = $index;
        
        if (isset($_SESSION[$index]) == false)
            $_SESSION[$index] = "";
        else if ($value != -1)
            $_SESSION[$index] = $value;
        
        return Array(
            'value' => $_SESSION[$index]
        );
    }
    
    private function pagination($index, $value, $count, $show) {
        $this->paginationIndex = $index;
        
        if (isset($_SESSION[$index]) == false)
            $_SESSION[$index] = "";
        if ($value > -1)
            $_SESSION[$index] = $value;
        
        $total = ceil($count / $show);
        $current = $total == 0 ? 0 : $_SESSION[$index] + 1;
        
        if ($_SESSION[$index] > $total)
            $_SESSION[$index] = $total;
        
        $offset = $_SESSION[$index] * $show;
        $text = "$current / $total";
        $limit = "$offset,$show";
        
        return Array(
            'show' => $show,
            'offset' => $offset,
            'text' => $text,
            'limit' => $limit
        );
    }
    
    // Functions private
}