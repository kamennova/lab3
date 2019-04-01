<?php

class Elem
{
    public $data;
    public $next;
}

class Stack
{
    public $top;

    function __construct()
    {
        $this->top = null;
    }

    function push($data)
    {
        $temp = new Elem;
        $temp->data = $data;
        $temp->next = $this->top;
        $this->top = $temp;
    }

    function pop(&$out)
    {
        if (!$this->top) {
            return false;
        }

        $out = $this->top->data;
        if (!$this->top->next) {
            $this->top = null;
        } else {
            $this->top = $this->top->next;
        }

        return true;
    }

    function get_top()
    {
        return $this->top->data;
    }

    function get_length()
    {
        $len = 0;

        if ($curr = $this->top) {
            while ($curr) {
                $len++;
                $curr = $curr->next;
            }

            return $len;
        }

        return $len;
    }
}