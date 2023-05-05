<?php
class User
{
    private $errors = array();
    public function signup($POST)
    {
        foreach ($POST as $key => $value) {
            if ($key == 'name') {
                if (trim($value) == '') {
                    $this->errors[] = "Adj meg egy helyes nevet";
                }
            }
        }
        if (count($this->errors) == 0) {
        }
        return $this->errors;
    }
}
