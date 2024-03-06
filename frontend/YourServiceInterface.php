<?php

namespace frontend;
use MyApp\Proto\HelloWorld;
interface YourServiceInterface
{
    public function yourMethod(HelloWorld $request): HelloWorld;
}