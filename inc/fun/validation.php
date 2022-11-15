<?php

    interface validationMethod{
        public function check($name,$value);
    }

    class str implements validationMethod{

        public function check($name,$value)
        {
            if(is_numeric($value))
            {
                return "$name must be string";
            }
            return false;
        }
    }

    class num implements validationMethod
    {
        public function check($name,$value)
        {
            if(! is_numeric($value))
            {
                return "$name must be number";
            }
            return false;
        }
    }

    class req implements validationMethod
    {
        public function check($name,$value)
        {
            if(empty($value))
            {
                return "$name is requierd";
            }
            return false;
        }
    }

    class size implements validationMethod
    {
        public function check($name,$value)
        {
            if($value > 4194304)
            {
                return "$name must be less than 4MB";
            }
            return false;
        }
    }



    class validator{
        private $errors=[];
        public function check($name,$value,$arr){
            foreach($arr as $ar){
                $ob = new $ar;
                $err=$ob->check($name,$value);
                if($err !=false)
                {
                    $this->errors[]=$err;
                }

            }
        }


        public function geterrors()
        {
            return $this->errors;
        }

        public function checkerrors()
        {
            return empty($this->errors);
        }
    }





?>
