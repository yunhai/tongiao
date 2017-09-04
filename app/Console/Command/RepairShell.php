<?php

App::uses('ComponentCollection', 'Controller');
App::uses('UtilityComponent', 'Controller/Component');

class RepairShell extends AppShell
{
    public function main()
    {
        $this->out('Hello world.');
    }

    public function number()
    {
        $collection = new ComponentCollection();
        $this->Utility = new UtilityComponent($collection);

        $string = [
            '1300',
            '1,300',
            '1,300,000',
            '1.300',
            '1.300.000',
            '1300,25',
            '1300.25',
            '1300.32',
            '1.300,25',
            '1,300.25',
            '900m2',
            '900 m2',
            'khoảng 900 m2',
            'khoang 900 m2',
            'chieu. chungtoi, 900m2',
        ];
        foreach ($string as $id => $string) {
            $this->out($string);
            $this->out($this->Utility->retrieveNumberFromString($string));
        }
    }
}
