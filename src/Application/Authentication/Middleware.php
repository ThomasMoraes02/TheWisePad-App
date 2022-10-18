<?php 
namespace TheWisePad\Application\Authentication;

interface Middleware
{
    public function handle($request);
}