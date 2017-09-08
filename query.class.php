<?php
class mysqliQueryClass extends mysqliBaseClass {

    public function getEmployeeName($emppsn)
    {
        $query = $this->findQuery('emp_name', 'employee_hr', '', 'emp_psn = ' . $emppsn);
        return $query;
    }
}