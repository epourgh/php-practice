<?php

namespace App;

class Test
{
    public function reverseString($str)
    {
        return strrev($str);
    }

    public function websiteNavigation($sequence)
    {

        $steps = [];

        if (count($sequence) == 0) {
            return $steps = [''];
        }

        foreach ($sequence as $step) {
            if (isset($step)) {
                switch ($step) {
                    case 'enter home page':
                        array_unshift($steps, "/index.php");
                        break;
                    case 'click to login page':
                        array_unshift($steps, "/login.php");
                        break;
                    case 'submit login credentials':
                        array_unshift($steps, "Form Action Processing");
                        break;
                    case 'redirect to index page successfully':
                        array_unshift($steps, "/index.php?user=true");
                        break;
                    case 'unsuccessful login':
                        array_unshift($steps, "/login.php?error=true");
                        break;
                }
            }
        }
    }
}
