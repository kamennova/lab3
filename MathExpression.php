<?php

class MathExpression
{
    private static $operators_pri = [
        '(' => 0,
        ')' => 0,
        '+' => 2,
        '-' => 3,
        '*' => 4,
        '/' => 4,
        '^' => 5,
    ];

    static public function calculate($input)
    {
        $output = self::get_expression($input);
        $result = self::postfix_calc($output);
        echo ' = ' . $result . "\n";
        return $result;
    }

    public function get_expression($string)
    {
        $output = '';
        $op_stack = new Stack;

        for ($i = 0, $len = strlen($string); $i < $len; $i++) {

            // skip delimiters
            if (self::is_delimiter($string[$i])) {
                continue;
            }

            // read number
            $number = '';
            if (ctype_digit($string[$i])) {

                while (ctype_digit($string[$i])) {
                    $number .= $string[$i];
                    $i++;
                    if ($i == $len) break;
                }

                $i--;

                $output .= $number . ' ';
            }

            if (self::is_operator($string[$i])) {
                if ($string[$i] == '(') {
                    $op_stack->push($string[$i]);
                } else if ($string[$i] == ')') {
                    $out = '';
                    $op_stack->pop($out);

                    while ($out !== '(') {
                        $output .= $out . ' ';
                        $op_stack->pop($out);
                    }
                } else {
                    if ($op_stack->get_length() > 0 && self::get_priority($string[$i]) <= self::get_priority($op_stack->get_top())) {
                        $out = '';
                        $op_stack->pop($out);
                        $output .= $out . ' ';
                    }
                    $op_stack->push($string[$i]);

                }
            }
        }

        $out = '';

        while ($op_stack->pop($out)) {
            $output .= $out . ' ';
        }

        return $output;
    }

    static public function postfix_calc($output)
    {
        $temp = new Stack;

        for ($i = 0; $i < strlen($output); $i++) {
            $symbol = $output[$i];

            if (ctype_digit($symbol)) {
                $number = '';
                while (ctype_digit($output[$i])) {

                    $number .= $output[$i];
                    $i++;
                    if ($i == strlen($output)) break;
                }

                $i--;
                $temp->push($number);

            } else if (self::is_operator($output[$i])) {
                $a = 0;
                $b = 0;
                $temp->pop($a);
                $temp->pop($b);

                $res = 0;
                switch ($output[$i]) {
                    case '+':
                        $res = $a + $b;
                        break;
                    case '-':
                        $res = $b - $a;
                        break;
                    case '*':
                        $res = $b * $a;
                        break;
                    case '/':
                        $res = $b / $a;
                        break;
                    case '^':
                        $res = pow($b, $a);
                        break;
                    default:
                        break;
                }

                $temp->push($res);
            }
        }

        return $temp->top->data;
    }

    // ---

    static private function is_delimiter($char)
    {
        if ($char == '=' || $char == ' ') return true;
        return false;
    }


    static private function is_operator($char)
    {
        return isset(self::$operators_pri[$char]);
    }

    static private function get_priority($op)
    {
        return self::$operators_pri[$op];
    }
}